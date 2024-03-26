FROM php:8.2-cli

WORKDIR php-todo

COPY . .

EXPOSE 5000

CMD ["php", "-c", ".", "-S", "localhost:5000", "-t", "."]
