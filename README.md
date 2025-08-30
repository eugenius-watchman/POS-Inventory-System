# POS Inventory System

A comprehensive Point of Sale (POS) and Inventory Management System built with PHP using the Model-View-Controller (MVC) architectural pattern.

## 🏗️ MVC Architecture

This application follows the MVC design pattern for separation of concerns and maintainability:

### 📁 Project Structure
pos/
├── controllers/ # Controller layer - Business logic
│ ├── categories.controller.php
│ ├── clients.controller.php
│ ├── products.controller.php
│ ├── sales.controller.php
│ └── users.controller.php
├── models/ # Model layer - Data handling
│ ├── categories.model.php
│ ├── clients.model.php
│ ├── products.model.php
│ ├── sales.model.php
│ └── users.model.php
├── views/ # View layer - Presentation
│ ├── modules/ # Various application modules
│ ├── js/ # JavaScript files
│ └── img/ # Images and assets
├── ajax/ # AJAX handlers for async operations
└── extensions/ # Third-party libraries (TCPDF, etc.)

text

### 🔄 MVC Flow
1. **Model**: Handles data operations and database interactions
2. **View**: Presents data to users and collects user input  
3. **Controller**: Processes requests, interacts with models, and returns views

## 🚀 Features
- Inventory Management with CRUD operations
- Sales Processing and Transaction Management
- User Management with Role-based Access
- Client/Customer Management
- Real-time Reporting and Analytics
- PDF Invoice Generation (TCPDF)
- Responsive Web Interface

## 🛠️ Technologies Used
- **Backend**: PHP 7.4+ with MVC Architecture
- **Frontend**: HTML5, CSS3, JavaScript, jQuery, Bootstrap
- **Database**: MySQL
- **PDF Generation**: TCPDF Library
- **Charts**: Chart.js for analytics and reporting

## 📦 Installation
1. Clone the repository:
```bash
git clone https://github.com/eugenius-watchman/POS-Inventory-System.git
Set up your web server (Apache/Nginx) to serve the project directory

Import the database schema from database/ directory

Configure database connection in config/ files

Set proper permissions for uploads directory:

bash
chmod -R 755 views/img/
🔧 Configuration
Update database credentials in the configuration files:

Database host, name, username, and password

Application settings and constants

📊 Database Schema
The system uses normalized database tables including:

users - System users and administrators

products - Product inventory and details

sales - Sales transactions and records

clients - Customer information

categories - Product categorization

🤝 Contributing
Fork the repository

Create a feature branch: git checkout -b feature-name

Commit changes: git commit -m 'Add feature'

Push to branch: git push origin feature-name

Submit a pull request

📝 License
This project is proprietary software. All rights reserved.

🆘 Support
For support and documentation, please refer to the code comments or create an issue in the repository.
