📚 Online Library Management System
The Online Library Management System is a web-based application developed using HTML, CSS, PHP, and MySQL. It is designed to automate and streamline library functions such as managing books, users, and borrowing records through a secure and user-friendly interface.

🔧 Key Features:
User-friendly frontend interface developed using HTML and CSS.

PHP handles all server-side operations including form submission, authentication, and dynamic page generation.

MySQL database stores all records including books, admin credentials, issued books, and return logs.

A secure Admin Login System is provided to authenticate administrators.

Admins can add, update, delete books from the library database.

Book details such as title, author, category, availability status, and ISBN are stored and displayed dynamically.

The Admin Panel also provides an overview of user activity, pending requests, and inventory control.

Prevents duplication and provides validation for key operations.

Simplifies the process of issuing and returning books with proper logging.

Designed for small to medium educational institutions, libraries, or individual use.

📁 Admin Table (MySQL)
The admin table includes:

admin_id (Primary Key)

admin_pass

role (for future scalability, e.g., SuperAdmin, Librarian)

Admins can log in securely to manage all backend functionalities like managing books, reviewing issue requests, and maintaining overall library data integrity.

🚀 Technologies Used
Frontend:

HTML5 – for structuring web content

CSS3 – for styling and responsive layout

Backend:

PHP – for server-side scripting and database interaction

MySQL – for storing all library and user data

🛠️ How to Run the Project

Install XAMPP / WAMP / MAMP (any local server environment)

Place the project folder inside the htdocs directory (for XAMPP).

Start Apache and MySQL services from the control panel.

Open phpMyAdmin, create a database (e.g., library_db) and import the provided .sql file.

Navigate to http://localhost/your_project_folder/ in your browser.

Login using default admin credentials (set in the admin table of the database).

👤 Admin Panel Features

Secure Login Authentication

Add / Update / Delete Book Records

View and Manage Book Inventory

Track Issued Books and Due Dates

Maintain Data Accuracy with Validations

/library-management/
│
├── /admin/         # Admin login and dashboard files
├── /includes/      # DB connection and helper PHP files
├── /css/           # Styling files
├── /js/            # JavaScript (if any)
├── /images/        # Book covers, icons, etc.
├── index.php       # Landing page
├── login.php       # User login
├── register.php    # User registration
└── db.sql          # SQL file to set up the database

📈 Future Scope

Implement email notifications for due books.

Add QR code/barcode scanning for physical book tagging.

Enable student/user login with book request and history tracking.

Add search, filter, and pagination for better navigation.

Use AJAX for dynamic, no-reload updates.

📸 Output Screenshots
Below are the output pictures of the Online Library Management System that demonstrate the design and functionality of various modules of the project. 
These screenshots provide a visual overview of how the system looks and operates.

🔐  Login Page – Secure login for admin users or the students  the login 

 ![Screenshot 2025-06-30 155003](https://github.com/user-attachments/assets/a3374711-ce29-4664-b7ba-c468ebff311f)

 📄 Book Listing Page – View all available books in the library

 ![Screenshot 2025-06-30 155412](https://github.com/user-attachments/assets/0505e49e-044b-4e00-854d-8918f32a2703)

 ✅ Issue/Return Page – Issue or return books with status tracking

 ![Screenshot 2025-06-30 155447](https://github.com/user-attachments/assets/50f8ab55-8ae7-410d-a02a-7d3bee7081c5)

📚 Book Management Panel – Interface to add, update, or delete books

![Screenshot 2025-07-01 080419](https://github.com/user-attachments/assets/7012a741-6aff-453f-a299-434c75a9202b)

🧾 Database View (phpMyAdmin) – Shows structure of admin and book tables

![Screenshot 2025-07-01 080334](https://github.com/user-attachments/assets/9bc8efdf-9f1b-4b7e-9b7c-9dcc4b1648c2)

✅ Final Declaration
This project titled “Online Library Management System” has been successfully developed using HTML, CSS, PHP, and MySQL. It fulfills the basic requirements of a digital library by allowing admins to manage book records efficiently through a secure web interface.

The system ensures a smooth flow of data between the frontend and backend, offering a reliable and scalable solution for small to medium-sized libraries. It serves as a great foundation for future enhancements such as user roles, notifications, and real-time tracking.

This project demonstrates the practical application of web technologies and database integration to solve real-world problems in library management.



