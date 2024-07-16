# Sistema de Controle de Despesas
Este projeto visa desenvolver uma API RESTful com um CRUD básico para despesas associadas a um usuário. O projeto é estruturado para utilizar Design Patterns e seguir boas práticas de Clean Code, incluindo os princípios SOLID e Object Calisthenics. A documentação foi cuidadosamente elaborada, tanto no código quanto no Swagger, para garantir clareza e organização.

## Tecnologias Utilizadas

- **Framework:** Laravel
- **Banco de Dados:** MySQL
- **Testes:** PHPUnit
- **Versionamento:** Git
- **Ambiente de Desenvolvimento:** Docker
- **Servidor de E-mail:** Laravel Notifications com Queues para envio de e-mails em fila

## Instalação

1. Clone o repositório para um diretório de sua preferência:
    ```sh
    git clone https://github.com/kaiqueroc/sistema_controle_despesas.git
    ```

2. Acesse o diretório do projeto:
    ```sh
    cd sistema_controle_despesas/
    ```

3. Configure o arquivo `.env` com base no `.env.example`:
    ```sh
    cp .env.example .env
    ```

4. Atualize as credenciais de envio de e-mail no arquivo `.env`:
    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=seu_host
    MAIL_PORT=sua_porta
    MAIL_USERNAME=seu_email
    MAIL_PASSWORD=sua_senha
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="seu_endereço_de_email"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

5. Certifique-se de ter o Docker instalado e, em seguida, construa a imagem Docker:
    ```sh
    docker build -t sistema_controle_despesas .
    ```

6. Inicie o container:
    ```sh
    docker-compose up -d
    ```

7. Acesse o container:
    ```sh
    docker exec -it nginx-sistema_controle_despesas bash
    ```

8. Instale as dependências do projeto:
    ```sh
    composer install
    ```

9. Gere a chave do Laravel:
    ```sh
    php artisan key:generate
    ```

10. Instale o `php-sqlite3` para a execução dos testes automatizados:
    ```sh
    apt install php8.2-sqlite3 -y
    ```

11. Crie as tabelas no banco de dados usando as migrations:
    ```sh
    php artisan migrate
    ```

12. Execute os testes automatizados:
    ```sh
    php artisan test
    ```

13. Deixe um worker rodando para envio de e-mails assíncronos:
    ```sh
    php artisan queue:work
    ```


Seguindo esses passos, você estará pronto para usar o projeto em sua máquina.
