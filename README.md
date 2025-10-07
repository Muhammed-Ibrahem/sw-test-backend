# 🧩 Scandiweb Backend

This is the backend for the Scandiweb developer test, built with **PHP**, **GraphQL**, and **MySQL**.

---

## 🚀 Project Overview

The backend exposes a GraphQL API for products, categories, attributes, and prices,..etc.

### Tech Stack

- **Language:** PHP
- **Framework:** Custom lightweight GraphQL server (webonyx/graphql-php)
- **Database:** MySQL

---

## 📡 API Endpoint

**Base URL:**

```
https://sw-test-backend-production.up.railway.app
```

**GraphQL Endpoint:**

```
POST /graphql
```

### Example Query

```graphql
query {
  product(id: "ps-5") {
    id
    name
    description
  }
}
```

---

## 📂 Project Structure

```
src/
 ┣ Core/              → Core utilities (Logger, Container, etc.)
 ┣ Domains/           → Domain-driven modules (Category, Product, etc.)
 ┣ GraphQL/           → Schema, resolvers, and controllers
 ┗ App.php            → App bootstrap entry
public/
 ┗ index.php          → Application entry point
composer.json         → Dependencies
```

## 🧠 Notes

- This branch contains **only the runtime code** (no seeders or development data).
- If you want to run the project locally, switch to the **`dev`** branch and follow the setup instructions provided in its README file.  
  That branch contains the necessary database files (`schema.sql`, `seeder.php`, `data.json`) and local environment configuration steps.
