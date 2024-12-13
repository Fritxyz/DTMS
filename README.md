# Document Tracking System

## Description
The Document Tracking System is a web-based application designed to manage and track the status of uploaded documents. The system provides features for researchers and administrators, including file uploads, approvals, and detailed document history.

## Tools Used
- **Backend:** PHP, CodeIgniter 4
- **Frontend:** HTML, CSS, Bootstrap, JavaScript
- **Charts & Modals:** Chart.js, SweetAlert
- **Database:** MySQL

## Features
1. **User Authentication:**
   - Users can register and log in as either a researcher or an admin.
2. **File Management:**
   - Researchers can upload files.
   - Both researchers and admins can download or delete files.
3. **File Approval:**
   - Admins can approve or reject uploaded files.
4. **Document Tracking:**
   - Users can track when a document was uploaded and whether it has been approved or rejected.
5. **Visual Insights:**
   - Graphs are generated using Chart.js to display document status and other metrics.

## Database Schema

### Database Name: `dtms`

#### Tables:
1. **`documents`**
   - `id` (INT, PK): Document ID
   - `document_name` (VARCHAR(255)): Document name
   - `file_name` (TEXT): Uploaded file name
   - `uploaded_at` (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP): Upload timestamp
   - `status` (ENUM('pending', 'approved', 'rejected'), DEFAULT 'pending'): Document status
   - `user_id` (INT): References `users.id`

2. **`document_history`**
   - `id` (INT, PK): History record ID
   - `document_id` (INT): References `documents.id`
   - `user_id` (INT): References `users.id`
   - `uploaded_at` (TIMESTAMP): Timestamp when the document was uploaded
   - `changed_status_at` (TIMESTAMP): Timestamp when the status was changed

3. **`users`**
   - `id` (INT, PK): User ID
   - `first_name` (VARCHAR(255)): First name
   - `last_name` (VARCHAR(255)): Last name
   - `username` (VARCHAR(255)): Username
   - `password` (VARCHAR(255)): Password (hashed)
   - `role` (ENUM('researcher', 'admin')): User role

## Database Initialization Script
```sql
CREATE DATABASE dtms;

USE dtms;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('researcher', 'admin') NOT NULL
);

CREATE TABLE documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    document_name VARCHAR(255) NOT NULL,
    file_name TEXT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE document_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    document_id INT NOT NULL,
    user_id INT NOT NULL,
    uploaded_at TIMESTAMP NOT NULL,
    changed_status_at TIMESTAMP,
    FOREIGN KEY (document_id) REFERENCES documents(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

## Installation
1. Clone the repository.
2. Configure the `.env` file with your database credentials.
3. Run the provided SQL script to initialize the database.
4. Start the server and access the application in your browser.

# CodeIgniter 4 Framework

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds the distributable version of the framework.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Contributing

We welcome contributions from the community.

Please read the [*Contributing to CodeIgniter*](https://github.com/codeigniter4/CodeIgniter4/blob/develop/CONTRIBUTING.md) section in the development repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

## License
This project is open-source and available under the [MIT License](LICENSE).
