# Products Integration

Recomendavel fazer deploy utilizando o codespaces do github

1. Rodar comando para subir containers

    **`docker compose up -d --build`**

2. Entrar no container do laravel

    **`docker compose exec php bash`**

3. Gerar .env

    **`cp .env.example .env`**

4. Gerar chave

    **`php artisan key:generate`**

5. Rodar migrations

    **`php artisan migrate`**

6. Rodar comando para inserir produtos no banco de dados

    **`php artisan importProducts produtos`**

7. Rodar comando para inserir variações no banco de dados

    **`php artisan importVariations variacoes`**
