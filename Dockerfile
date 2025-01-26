FROM php:7.4-cli

# Instala extensões necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Copia o código do projeto para o container
COPY . /usr/src/app

# Define o diretório de trabalho
WORKDIR /usr/src/app

# Define o comando padrão para rodar o PHP
CMD [ "php", "./public/index.php" ]