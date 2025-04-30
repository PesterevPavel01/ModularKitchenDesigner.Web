Для корректной работы постоянных ссылок необходимо изменить конфигурацию nginx, добавив в нее : 
location / {
    try_files $uri $uri/ /index.php?$args;
}

пример:

server {
	server_name kitchen-dizag.fvds.ru www.kitchen-dizag.fvds.ru;
	charset off;
	index index.php index.html;
	disable_symlinks if_not_owner from=$root_path;
	include /etc/nginx/vhosts-includes/*.conf;
	include /etc/nginx/vhosts-resources/kitchen-dizag.fvds.ru/*.conf;
	access_log /var/www/httpd-logs/kitchen-dizag.fvds.ru.access.log;
	error_log /var/www/httpd-logs/kitchen-dizag.fvds.ru.error.log notice;
	ssi on;
	set $root_path /var/www/www-root/data/www/kitchen-dizag.fvds.ru;
	root $root_path;
	gzip on;
	gzip_comp_level 5;
	gzip_disable "msie6";
	gzip_types text/plain text/css application/json application/x-javascript text/xml application/xml application/xml+rss text/javascript application/javascript image/svg+xml;
	location / {
		location / {
            try_files $uri $uri/ /index.php?$args;
        }
		location ~ [^/]\.ph(p\d*|tml)$ {
			try_files /does_not_exists @php;
		}
		location ~* ^.+\.(jpg|jpeg|gif|png|svg|js|css|mp3|ogg|mpe?g|avi|zip|gz|bz2?|rar|swf|webp|woff|woff2)$ {
			expires 24h;
		}
	}
	location @php {
		include /etc/nginx/vhosts-resources/kitchen-dizag.fvds.ru/dynamic/*.conf;
		fastcgi_index index.php;
		fastcgi_param PHP_ADMIN_VALUE "sendmail_path = /usr/sbin/sendmail -t -i -f webmaster@kitchen-dizag.fvds.ru";
		fastcgi_pass unix:/var/www/php-fpm/1.sock;
		fastcgi_split_path_info ^((?U).+\.ph(?:p\d*|tml))(/?.+)$;
		try_files $uri =404;
		include fastcgi_params;
	}
	listen 62.109.7.14:80;
}
server {
	server_name kitchen-dizag.fvds.ru www.kitchen-dizag.fvds.ru;
	ssl_certificate "/var/www/httpd-cert/www-root/kitchen-dizag.fvds.ru_le1.crtca";
	ssl_certificate_key "/var/www/httpd-cert/www-root/kitchen-dizag.fvds.ru_le1.key";
	ssl_ciphers EECDH:+AES256:-3DES:RSA+AES:!NULL:!RC4;
	ssl_prefer_server_ciphers on;
	ssl_protocols TLSv1 TLSv1.1 TLSv1.2 TLSv1.3;
	ssl_dhparam /etc/ssl/certs/dhparam4096.pem;
	charset off;
	index index.php index.html;
	disable_symlinks if_not_owner from=$root_path;
	include /etc/nginx/vhosts-includes/*.conf;
	include /etc/nginx/vhosts-resources/kitchen-dizag.fvds.ru/*.conf;
	access_log /var/www/httpd-logs/kitchen-dizag.fvds.ru.access.log;
	error_log /var/www/httpd-logs/kitchen-dizag.fvds.ru.error.log notice;
	ssi on;
	set $root_path /var/www/www-root/data/www/kitchen-dizag.fvds.ru;
	root $root_path;
	gzip on;
	gzip_comp_level 5;
	gzip_disable "msie6";
	gzip_types text/plain text/css application/json application/x-javascript text/xml application/xml application/xml+rss text/javascript application/javascript image/svg+xml;
	location / {
		location / {
            try_files $uri $uri/ /index.php?$args;
        }
		location ~ [^/]\.ph(p\d*|tml)$ {
			try_files /does_not_exists @php;
		}
		location ~* ^.+\.(jpg|jpeg|gif|png|svg|js|css|mp3|ogg|mpe?g|avi|zip|gz|bz2?|rar|swf|webp|woff|woff2)$ {
			expires 24h;
		}
	}
	location @php {
		include /etc/nginx/vhosts-resources/kitchen-dizag.fvds.ru/dynamic/*.conf;
		fastcgi_index index.php;
		fastcgi_param PHP_ADMIN_VALUE "sendmail_path = /usr/sbin/sendmail -t -i -f webmaster@kitchen-dizag.fvds.ru";
		fastcgi_pass unix:/var/www/php-fpm/1.sock;
		fastcgi_split_path_info ^((?U).+\.ph(?:p\d*|tml))(/?.+)$;
		try_files $uri =404;
		include fastcgi_params;
	}
	listen 62.109.7.14:443 ssl;
}