# 🍽️ Online University Canteen Management System

A PHP-based canteen management system built for university use. It supports multiple user roles with role-specific features for **Students**, **Faculty**, **Staff**, and **Admin**.

---

## ⚙️ How to Run Locally (Using XAMPP)

1. Clone or download the project to your local machine.
2. Place the project folder inside:  
   `C:\xampp\htdocs\OnlineUniversityCanteen`
3. Start **Apache** and **MySQL** from the **XAMPP Control Panel**.
4. Open **phpMyAdmin** at [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
5. Create a database named: `canteen_db`
6. Import the provided SQL file:  
   `canteen_db.sql` (included in the project root).
7. Open your browser and go to:  
   [http://localhost/OnlineUniversityCanteen](http://localhost/OnlineUniversityCanteen)
8. Log in using test credentials or register as a new user.

---

## 👥 User Roles

### 🧑‍🎓 Student
- View profile & edit personal info
- Browse multiple canteens & menu items
- Place orders & pick up from counter
- View invoices and order history
- Use vouchers and discounts

### 🧑‍🏫 Faculty
- All student features
- Additional feature: Room delivery

### 🧑‍🔧 Staff
- Manage canteens and food items
- Handle student/faculty orders
- Maintain stock and updates

### 🧑‍💼 Admin
- Assign staff to canteens
- Oversee overall system
- Manage users and permissions

---

## 🚀 Features

- Role-based login (Student, Faculty, Staff, Admin)
- Multiple canteens with special item support
- Real-time order tracking and invoice generation
- Voucher/discount system
- Room delivery option for faculty
- Order history view per user
- Responsive UI with clean navigation
- Easy to extend or integrate with payment gateway
