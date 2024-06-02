# Help Hub 2.0🐝

Welcome to Help Hub 2.0🐝, a web application developed to connect people🌎 who need help with those who can offer assistance in a simple and efficient manner. This project showcases my skills and passion for web development and social good.

## ✨ Features

- **User Registration and Authentication**: Create an account and log in securely🔒.
- **Post Creation**: Publish posts to seek or offer help📝.
- **Commenting System**: Engage with posts through comments💬.
- **Private Chat**: Communicate privately with other users💌.
- **Notifications**: Receive notifications for new interactions🔔.
- **Search Functionality**: Find relevant posts and follow your favorite categories using the built-in search indexing algorithm🔍⚙️.
- **Responsive Design**: Enjoy a seamless experience across all devices📱💻 with the use of Bootstrap and pure CSS.

## 💻 Technologies Used

- **PHP**: Backend scripting language.
- **JavaScript**: Client-side scripting.
- **MySQL**: Database management system.
- **AJAX**: Asynchronous communication between client and server.
- **HTML**: Markup language for creating web pages.
- **Bootstrap**: CSS framework for responsive design.
- **CSS**: Custom styles for the application.

## 🛠️ Installation

To set up this project locally, follow these steps:

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/helphub2.0.git
   cd helphub2.0

## Setup the Database

1. **Create a MySQL database**:
   - Log in to your MySQL server.
   - Create a new database for the project using the following command:
     ```sql
     CREATE DATABASE your_database_name;
     ```

2. **Import the provided SQL file**:
   - Import the `database.sql` file to set up the required tables in your newly created database.
     ```bash
     mysql -u your_username -p your_database_name < database.sql
     ```

3. **Configure the Project**:
   - Rename `config.sample.php` to `config.php`.
   - Update the database configuration in `config.php` with your database credentials.
     ```php
     <?php
     // config.php
     define('DB_SERVER', 'your_server');
     define('DB_USERNAME', 'your_username');
     define('DB_PASSWORD', 'your_password');
     define('DB_NAME', 'your_database_name');
     ?>
     ```

4. **Run the Application**:
   - Start your local development server (e.g., using XAMPP, WAMP, or a similar tool).
   - Navigate to `http://localhost/helphub2.0` in your web browser.
  
## 🚀 Usage

- **Register** for an account:
  - Visit the registration page.
  - Fill out the required information to create a new account.

- **Log in** to your account:
  - Navigate to the login page.
  - Enter your credentials to access your account.

- **Create and publish posts** to seek or offer help:
  - After logging in, go to the post creation page.
  - Fill in the details of your post and publish it.

- **Comment on posts** to engage with other users:
  - Browse posts and leave comments to interact with the community.

- **Chat privately with users**:
  - Use the private messaging feature to communicate directly with other users.

- **Receive notifications** for new interactions:
  - Get notified when someone interacts with your posts or messages you.

- **Search for relevant posts and follow your favorite categories**:
  - Use the search functionality to find posts that interest you.
  - Follow categories to stay updated on new posts in those areas.

## 🤝 Contributing

Contributions are welcome! If you have any suggestions or improvements, feel free to open an issue or submit a pull request.

1. **Fork the repository**:
   - Click the "Fork" button on the top right of the repository page.

2. **Clone your fork**:
   ```bash
   git clone https://github.com/yourusername/helphub2.0.git
   cd helphub2.0

## 📄 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## 📧 Contact

If you have any questions or feedback, please contact me at [dulanjayawebs@gmail.com].
