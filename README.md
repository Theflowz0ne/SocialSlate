# Social Slate

Social Slate is a social media platform that empowers users to create accounts, manage their profiles, and engage with others through posts. Built with modern technologies like InertiaJS and Vue3, it provides a seamless single-page application experience, thanks to Laravel Breeze for effortless user authentication.

## Features

-   **User Authentication**: Robust sign up, login, and logout functionalities powered by Breeze.
-   **Profile Management**: Users can create and update their profiles.
-   **Post Management**: Users can post, update, edit and delete posts as desired.

## Technologies

-   **Frontend**:

    -   **Vue 3**: A progressive JavaScript framework for building user interfaces.
    -   **Inertia.js**: Facilitates building single-page apps using classic server-side routing and controllers.
    -   **Breeze**: Provides a simple Laravel authentication boilerplate including login, registration, and password reset.

-   **Backend**:

    -   **Laravel**: A PHP framework known for its elegant syntax and robust features.

-   **Database**:
    -   **MySQL**: A reliable and widely used open-source relational database management system.

## Requirements

-   PHP >= 7.3
-   Node.js >= 12.x
-   Composer
-   MySQL or a compatible database server

## Installation

1.  **Clone the repository**:

    ```bash
    git clone https://github.com/theflowz0ne/socialslate.git
    cd socialslate
    ```

2.  **Install Dependencies**:

    ```bash

    composer install
    yarn install
    yarn dev
    ```

3.  **Setup the environment file**:

    ```bash
    cp .env.example .env
    ```

4.  **Generate an application key**:

    ```bash
    php artisan key:generate
    ```

5.  **Run migrations**:

    ```bash
    php artisan migrate
    ```

6.  **Serve the application**:

    ```bash
    php artisan serve
    ```
