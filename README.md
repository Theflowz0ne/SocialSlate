# Social Slate

Welcome to **Social Slate**, a dynamic social media platform where you can connect, share, and interact with others. This application is built using Laravel, Inertia.js, Vue.js, and MySQL. Below you will find detailed information on how to set up and use Social Slate, as well as an overview of its features.

## Table of Contents

- [Features](#features)
- [Demo](#demo)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Features

- **User Profiles:** Create and customize your profile.
- **Posts:** Create, edit, and delete posts.
- **Interactions:** Like and share posts.
- **User Management:** Block other users.
- **Real-time Updates:** Experience real-time updates with Inertia.js and Vue.js.

## Demo

Check out the quick demo of Social Slate in action:

[![Demo Video](https://img.youtube.com/vi/GTKO1JElziw/0.jpg)](https://youtu.be/GTKO1JElziw?si=PLawIYnsM9WWj1Mz)

## Prerequisites

Before you begin, ensure you have met the following requirements:

- PHP >= 7.3
- Composer
- Node.js & NPM
- MySQL
- Laravel 8.x
- Vue.js 3.x

## Installation

Follow these steps to get a local copy up and running.

1. **Clone the repository:**
    ```bash
    git clone https://github.com/yourusername/social-slate.git
    cd social-slate
    ```

2. **Install dependencies:**
    ```bash
    composer install
    npm install
    ```

3. **Set up the environment:**
    Copy the `.env.example` file to `.env`:
    ```bash
    cp .env.example .env
    ```

4. **Generate application key:**
    ```bash
    php artisan key:generate
    ```

## Configuration

1. **Database configuration:**
    Open the `.env` file and set the database credentials:
    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

2. **Run database migrations:**
    ```bash
    php artisan migrate
    ```

## Running the Application

1. **Build the frontend assets:**
    ```bash
    npm run dev
    ```

2. **Start the Laravel development server:**
    ```bash
    php artisan serve
    ```

Your application should now be running at [http://localhost:8000](http://localhost:8000).

## Usage

### Profiles

- **Create Profile:** Sign up to create your profile.
- **Edit Profile:** Go to your profile page and click on the "Edit Profile" button.
- **Delete Profile:** Delete your account from the settings page.

### Posts

- **Create Post:** Navigate to the home page and click on "New Post".
- **Edit Post:** Click on the post you want to edit and select "Edit".
- **Delete Post:** Click on the post you want to delete and select "Delete".

### Interactions

- **Like Post:** Click on the like button below any post.
- **Share Post:** Click on the share button below any post.
- **Hide Post:** Click on the hide button below any post.

### User Management

- **Block User:** Go to the profile of the user you want to block and click on "Block User".


## License

Distributed under the MIT License. See `LICENSE` for more information.

---

Thank you for checking out Social Slate! If you have any questions, feel free to open an issue or contact me directly. Happy coding!
