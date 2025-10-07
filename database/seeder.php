<?php

declare(strict_types=1);

use App\Config\Config;
use App\Core\Database\Database;

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Check if file exists
$dataFile = __DIR__ . '/data.json';
if (!file_exists($dataFile)) {
    die("Data file not found: $dataFile");
}

// Read data from file
$json = file_get_contents($dataFile);
$data = json_decode($json, true);
if ($data === null) {
    die("Invalid JSON data.");
}

$config = new Config($_ENV);
$db = new Database($config->db ?? []);
$pdo = $db->getConnection();
echo ("Database connected successfully." . PHP_EOL);

echo ("Starting database seeding process..." . PHP_EOL);
try {
    // Start transaction
    $pdo->beginTransaction();

    // 1. Seed Categories
    echo ("Seeding categories..." . PHP_EOL);
    $insertCategoryStmt = $pdo->prepare(
        "INSERT INTO category (name) VALUES (:name)
         ON DUPLICATE KEY UPDATE name = name"
    );
    foreach ($data['data']['categories'] as $category) {
        $insertCategoryStmt->execute([':name' => $category['name']]);
    }
    echo ("Categories seeded successfully!" . PHP_EOL);

    // Build category map: name => id
    $categoryMap = [];
    $stmt = $pdo->query("SELECT id, name FROM category");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categoryMap[$row['name']] = $row['id'];
    }

    // 2. Seed Brands
    echo ("Seeding brands..." . PHP_EOL);
    // Collect brand names from products.
    $brands = [];
    foreach ($data['data']['products'] as $product) {
        $brands[$product['brand']] = true;
    }
    $insertBrandStmt = $pdo->prepare(
        "INSERT INTO brand (name) VALUES (:name)
         ON DUPLICATE KEY UPDATE name = name"
    );
    foreach (array_keys($brands) as $brandName) {
        $insertBrandStmt->execute([':name' => $brandName]);
    }
    echo ("Brands seeded successfully!" . PHP_EOL);

    // Build brand map: name => id
    $brandMap = [];
    $stmt = $pdo->query("SELECT id, name FROM brand");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $brandMap[$row['name']] = $row['id'];
    }

    // 3. Seed Currency (Assuming only USD for now)
    echo ("Seeding currencies..." . PHP_EOL);
    $insertCurrencyStmt = $pdo->prepare(
        "INSERT INTO currency (symbol, label) VALUES (:symbol, :label)
         ON DUPLICATE KEY UPDATE symbol = symbol"
    );
    // Insert USD if not exists.
    $insertCurrencyStmt->execute([
        ':symbol' => '$',
        ':label' => 'USD'
    ]);
    echo ("Currencies seeded successfully!" . PHP_EOL);

    // Build currency map
    $currencyMap = [];
    $stmt = $pdo->query("SELECT id, label FROM currency");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $currencyMap[$row['label']] = $row['id'];
    }

    // 4. Seed Products, Galleries, Prices, Attribute Sets, Attributes, and Product_Attributes
    echo ("Preparing to seed products, galleries, prices, attributes..." . PHP_EOL);
    $insertProductStmt = $pdo->prepare(
        "INSERT INTO product (id, name, in_stock, description, category_id, brand_id)
         VALUES (:id, :name, :in_stock, :description, :category_id, :brand_id)"
    );

    $insertGalleryStmt = $pdo->prepare(
        "INSERT INTO gallery (url, product_id)
         VALUES (:url, :product_id)"
    );

    $insertPriceStmt = $pdo->prepare(
        "INSERT INTO price (amount, currency_id, product_id)
         VALUES (:amount, :currency_id, :product_id)"
    );

    $insertAttributeSetStmt = $pdo->prepare(
        "INSERT INTO attribute_set (id, name, type)
         VALUES (:id, :name, :type)
         ON DUPLICATE KEY UPDATE name = name"
    );

    $insertAttributeStmt = $pdo->prepare(
        "INSERT INTO attribute (id, value, display_value, attribute_set_id)
         VALUES (:id, :value, :display_value, :attribute_set_id)
         ON DUPLICATE KEY UPDATE value = :value_update"
    );

    $insertProductAttributeStmt = $pdo->prepare(
        "INSERT INTO product_attribute (product_id, attribute_id, attribute_set_id)
         VALUES (:product_id, :attribute_id, :attribute_set_id)
         ON DUPLICATE KEY UPDATE product_id = product_id"
    );

    foreach ($data['data']['products'] as $product) {
        echo ("Seeding product: " . $product['name']);

        // Map category and brand using the maps built above.
        $categoryName = $product['category'];
        $categoryId = $categoryMap[$categoryName] ?? null;
        $brandId = $brandMap[$product['brand']] ?? null;
        // Insert product
        $insertProductStmt->execute([
            ':id' => $product['id'],
            ':name' => $product['name'],
            ':in_stock' => $product['inStock'] ? 1 : 0,
            ':description' => $product['description'],
            ':category_id' => $categoryId,
            ':brand_id' => $brandId
        ]);

        // Insert galleries
        if (!empty($product['gallery'])) {
            foreach ($product['gallery'] as $url) {
                $insertGalleryStmt->execute([
                    ':url' => $url,
                    ':product_id' => $product['id']
                ]);
            }
        }

        // Insert prices (assuming one price per product)
        if (!empty($product['prices'])) {
            foreach ($product['prices'] as $price) {
                $currencyLabel = $price['currency']['label'];
                $currencyId = $currencyMap[$currencyLabel] ?? null;
                $insertPriceStmt->execute([
                    ':amount' => $price['amount'],
                    ':currency_id' => $currencyId,
                    ':product_id' => $product['id']
                ]);
            }
        }

        // Seed attributes: iterate over attribute sets for the product.
        if (!empty($product['attributes'])) {
            foreach ($product['attributes'] as $attrSet) {
                // Insert attribute_set record.
                $attrSetId = $attrSet['id']; // e.g., "Size" or "Color"
                $insertAttributeSetStmt->execute([
                    ':id' => $attrSetId,
                    ':name' => $attrSet['name'],
                    ':type' => $attrSet['type']
                ]);

                // For each attribute item in the set.
                if (!empty($attrSet['items'])) {
                    foreach ($attrSet['items'] as $attr) {
                        // Insert attribute item.
                        $insertAttributeStmt->execute([
                            ':id' => $attr['id'],
                            ':value' => $attr['value'],
                            ':display_value' => $attr['displayValue'],
                            ':attribute_set_id' => $attrSetId,
                            ':value_update' => $attr['value']
                        ]);

                        // Create mapping in product_attributes table.
                        $insertProductAttributeStmt->execute([
                            ':product_id' => $product['id'],
                            ':attribute_id' => $attr['id'],
                            ':attribute_set_id' => $attrSetId
                        ]);
                    }
                }
            }
        }

        echo ("Product seeded successfully: " . $product['name']);
    }

    // Commit transaction
    $pdo->commit();

    echo ("Seeding process completed!" . PHP_EOL);
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error seeding data: " . $e->getMessage() . "\n";
} finally {
    $db->disconnect();
    echo ("Database connection closed." . PHP_EOL);
}
