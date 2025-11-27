# Click&Rent

**Click&Rent** is a web-based equipment rental management platform built with PHP using the MVC (Model-View-Controller) pattern. It allows users to browse available equipment, submit loan requests, and track their rentals, while administrators manage inventory, validate requests, and handle returns.
​
## Features
- User and admin authentication with role-based access
- Equipment catalog with details (status, photos, descriptions)
- Loan request form with start and end dates
- User area with active loans and loan history
- Admin dashboard for validating/refusing requests and managing returns
- CRUD management for equipment (add, edit, delete)

​## Tech Stack
- PHP (MVC architecture)
- MariaDB (or MySQL compatible)
- HTML, CSS, JavaScript
- Git/GitHub for version control

## Project Structure
- controllers/ – Handles requests and application flow
- models/ – PHP classes for User, Material, Loan and database logic
- views/ – Pages such as home, catalogue, account, dashboard, loan history, auth, admin, cart
- config/ – Configuration and environment files
- database/ – Migrations and database scripts
- public/ – Public entry point (index.php) and assets

## Getting Started
- Clone the repository.
- Create a MySQL database and import the provided SQL or run the migrations.
- Configure database access in the config files.
- Point your web server document root to the public/ folder.
- Access the site in your browser and create your first user/admin account.
