# Student Management System

## Requirements

- Required PHP version 5.6.0/ 7.1
- MySQL version 5.5/ 5.6/ 5.7 
- Turn on PHP short tags.
- App servers Nginx or Apache

## Installation

1. Enable PHP short tags.
2. Restore attached database dump in to mysql database.
3. Edit the database credentials in `codepool/etc/config.xml`

## Nginx Server configs

### nginx

```nginx
listen 80; ## listen for ipv4
    #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

    server_name studenttest.lk;
    root /home/var/www/harsha_lasith/web;
    index       index.php;

    error_log /var/log/nginx/student_error.log;
    access_log /var/log/nginx/student_access.log;

    location / {
        # Redirect everything that isn't a real file to index.php
        try_files $uri $uri/ /index.php$is_args$args;
    }

    # deny accessing php files for the /assets directory
    location ~ ^/assets/.*\.php$ {
        deny all;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;      
        fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;       
        try_files $uri =404;
    }
}
