FROM php:8.2-cli

WORKDIR php-todo

COPY . .

EXPOSE 5000

CMD ["php", "-c", ".", "-S", "0.0.0.0:5000", "-t", "."]
