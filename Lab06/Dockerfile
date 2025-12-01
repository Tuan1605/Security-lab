FROM php:7.4-apache
#Copy code vào thư mục web
COPY vulnerable_app.php /var/www/html/index.php
#Cài đặt ping
RUN apt-get update && apt-get install -y iputils-ping
