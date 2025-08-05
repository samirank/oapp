# Online Appointment System

A comprehensive web-based appointment management system for hospitals and laboratories, built with PHP and MySQL. This system allows patients to book appointments with doctors and schedule laboratory tests online.

## 🚀 Features

### For Patients
- **User Registration & Authentication**: Secure patient registration and login system
- **Doctor Appointments**: Search and book appointments by department/specialty
- **Laboratory Tests**: Schedule various laboratory tests online
- **Appointment Management**: View, modify, and cancel existing appointments
- **Profile Management**: Update personal information and medical history

### For Doctors
- **Schedule Management**: Set availability and manage appointment slots
- **Patient Records**: Access patient information and appointment history
- **Department Assignment**: Work within specific medical departments

### For Administrators
- **User Management**: Manage doctors, patients, and staff accounts
- **Department Management**: Add and manage medical departments
- **Laboratory Test Management**: Configure available laboratory tests
- **System Monitoring**: Track appointments and system usage

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Libraries**: jQuery, DataTables
- **Security**: Session-based authentication, SQL injection protection

## 📋 Prerequisites

Before running this application, make sure you have:

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Composer (optional, for dependency management)

## 🔧 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/online-appointment-system.git
   cd online-appointment-system
   ```

2. **Set up the database**
   - Create a MySQL database named `oapp`
   - Import the database schema (you'll need to create this from the existing tables)
   - Update database credentials in `master/db.php`

3. **Configure the application**
   ```php
   // Edit master/db.php with your database credentials
   $server = "localhost";
   $dbname = "oapp";
   $user = "your_username";
   $pwd = "your_password";
   ```

4. **Set up the web server**
   - Point your web server to the project directory
   - Ensure PHP has write permissions for session management

5. **Access the application**
   - Open your browser and navigate to the project URL
   - Register as a new patient or use existing credentials

## 🗄️ Database Setup

The system uses the following main tables:
- `users` - User authentication and roles
- `patients` - Patient information
- `doctors` - Doctor profiles and specialties
- `departments` - Medical departments
- `appointments` - Appointment scheduling
- `lab_test` - Available laboratory tests
- `lab_bookings` - Laboratory test bookings
- `schedules` - Doctor availability schedules

## 🔒 Security Features

- Session-based authentication
- SQL injection protection using `mysqli_real_escape_string()`
- Password hashing (recommended for production)
- Input validation and sanitization
- CSRF protection (recommended enhancement)

## 📁 Project Structure

```
├── index.php              # Main landing page
├── login.php              # User authentication
├── dashboard.php          # User dashboard
├── patientreg.php         # Patient registration
├── doc_reg.php           # Doctor registration
├── book.php              # Appointment booking
├── schedule.php          # Schedule management
├── lab.php               # Laboratory test management
├── process.php           # Form processing and business logic
├── master/
│   └── db.php           # Database configuration
├── css/                  # Stylesheets
├── js/                   # JavaScript files
└── images/               # Static images
```

## 🚀 Usage

### For Patients
1. Register a new account at `/patientreg.php`
2. Login with your credentials
3. Search for doctors by department
4. Book appointments based on available slots
5. Schedule laboratory tests as needed

### For Doctors
1. Login with admin-provided credentials
2. Set your availability schedule
3. View and manage patient appointments
4. Access patient records

### For Administrators
1. Login with admin credentials
2. Manage departments and laboratory tests
3. Register new doctors
4. Monitor system usage

## 🔧 Configuration

### Environment Variables
For production deployment, consider using environment variables for sensitive data:

```php
// Example configuration
$server = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? 'oapp';
$user = $_ENV['DB_USER'] ?? 'oapp';
$pwd = $_ENV['DB_PASS'] ?? '';
```

### Security Enhancements
1. Enable HTTPS in production
2. Implement password hashing (bcrypt recommended)
3. Add rate limiting for login attempts
4. Implement proper CSRF protection
5. Use prepared statements for all database queries

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🐛 Known Issues

- Database credentials are hardcoded (should use environment variables)
- Limited input validation in some forms
- No password hashing implemented
- Missing CSRF protection

## 🔮 Future Enhancements

- [ ] Implement password hashing
- [ ] Add email notifications
- [ ] Mobile-responsive design improvements
- [ ] API endpoints for mobile app
- [ ] Advanced reporting and analytics
- [ ] Integration with payment gateways
- [ ] Multi-language support
- [ ] Advanced search and filtering

## 📞 Support

For support and questions, please open an issue in the GitHub repository or contact the development team.

---

**Note**: This is a student project developed for the MCS-044 course at IGNOU. For production use, additional security measures and testing are recommended.