# Online Auction

This is a demo web application for online auctions. The development environment is fully containerized using [Docker](https://www.docker.com/products/docker-desktop/) and Laravel Sail.

## Tech Stack

- **Backend**: Laravel 12, PHP 8.3, Octane (RoadRunner)
- **Frontend**: Vue.js, Inertia.js, Vite, TypeScript
- **Database**: PostgreSQL 16
- **Cache & Queues**: Redis, Horizon
- **Email**: Mailpit

## Getting Started

1.  **Build and run the application**
    ```bash
    sail build
    sail up -d
    ```
2.  **Install dependencies and set up the database**
    ```bash
    sail composer install
    sail yarn install
    sail artisan migrate --seed
    ```
3.  **Run the frontend development server**
    ```bash
    sail yarn dev
    ```
## Available Services
- **Application**: http://localhost
- **Horizon Dashboard**: http://localhost/horizon
- **Log Viewer**: http://localhost/log-viewer
- **Mailpit (Email)**: http://localhost:8025

## Development Tools

### Code Quality & Linting

- **Pint**: A PHP code style fixer for Laravel.
  ```bash
  sail pint
  ```

- **PHPStan**: A static analysis tool to find bugs in your code.
  ```bash
  sail phpstan analyse
  ```

- **Rector**: A tool for automated PHP code refactoring. To see potential changes, run:
  ```bash
  sail rector process --dry-run
  ```

- **ESLint & Prettier**: For linting and formatting TypeScript/Vue files.
  ```bash
  sail yarn lint
  sail yarn format
  ```

### IDE Helper

```bash
sail artisan ide-helper:generate
sail artisan ide-helper:models -RW
sail artisan ide-helper:meta
```

### Testing

```bash
sail artisan test --coverage --parallel
```

## Stopping the Environment

To stop all running containers, run:
```bash
sail stop
```
