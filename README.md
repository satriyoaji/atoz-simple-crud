## Getting Started

### 1. How to clone and run this Repository

- Clone this project
- Go to the folder application using cd command on your cmd or terminal
- Run composer install on your cmd or terminal in this project root dirctory
- Copy .env.example file to .env on the root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal, Ubuntu
- Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
- By default, the username is root and you can leave the password field empty. (This is for Xampp)
- By default, the username is root and password is also root. (This is for Lamp)
- Run php artisan key:generate
- Run php artisan migrate
- Run php artisan serve
- Go to localhost => **http://127.0.0.1:8000/**
