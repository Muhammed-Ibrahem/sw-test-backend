# 🧩 Scandiweb Backend

This branch is for **local setup and development**.  
It includes database seed scripts and schema files for easy testing.

---

## 🧱 Project Setup

### 1️⃣ Clone the repository

```bash
git clone https://github.com/Muhammed-Ibrahem/sw-test-backend.git
cd <project folder>
git checkout dev
```

### 2️⃣ Requirements

- PHP
- MySQL
- Composer

---

## 🗃 Database Setup

Inside the `/database` folder:

```
database/
 ┣ schema.sql     → Database structure
 ┣ seeder.php     → Populates tables with mock data
 ┗ data.json      → Contains the seed data
```

## ⚙️ Environment Variables

Create a `.env` file in the project root:

```env
DB_HOST=
DB_PORT=
DB_NAME=
DB_USER=
DB_PASSWORD=
ALLOWED_ORIGINS=http://localhost:5173
ENVIRONMENT=DEVELOPMENT
```

---

### Create & Seed

1. Create an empty database.
2. Import the schema:
   ```bash
   mysql -u root -p [DatabaseName] < database/schema.sql
   ```
3. Run the seeder:
   ```bash
   php database/seeder.php
   ```
   This reads from `data.json` and populates the tables.
   Make sure the `.env` file is created and have the required values

---

## 🧩 Running the Server

Start the built-in PHP server:

```bash
php -S localhost:8080 -t public
```

GraphQL will now be available at:

```
http://localhost:8080/graphql
```

---

## 🧪 Example Query

```graphql
query {
  categories {
    id
    name
  }
}
```

---

## 🧠 Tips

- Use MySQL Workbench to connect and inspect your local database.
- Make sure your PHP extensions include `pdo_mysql`.

---
