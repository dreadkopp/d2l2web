THIS IS D2L2 WEBSITE
------------------------
Install requirements:
 - php 7.3
   - OpenSSL PHP Extension
   - PDO PHP Extension
   - Mbstring PHP Extension
   - Tokenizer PHP Extension
   - XML PHP Extension
   - Ctype PHP Extension
   - JSON PHP Extension
   - BCMath PHP Extension
   - Imagick PHP Extension
   - Curl PHP Extension
 - mysql 5.7
 - composer
 - nginx
 - redis cache
 - webp conversion tool
 - nohup
 - php7.3-fpm 
 - bindfs
 
 
 Install:
 
  - checkout d2l2 repo
  - run composer update
    - (php composer.phar update)
  - add SQL credentials in .env
  - set up initial Database
    - (php artisan migrate)
  - restart nginx
  
  
  
  
nginx.conf:
```
server {


listen   80; ## listen for ipv4; this line is default and implied
        #listen   [::]:80 default ipv6only=on; ## listen for ipv6

        root /var/www/html/public;
        index index.html index.htm index.php;

        # Make site accessible from http://localhost/
        server_name localhost;

        location / {
                try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/run/php/php7.3-fpm.sock;
        }

        location ~ /\.ht {
                deny all;
        }
}
```