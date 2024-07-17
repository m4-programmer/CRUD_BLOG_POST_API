# Development of Simple CRUD Blog/Posts Apis
A simple RESTful API for managing blogs and posts.

## Installation

### Prerequisites

- PHP 8.2
- Laravel 11.x
- Composer
- Apache Server
- MySQL

### Steps
The steps below will guide you to run the project on your local machine. These commands  can be run using Powershell (for Windows OS), or Terminal (for Unix).

1. Clone the repository:
    ```bash
    git clone https://github.com/m4-programmer/CRUD_BLOG_POST_API.git
    cd CRUD_BLOG_POST_API
    ```

2. Install the dependencies:
    ```bash
    composer install
    ```

3. Copy the example environment file
    ```bash
    cp .env.example .env
    ```

4. Update .env file
   Set the following variables in the .env file.
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=blog
    DB_USERNAME=your_db_username
    DB_PASSWORD=your_db_password
    ```

5. Generate the application key:
    ```bash
    php artisan key:generate
    ```

6. Run the database migrations:
    ```bash
    php artisan migrate
    ```
7. Seed Database (This will create a user for you in the database)
    ```bash
    php artisan db:seed
    ```
8. Start the development server:
    ```bash
    php artisan serve
    ```




## Documentation
The Postman document is available at the link below.
```bash
https://documenter.getpostman.com/view/26916119/2sA3kRKjcn
```
