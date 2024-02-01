# Simple Exchange

### Установка и запуск

1. Клонирование репозитория:
    ```bash
    git clone https://github.com/anwsonwsymous/symfony-exchange exchange
    cd exchange
    ```

2. Запуск Docker контейнеров:
    ```bash
    docker-compose up -d
    ```

3. Выполнение миграций базы данных:
    ```bash
    docker-compose exec app php bin/console doctrine:migrations:migrate
    ```

## Использование

- **Импорт курсов валют:** Запустите `docker-compose exec app php bin/console app:import-exchange-rates`.
- **Конвертация валют:** Посетите `http://localhost:8000/` в вашем браузере.
