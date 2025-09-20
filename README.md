# Products Integration

Recomendavel fazer deploy utilizando o codespaces do github

1. Rodar comando para subir containers

    **`docker compose up -d --build`**

2. Entrar no container do laravel

    **`docker compose exec php bash`**

3. Gerar .env

    **`cp .env.example .env`**

4. Rodar composer install

    **`composer install`**

5. Gerar chave

    **`php artisan key:generate`**

6. Rodar migrations

    **`php artisan migrate`**

7. Rodar comando para inserir produtos no banco de dados

    **`php artisan importProducts produtos`**

8. Rodar comando para inserir variações no banco de dados

    **`php artisan importVariations variacoes`**

9. Rodar comando para Simular envio de dados para Vesti

    **`php artisan sendVesti`**

10. Rodar testes unitarios

    **`php artisan test`**
