## About this project

This is a web application developed using the Laravel(PHP) framework. The features of the application are:

- Full-fledged registration and login system for user and admin
- When any user accesses the short link, this service will redirect to the original link.
- Registered Users can optionally pick a custom short link for their URL.
- Registered Users have for private URL generation.
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- Generated Links will expire after a standard default timespan.
- Registered Users can specify the expiration time during link generation.

## Installation Process in Ubuntu Operating System

- Istall PHP 8.1 if not installed. Installation Link(https://www.digitalocean.com/community/tutorials/how-to-install-php-8-1-and-set-up-a-local-development-environment-on-ubuntu-22-04) for PHP 8.1 Installation.
- Istall composer if not installed. Installation Link(https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04).
- Clone this project in you local machine.
- Create a Database named url_shortner_app.
- Now add the database name, username and password in .end file.
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=DATABASE_NAME
DB_USERNAME=YOUR_USERNAME
DB_PASSWORD=YOUR_PASSWORD
- go to the root directory of the project using terminal
- use command "php artisan migrate" to create tables and "php artisan serve" to run the application localy.
- For admin site add /admin/login after ther baseurl and enter. The admin email is "admin@example.com" and password is "admin1234".