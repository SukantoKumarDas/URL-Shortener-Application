# URL Shortener Web Application

## About this project

This web application is built using **Laravel 10** (PHP framework) and serves as a URL shortener service with the following features:

- **User and Admin Authentication**: Full-fledged registration and login system for both users and admin.
- **Shorter URL Creation and Redirection**: Shortened links can be generated automatically redirected to the original URL when accessed.
- **Custom Short Links**: Registered users can optionally choose custom short aliases for their URLs.
- **Private URLs**: Registered users have the option to generate private URLs that are only accessible by them.
- **Link Expiration**: All generated links expire after a default timespan, but registered users can also define custom expiration times during link creation.
- **Admin Panel**: Admin can see the total number of users, list of users and list of created links in the admin panel.
- **Scheduled Cleanup**: Expired links are automatically soft-deleted after 48 hours by a scheduled job running every 6 hours.


## Installation

### Prerequisites

1. **PHP 8.1**: Ensure PHP 8.1 is installed on your system. Refer to the [PHP 8.1 Installation Guide](https://www.digitalocean.com/community/tutorials/how-to-install-php-8-1-and-set-up-a-local-development-environment-on-ubuntu-22-04).
2. **Composer**: Install Composer to manage Laravel dependencies. Follow the [Composer Installation Guide](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04).
3. **MySQL**: Ensure that MySQL is installed and running for database management. Follow the [MySQL Installation Guide](https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-ubuntu-22-04)

### Step-by-Step Installation

1. **Clone the Project**
   ```bash
   git clone https://github.com/SukantoKumarDas/URL-Shortener-Application.git
2. **Navigate to the Project Directory**
     ```bash
   git clone https://github.com/SukantoKumarDas/URL-Shortener-Application.git
3. **Run the following command to install all required packages:**
    ```bash
       composer install

4. **Create a MySQL database for the application:**
    ```bash
       mysql -u root -p
       CREATE DATABASE url_shortener_app;

5. **Copy the .env.example file to create a new .env file:**
    ```bash
       cp .env.example .env

Then, edit the .env file to update the database credentials: 
 
   
       DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3306
       DB_DATABASE=url_shortener_app
       DB_USERNAME=YOUR_USERNAME
       DB_PASSWORD=YOUR_PASSWORD


6. **Migrate the database to create all necessary tables:**
    ```bash
        php artisan migrate

7. **Run the following command to install all packages**
    ```bash
        composer install

The application will be accessible at http://127.0.0.1:8000.

Admin Access
To access the admin panel:

URL: http://127.0.0.1:8000/admin/login
Admin Credentials:
Email: admin@example.com
Password: admin1234
