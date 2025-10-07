CREATE TABLE category (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE brand (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE product (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    in_stock BOOLEAN DEFAULT FALSE,
    category_id INT UNSIGNED NOT NULL,
    brand_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (category_id) REFERENCES category(id),
    FOREIGN KEY (brand_id) REFERENCES brand(id)
);

CREATE TABLE gallery (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    url VARCHAR(2083) NOT NULL,
    product_id VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

CREATE TABLE currency (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    label VARCHAR(10) UNIQUE NOT NULL,
    symbol VARCHAR(5) NOT NULL
);

CREATE TABLE price (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    amount DECIMAL(10, 2) NOT NULL,
    product_id VARCHAR(255) NOT NULL,
    currency_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE,
    FOREIGN KEY (currency_id) REFERENCES currency(id)
);

CREATE TABLE attribute_set (
	id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('text', 'swatch') NOT NULL
);

CREATE TABLE attribute (
	id VARCHAR(255) NOT NULL,
    display_value VARCHAR(255) NOT NULL,
    value VARCHAR(255) NOT NULL,
    attribute_set_id VARCHAR(255) NOT NULL,
    PRIMARY KEY (id, attribute_set_id),
    FOREIGN KEY (attribute_set_id) REFERENCES attribute_set(id) ON DELETE CASCADE
);

CREATE TABLE product_attribute (
    product_id VARCHAR(255) NOT NULL,
    attribute_id VARCHAR(255) NOT NULL,
    attribute_set_id VARCHAR(255) NOT NULL,
    PRIMARY KEY (product_id, attribute_id, attribute_set_id),
    FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE,
    FOREIGN KEY (attribute_id, attribute_set_id) REFERENCES attribute (id, attribute_set_id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    currency_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (currency_id) REFERENCES currency(id)
);

CREATE TABLE order_item (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id INT UNSIGNED NOT NULL,
    product_id VARCHAR(255) NOT NULL,
    quantity INT UNSIGNED NOT NULL DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL,
    currency_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id),
    FOREIGN KEY (currency_id) REFERENCES currency(id)
);

CREATE TABLE order_item_attribute (
    order_item_id INT UNSIGNED NOT NULL,
    attribute_id VARCHAR(255) NOT NULL,
    attribute_set_id VARCHAR(255) NOT NULL,
    PRIMARY KEY (order_item_id, attribute_id, attribute_set_id),
    FOREIGN KEY (order_item_id) REFERENCES order_item(id) ON DELETE CASCADE,
    FOREIGN KEY (attribute_id, attribute_set_id) REFERENCES attribute(id, attribute_set_id)
);

-- INDEXES
CREATE INDEX idx_product_category ON product(category_id);
CREATE INDEX idx_product_brand ON product(brand_id);
CREATE INDEX idx_gallery_product ON gallery(product_id);
CREATE INDEX idx_price_product ON price(product_id);
CREATE INDEX idx_attribute_set ON attribute(attribute_set_id);
CREATE INDEX idx_product_attribute_product ON product_attribute(product_id);
-- -----------------------------------------
CREATE INDEX idx_order_item_product ON order_item(product_id);