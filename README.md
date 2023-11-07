## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull -d --wait` to start the project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.
6. Create `.env` file and fill it with data from `.env.dev.example`. For unix: `cp .env.dev.example .env`
7. To run migrations: `./bin/console doctrine:migrations:migrate`. That step is needed to create DB tables.
8. To load fixtures: `./bin/console doctrine:fixtures:load`

**Enjoy!**
