<img width="1456" height="720" alt="microsite management" src="https://github.com/user-attachments/assets/9b1d92dc-5580-43df-abcb-0e32b46b0ac2" />


# 🌐 Microsite Management System

![Laravel](https://img.shields.io/badge/Laravel-Framework-FF2D20?style=for-the-badge\&logo=laravel\&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge\&logo=php\&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge\&logo=mysql\&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-Markup-E34F26?style=for-the-badge\&logo=html5\&logoColor=white)
![MVC](https://img.shields.io/badge/Architecture-MVC-success?style=for-the-badge)
![Apache](https://img.shields.io/badge/Server-Apache-D22128?style=for-the-badge\&logo=apache\&logoColor=white)

A secure **Microsite Management System** built using **Laravel**, **PHP**, **MySQL**, and **HTML**, following the **Model-View-Controller (MVC)** architecture. The application provides a centralized platform for administrators to manage clubs, products, and categories while enabling each club to create exclusive microsites for their members.

The system is designed to automate account creation, email notifications, microsite access, and product ordering, ensuring that each club operates independently within a secure environment.

> **Note:** This repository showcases the application's features and architecture. Client-specific business logic and sensitive implementation details have been intentionally omitted to maintain confidentiality.

---

# 📌 Overview

The application follows a hierarchical workflow consisting of three user roles:

* **Administrator**
* **Club**
* **Club Member**

Each role has dedicated permissions to ensure secure access and proper management of the platform.

---

# ✨ Key Features

* Role-Based Access Control (RBAC)
* Secure Authentication
* Club Management
* Product & Category Management
* Microsite Creation
* Member Management
* Automated Email Notifications
* Private Microsite Access
* Club-Specific Product Selection
* Order Placement
* Order History
* Secure Password Generation
* Club Data Isolation

---

# 👥 User Roles

## 🔷 Administrator

The Administrator is responsible for managing the complete system.

### Responsibilities

* Create and manage clubs
* Create product categories
* Add and manage products
* Generate club accounts
* Automatically generate secure passwords
* Send account credentials via email
* Monitor platform activities

---

## 🔷 Club

Each club has its own secure workspace.

### Responsibilities

* Login using administrator-provided credentials
* Create and manage club members
* Create multiple microsites
* Select products for each microsite
* Publish microsites
* Manage member access
* View orders received through their microsites

Whenever a new club member is created, the system automatically sends an email containing login credentials.

When a microsite is published, every authorized member receives:

* Secure Microsite URL
* Username
* Password
* Login Instructions

---

## 🔷 Club Member

Club Members have access only to the microsites assigned to their club.

### Capabilities

* Secure Login
* Access Private Microsites
* Browse Available Products
* Place Orders
* View Order History
* Track Previous Purchases

Members cannot access microsites belonging to any other club.

---

# 🔄 System Workflow

```text
Administrator
      │
      ├── Create Product Categories
      ├── Add Products
      ├── Create Clubs
      │
      ▼
Club Account Generated
      │
      └── Email with Login Credentials
      │
      ▼
Club Login
      │
      ├── Add Club Members
      ├── Create Microsites
      ├── Select Products
      └── Publish Microsite
      │
      ▼
Members Receive Email
      │
      ├── Private Microsite Link
      ├── Username
      └── Password
      │
      ▼
Member Login
      │
      ├── Browse Products
      ├── Place Orders
      └── View Order History
```

---

# 🛒 Product Management

The Administrator maintains a centralized product catalog.

### Administrator

* Create Product Categories
* Add Products
* Update Product Information
* Remove Products

### Club

* Select products for individual microsites
* Display only relevant products to members
* Manage product availability within their microsites

This architecture allows different clubs to offer different product selections while using the same centralized inventory.

---

# 📧 Automated Email Notifications

The application automatically sends emails during important events.

### Club Account Creation

* Username
* Password
* Login Instructions

### Club Member Registration

* Member Credentials
* Welcome Email

### Microsite Publication

* Private Microsite URL
* Username
* Password
* Access Instructions

This automated communication minimizes manual administration and improves the onboarding process.

---

# 🔒 Security Features

Security is a core component of the application.

Implemented security measures include:

* Role-Based Authorization
* Secure Authentication
* Password-Protected Access
* Club-Level Data Isolation
* Private Microsite URLs
* Restricted Cross-Club Access
* Controlled Product Visibility
* Secure Session Management

Only authorized members belonging to a specific club can access that club's microsites.

---

# 🧩 Core Modules

* Authentication Module
* Administrator Dashboard
* Club Management
* Club Member Management
* Product Management
* Category Management
* Microsite Management
* Order Management
* Order History
* Email Notification Module

---

# 🏗️ Technology Stack

| Component    | Technology                  |
| ------------ | --------------------------- |
| Backend      | Laravel                     |
| Language     | PHP                         |
| Database     | MySQL                       |
| Frontend     | HTML, CSS, JavaScript       |
| Architecture | MVC (Model-View-Controller) |
| Web Server   | Apache                      |

---

# 📂 High-Level Architecture

```text
                +--------------------+
                |    Administrator   |
                +---------+----------+
                          |
                          |
          +---------------+---------------+
          |                               |
          ▼                               ▼
   Product Management             Club Management
          |                               |
          +---------------+---------------+
                          |
                          ▼
                  Club Dashboard
                          |
      +-------------------+------------------+
      |                                      |
      ▼                                      ▼
Member Management                  Microsite Management
      |                                      |
      +-------------------+------------------+
                          |
                          ▼
               Product Selection
                          |
                          ▼
                 Email Notifications
                          |
                          ▼
                  Club Members
                          |
                          ▼
              Browse • Order • History
```

---

# 🚀 Deployment

The application is deployed on an **Apache Web Server** and follows Laravel's standard MVC architecture.

Typical deployment environment:

* Apache HTTP Server
* PHP
* Laravel Framework
* MySQL Database

---

# 🎯 Project Highlights

* Multi-Tenant Club Management
* Secure Role-Based Authentication
* Automated Email Communication
* Dynamic Microsite Generation
* Private Club-Specific Access
* Centralized Product Management
* Club-Based Product Selection
* Order Management System
* Purchase History Tracking
* Scalable MVC Architecture

---

# 📈 Future Enhancements

* Responsive Mobile Interface
* Payment Gateway Integration
* Advanced Reporting & Analytics
* Inventory Management
* QR Code-Based Microsite Access
* Multi-language Support
* Notification Dashboard
* REST API Integration

---

# 📄 Disclaimer

This repository has been created for portfolio and demonstration purposes. To protect client confidentiality, proprietary business logic, sensitive workflows, and implementation-specific details have been intentionally excluded.

---

# 👨‍💻 Author

**Pauljo George**

If you found this project helpful or interesting, consider giving it a ⭐ on GitHub.
