
# Laravel API Project

This project is a RESTful API built using Laravel, supporting multiple API versions. Each version has its own set of endpoints and may differ in structure or data handling, as required.

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Running the API](#running-the-api)
- [API Versions](#api-versions)
  - [Version 1](#version-1)
  - [Version 2](#version-2)
- [Usage](#usage)
- [Testing](#testing)

## Installation

To set up the project, please follow these steps:

1. Clone the repository:
    ```bash
    git clone https://github.com/kawsar24ahmad/laravel-api-project.git
    cd laravel-api-project
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Copy the `.env` file:
    ```bash
    cp .env.example .env
    ```

4. Set up your database and update the `.env` file with your database credentials.

5. Run the migrations to set up database tables:
    ```bash
    php artisan migrate
    ```

## Configuration

Make sure to configure the following in your `.env` file:

- **Database connection**: Update your database credentials (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD).
- **API versioning**: This project supports versioned APIs (`v1`, `v2`). By default, routes are defined separately for each version.

## Running the API

To start the API server, run:

```bash
php artisan serve
```

The server will be accessible at `http://127.0.0.1:8000`.

## API Versions

This project manages two versions of the API. Here’s an overview of each version:

### Version 1

- **Endpoint**: `/api/v1/...`
- **Description**: Basic implementation, retrieves and manipulates data with default structures.

### Version 2

- **Endpoint**: `/api/v2/...`
- **Description**: Enhancements over Version 1, with modified data structures and additional functionality.

> Note: This project does not require `app/Http/Resources/V1/UserResource.php` or `app/Http/Resources/V2/UserResource.php` for version-specific responses.


**Example requests**:

- **Get all urls (v1)**: `GET http://127.0.0.1:8000/api/v1/urls`
- **Get all urls (v2)**: `GET http://127.0.0.1:8000/api/v2/urls`

For a full list of available endpoints, see the documentation or check the routes in `routes/api.php`.


This command runs unit and feature tests defined within the `tests` directory.

## License

This project is open-source and available under the [MIT license](LICENSE).
