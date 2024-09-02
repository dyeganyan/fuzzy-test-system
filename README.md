# Symfony Testing System

This project is a simple testing system built with Symfony, using PostgreSQL for the database and Docker for containerization. The system supports fuzzy logic questions with multiple correct answers.

## Features

- **Symfony 5.4** application
- **PostgreSQL** as the database
- **Doctrine Migrations** for database schema management
- **Doctrine Fixtures** for loading test data
- **Docker** for containerization
- **Nginx** as the web server
- **PHP-FPM** for handling PHP requests

## Requirements

- Docker and Docker Compose installed on your machine

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/yourusername/symfony-testing-system.git
    cd symfony-testing-system
    ```

2. Copy the environment configuration:

    ```bash
    cp .env.example .env
    ```

3. Build and start the Docker containers:

    ```bash
    docker-compose up
    ```

    This will build the Docker images and start the containers for the application, database, and web server.

4. Run migrations and load fixtures automatically:

    The Docker configuration is set to automatically run database migrations and load fixtures every time the containers are started.

    If you need to manually run migrations or load fixtures, you can do so with the following commands:

    ```bash
    docker-compose exec app php bin/console doctrine:migrations:migrate
    docker-compose exec app php bin/console doctrine:fixtures:load --purge-with-truncate
    ```

## Usage

Once the containers are up and running, the application will be accessible at `http://localhost:8081`.

### Available Routes

- **Home:** `http://localhost:8081/` (Redirects to the test page)
- **Submit Test:** `http://localhost:8081/test/submit`
- **View Results:** `http://localhost:8081/test/results`
