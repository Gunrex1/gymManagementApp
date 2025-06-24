# 🏋️‍♂️ Gym Management System

A modern, responsive gym management web application built with PHP, MySQL, HTML, and CSS. This system streamlines gym operations, allowing administrators to manage members, trainers, bookings, and more, all from a user-friendly dashboard.

---

## ✨ Features

- **Modern UI/UX:** Clean, responsive design for both admin and user interfaces
- **Member Management:** Register, view, and manage gym members
- **Trainer Management:** Add and manage trainers
- **Booking System:** Book and manage gym sessions
- **Authentication:** Secure login for users and admins
- **Admin Dashboard:** Overview of all gym activities and quick access to management features
- **Session Management:** Secure logout for users and admins
- **Database Integration:** MySQL backend for persistent data storage

---

## 🛠️ Technologies Used

- **Frontend:** HTML5, CSS3
- **Backend:** PHP (vanilla)
- **Database:** MySQL
- **Web Server:** Apache (XAMPP/MAMP/LAMP recommended)
- **Styling:** Custom CSS

---

## 📁 Project Structure

```
Gym_Management/
├── index.html                # Homepage
├── login.html                # User login page
├── registration.html         # User registration page
├── admin_login.html          # Admin login page
├── dashboard.php             # User dashboard
├── admin_dashboard.php       # Admin dashboard
├── members.php               # Manage members
├── trainers.php              # Manage trainers
├── bookings.php              # Manage bookings
├── header.php                # Common header
├── styles.css                # Stylesheet
├── login_process.php         # User login logic
├── registration_process.php  # User registration logic
├── admin_login_process.php   # Admin login logic
├── logout.php                # User logout
├── admin_logout.php          # Admin logout
├── user_logout.php           # User logout (duplicate for role separation)
├── databasepro.sql           # Database schema and sample data
├── [images]                  # Gym-related images
```

---

## 🚀 Getting Started

### Prerequisites

- A modern web browser
- [XAMPP](https://www.apachefriends.org/index.html) or similar (includes Apache, PHP, MySQL)
- Basic knowledge of PHP and MySQL

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/Gym_Management.git
   ```

2. **Move the project to your web server directory**
   - For XAMPP on Mac:
     ```bash
     mv Gym_Management /Applications/XAMPP/htdocs/
     ```

3. **Start Apache and MySQL**  
   Open XAMPP and start both services.

4. **Set up the database**
   - Open [phpMyAdmin](http://localhost/phpmyadmin)
   - Create a new database (e.g., `gym_management`)
   - Import `databasepro.sql` from the project folder

5. **Configure database connection (if needed)**
   - Check the PHP files for database credentials (host, user, password, db name)
   - Default for XAMPP:  
     - Host: `localhost`  
     - User: `root`  
     - Password: *(empty)*

6. **Access the application**
   - Open your browser and go to:  
     ```
     http://localhost/Gym_Management/
     ```

---

## 🔒 Authentication

- **User Login:** `/login.html`
- **Admin Login:** `/admin_login.html`
- **Session Management:** Secure login/logout for both roles

---

## 🎨 Customization

- **Branding:**  
  Update gym name, logo, and images in HTML files and `/images/` directory.
- **Styling:**  
  Modify `styles.css` for custom colors, fonts, and layout.
- **Database:**  
  Edit `databasepro.sql` to add or modify initial data.

---

## 📱 Features in Detail

- **Member Registration:**  
  New users can register and log in to book sessions.
- **Admin Dashboard:**  
  Admins can view and manage all members, trainers, and bookings.
- **Trainer Management:**  
  Add, edit, or remove trainers from the system.
- **Booking System:**  
  Members can book sessions; admins can view and manage all bookings.
- **Logout:**  
  Secure logout for both users and admins.

---

## 📝 License

This project is for educational purposes.

---

## 👨‍💻 Author

**Abdul Mateen**  
GitHub: [Gunrex1](https://github.com/Gunrex1)  
LinkedIn: [Abdul Mateen](https://www.linkedin.com/in/abdul-mateen-2876292a9/)  
Email: Gunrex14@gmail.com

---

## 🙏 Acknowledgments

- PHP and MySQL documentation
- XAMPP for local development
- All contributors and supporters

---

## 📞 Support

If you have any questions or need help:
- Open an issue on GitHub
- Contact: Gunrex14@gmail.com

⭐ **Star this repository if you found it helpful!**

---

Let me know if you want to add screenshots, more technical details, or any other custom section!
