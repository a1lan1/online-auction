# Online Auction

This is a demo web application for online auctions. The development environment is fully containerized using [Docker](https://www.docker.com/products/docker-desktop/) and Laravel Sail.

![](./public/img/auction-demo.gif)

## Tech Stack

- **High-Performance Backend**: Laravel 12 on **Octane** (with RoadRunner).
- **Robust Queue Processing**: **Laravel Horizon** managing background jobs.
- **Advanced Search**: **Laravel Scout** powering full-text search with **Meilisearch**.
- **Insightful Monitoring**: Real-time application metrics with **Prometheus** & **Grafana**.
- **Modern Frontend**: A reactive UI with Vue 3, Inertia.js, Vite, TypeScript.
- **Seamless Development**: A fully containerized environment with Docker and **Laravel Sail**.
- **Database**: PostgreSQL 16
- **Cache & Queues**: Redis, Horizon
- **Email**: Mailpit

## Getting Started

1.  **Clone the repository and prepare the environment file.**
    ```bash
    git clone <repository-url> online-auction
    cd online-auction
    cp .env.example .env
    ```

2.  **Install PHP dependencies.**
    ```bash
    composer install
    ```

3.  **Generate the application key.**
    ```bash
    sail artisan key:generate
    ```

4.  **Build and start the application containers.**
    ```bash
    sail build
    sail up -d
    ```

5.  **Install frontend dependencies.**
    ```bash
    sail yarn install
    ```

6.  **Run database migrations and seed initial data.**
    ```bash
    sail artisan migrate --seed
    ```

7.  **Build the initial search index.**
    ```bash
    sail artisan search:reindex
    ```

8.  **Start the frontend development server.**
    ```bash
    sail yarn dev
    ```

The application is now running and ready for exploration!

## Available Services

- **Application**: [http://localhost](http://localhost)
- **Filament Admin Panel**: [http://localhost/admin](http://localhost/admin)
- **Horizon Dashboard**: [http://localhost/horizon](http://localhost/horizon)
- **Meilisearch Dashboard**: [http://localhost:7700](http://localhost:7700)
- **Mailpit (Email Client)**: [http://localhost:8025](http://localhost:8025)
- **Grafana Dashboards**: [http://localhost:3000](http://localhost:3000) (user: `test@example.com`, pass: `password`)
- **Prometheus Targets**: [http://localhost:9090](http://localhost:9090)
- **Log Viewer**: [http://localhost/log-viewer](http://localhost/log-viewer)
- **Laravel Telescope**: [http://localhost/telescope](http://localhost/telescope)

## Development Workflow

### IDE Helper

```bash
sail artisan ide-helper:generate
sail artisan ide-helper:models -RW
sail artisan ide-helper:meta
```

### Code Quality & Linting

- **Pint**: Fix code style issues.
  ```bash
  sail pint
  ```
- **PHPStan**: Run static analysis to find potential bugs.
  ```bash
  sail phpstan analyse
  ```
- **ESLint & Prettier**: Lint and format frontend code.
  ```bash
  sail yarn lint
  sail yarn format
  ```

### Testing

```bash
sail artisan test --coverage --parallel
```

### Stopping the Environment

To stop all running containers, use:
```bash
sail stop
```
