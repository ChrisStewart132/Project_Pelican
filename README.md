```markdown
# Pelican - Modular AI Prompt Compiler

## Executive Summary
Pelican is a lightweight, full-stack web application designed specifically for software architects (both human and AI). It streamlines **prompt engineering and generation** by allowing users to compile precise, modular AI instructions. 

Instead of writing monolithic prompts, architects can select a System prompt, an Architect persona, a Project specification, and various abstract **Code Interfaces** (e.g., Grid Based World, Rigid Body Physics). Pelican automatically resolves module dependencies and compiles a comprehensive, ready-to-use AI transcript prompt to generate clean, decoupled, and scalable code.

## Features
* **Modular Architecture**: Mix and match System, Architect, and Project prompts.
* **Code Interfaces**: Define abstract API contracts for AI to follow.
* **Smart Dependency Resolution**: Selecting a code interface automatically selects its required dependencies.
* **Admin Dashboard**: Built-in GUI to safely Create and Edit prompts/interfaces.
* **Lightweight**: Pure HTML/JS frontend with a secure PHP/PDO backend. No heavy frameworks required.

---

## Installation & Setup

Pelican is designed to run on a standard **LAMP Stack** (Linux, Apache, MySQL, PHP) and deploys flawlessly on shared hosting environments like **Hostinger**.

### 1. Database Setup
1. Log into your hosting control panel (e.g., Hostinger hPanel) or local phpMyAdmin.
2. Create a new MySQL database and user.
3. Import the provided `setup.sql` file into your new database. This will create the required tables and insert default seed data.

### 2. File Deployment
1. Upload the contents of the `public_html/` folder to your web server's public directory.
2. Ensure your server runs PHP 7.4 or higher.

### 3. Configuration
1. In your `public_html/` directory, locate the file named `config.example.php`.
2. Rename this file to `config.php`. *(Note: `config.php` is tracked in `.gitignore` to keep your credentials safe).*
3. Open `config.php` and update it with your database credentials and a secure admin password:
   ```php
   $host = '127.0.0.1'; // or localhost
   $db   = 'your_database_name';
   $user = 'your_database_user';
   $pass = 'your_database_password';
   
   // Set a secure password for the Admin Panel
   $admin_secret = 'super_secret_password_here'; 
   ```

---

## Usage

### The Compiler (Frontend)
Navigate to `yourdomain.com/index.html`. Select your prompts and required interfaces from the sidebar. The final, dependency-resolved prompt will generate in the main window, ready to be copied and pasted into your LLM of choice.

### The Admin Panel (Backend Data Management)
Navigate to `yourdomain.com/admin.html` to access the data management GUI.
* **Authentication**: You must enter the `$admin_secret` you defined in your `config.php` file to save changes.
* **Create/Edit**: Use the radio toggle to switch between creating new entries and editing existing ones.
* **Dependencies**: When creating a "Code Interface", you can enter a comma-separated list of Interface IDs that module relies on (e.g., `1, 4`).

---

## Coming Soon
* **Demo Creations**: A showcase of fully functional project apps generated entirely using Pelican-compiled prompts.
```