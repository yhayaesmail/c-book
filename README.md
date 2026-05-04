```
# C-Books

C-Books is a full‑stack web application for an independent online bookstore with integrated reader club features.  
The system enables guests to browse and search a catalog of books, while registered users can manage a persistent shopping cart, simulate a checkout process, view their order history, and submit reviews for purchased titles.  
Community functionality includes creating and joining reading clubs, voting on the next club book, tracking a yearly reading challenge, and earning achievement badges.  
Administrators have access to inventory management, user oversight, order updates, and a set of analytical reports.

The project is built with a custom **Model‑View‑Controller** architecture using **PHP**, **MySQL**, **HTML**, **CSS**, and **vanilla JavaScript**.  
No external frameworks or libraries are used beyond the native PDO database layer. It runs on **XAMPP** (Apache and MySQL) and is suitable for academic capstone submissions or as a portfolio piece.

---

## Table of Contents

- [Features](#features)
- [Architecture](#architecture)
- [Technology Stack](#technology-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Usage](#usage)
- [Folder Structure](#folder-structure)
- [Database Schema](#database-schema)
- [Routing and Controllers](#routing-and-controllers)
- [Security](#security)

---

## Features

### For Guests
- Browse the full book catalog
- Search by title or author with live suggestion dropdown
- Filter books by genre using a sidebar
- View detailed book pages including description, price, and community ratings

### For Registered Users
- Secure registration and login with session management
- Add items to a shopping cart (AJAX, no page reload)
- Modify quantities and remove items from the cart
- Checkout flow with simulated shipping address and credit card entry
- Order history with status tracking
- Submit 1–5 star reviews only for purchased books
- Reading clubs:
  - Create new clubs (public or private)
  - Join existing clubs
  - Vote for the next book to read
- Yearly reading challenge with goal setting and progress tracking
- Achievement system (badges awarded automatically for key actions)
- Dynamic membership discounts (none / basic / premium)

### For Administrators
- Dashboard with system overview
- CRUD management for books (title, author, genre, price, stock, cover image)
- User management (toggle account status, promote/demote)
- Order management (view all orders, change order status)
- Reports:
  - Top reviewed books
  - Sales by book
  - Sales by order status
- Reader of the Month spotlight (calculated from monthly activity)

---

## Architecture

The application employs a lightweight custom **MVC (Model‑View‑Controller)** structure.

- **Front Controller (`index.php`)** – Every HTTP request is routed through a single entry point. It parses the URL, determines the appropriate controller and action, and dispatches execution.
- **Controllers** – Controllers handle user input, interact with models, and load views.
- **Models** – Models contain all database queries (using prepared statements) and return data to controllers.
- **Views** – Views are plain PHP templates that render HTML; they receive data from controllers but contain no business logic.
- **Helpers** – Shared functions for authentication checks (`isLoggedIn`, `isAdmin`), input sanitisation, and role‑based access control.

Two additional design patterns are applied:
- **Role‑Based Access Control (RBAC)** – Admin routes are protected by a helper that verifies the current user has `role = 'admin'`.
- **Observer‑like Achievement System** – After certain actions (first purchase, club join, review), an achievement model is triggered to award badges if not already earned.

---

## Technology Stack

| Layer       | Technology                |
|-------------|---------------------------|
| Backend     | PHP (vanilla, no framework) |
| Database    | MySQL (PDO)               |
| Frontend    | HTML5, CSS3, Vanilla JavaScript |
| Web Server  | Apache (mod_rewrite)      |
| Environment | XAMPP                     |

---

## Prerequisites

- [XAMPP](https://www.apachefriends.org) (or Apache + MySQL + PHP 7.4+)
- A modern web browser
- Git (optional, for cloning)

---

## Installation

1. **Clone or download the repository** into the `htdocs` folder of your XAMPP installation:
   ```bash
   cd /path/to/xampp/htdocs
   git clone <repository-url> C-Books
   ```
   Or unzip the project archive into `htdocs/C-Books`.

2. **Start Apache and MySQL** via the XAMPP Control Panel.

3. **Create the database**:
   - Open phpMyAdmin (`http://localhost/phpmyadmin`).
   - Create a new database named `mbooks` (utf8mb4_general_ci).
   - Import the provided SQL file (`database.sql`) from the project root.

4. **Configure the connection**:
   - Open `config/database.php`.
   - Adjust `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` if your environment differs from the defaults.

5. **(Optional) Adjust the base URL**:
   - The constant `BASE_URL` in `config/database.php` is set to `/C-Books`. Change it if your project folder has a different name.

6. **Access the application**:
   - Navigate to `http://localhost/C-Books` in your browser.

---

## Usage

### Default Admin Account
- **Email:** `admin@mbooks.com`
- **Password:** `admin123`

After logging in, administrators can visit `/admin/dashboard` to access inventory, users, orders, and reports.

### General User Flow
1. Register a new account (email verification is automatic – verified on creation).
2. Browse or search books; click a book to see details.
3. Add books to the cart (the cart icon in the navbar updates instantly).
4. Proceed to checkout; fill in shipping and (simulated) credit card details.
5. After placing the order, the cart is cleared and the order appears in the history.
6. Return to a purchased book to leave a review.
7. Explore reading clubs; join one and vote for upcoming reads.
8. Set a yearly reading challenge and log finished books.

---

## Folder Structure

```
C-Books/
├── .htaccess
├── index.php
├── config/
│   └── database.php
├── includes/
│   ├── helpers.php
│   ├── auth_check.php
│   └── role_check.php
├── controllers/
│   ├── AdminController.php
│   ├── AuthController.php
│   ├── BookController.php
│   ├── CartController.php
│   ├── ChallengeController.php
│   ├── ClubController.php
│   ├── ErrorController.php
│   ├── OrderController.php
│   └── ReviewController.php
├── models/
│   ├── Achievement.php
│   ├── Book.php
│   ├── Cart.php
│   ├── Club.php
│   ├── Order.php
│   ├── ReaderSpotlight.php
│   ├── Report.php
│   ├── Review.php
│   └── User.php
├── views/
│   ├── layouts/
│   │   ├── header.php
│   │   └── footer.php
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   ├── books/
│   │   ├── home.php
│   │   ├── browse.php
│   │   ├── details.php
│   │   └── partials_card.php
│   ├── cart/
│   │   └── index.php
│   ├── orders/
│   │   ├── checkout.php
│   │   └── history.php
│   ├── clubs/
│   │   ├── list.php
│   │   ├── create.php
│   │   ├── view.php
│   │   └── challenges.php
│   ├── admin/
│   │   ├── dashboard.php
│   │   ├── books.php
│   │   ├── users.php
│   │   ├── orders.php
│   │   └── reports.php
│   └── errors/
│       ├── 403.php
│       └── 404.php
├── assets/
│   ├── css/
│   │   ├── style.css
│   │   └── book-details.css
│   ├── js/
│   │   └── main.js
│   └── images/
│       ├── book-placeholder.svg
│       └── (book cover images)
```

---

## Database Schema

The MySQL database (`mbooks`) consists of the following tables:

- **users** – accounts, roles, membership type
- **books** – product catalogue
- **cart_items** – persistent shopping cart
- **orders** – placed orders
- **order_items** – line items within an order
- **reviews** – user ratings and reviews (unique per user per book if purchased)
- **clubs** – reading clubs
- **club_members** – many‑to‑many relationship between users and clubs
- **votes** – user votes for books inside clubs
- **challenges** – yearly reading goals per user
- **reading_log** – records of finished books
- **achievements** – defined badges
- **user_achievements** – awarded badges to users

A full Entity‑Relationship Diagram (ERD) is available in the documentation package.

---

## Routing and Controllers

All requests are handled by `index.php` using Apache `mod_rewrite`. The `.htaccess` file rewrites URLs to `index.php?url=...`.

The router extracts the requested path and calls the appropriate controller and method. For example:

- `GET /books/details/5` maps to `BookController::details(5)`
- `GET /cart/add/3` maps to `CartController::add(3)`
- `GET /admin/books` maps to `AdminController::books()`

If a controller or method does not exist, a 404 error is returned.

---

## Security

- **Password hashing** uses `password_hash()` with bcrypt (cost 10).
- **All database queries** use PDO prepared statements to prevent SQL injection.
- **Role verification** (`requireAdmin()`) prevents unauthorized access to administrative pages.
- Input is sanitised via a helper function (`htmlspecialchars(trim(...))`).
```
