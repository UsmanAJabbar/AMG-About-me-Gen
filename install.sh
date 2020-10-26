#!/bin/bash
# installs the About Me Generator
#
# Requires typical webserver installation
# with php installed and the php-curl module enabled
# and Python/flask/sqlalchemy/CORS installed for the backend api
#
# Usage (as root or sudo): ./install.sh <username>

# check for first argument to be used as username
[ -z "$1" ] && echo 'Usage: '$0' <username>' & exit

# install nginx, php-fpm, php-curl, git, and pip3
apt-get -y install nginx php-fpm php-curl git python3-pip

# cd to /var/www and git clone the repo
cd /var/www/
git clone https://github.com/UsmanGTA/AMG-About-me-Gen.git amg

# Move html to html_dist and link webroot to html
mv html html_dist
ln -s amg/webroot html

# chown amg folder to nginx user (assuming www-data)
chown -R www-data amg 

# enable php in sites-available/default
sed -i '/location.*php/s/#location/location/;/location.*php/,/#}/s/\.php/.(php|html)/;/location.*php/,/#}/s/#}/}/' /etc/nginx/sites-available/default
sed -i '/include.*fastcgi-php/s/#//;/fastcgi_pass.*sock/s/#//' /etc/nginx/sites-available/default

# add basic auth for admin page
sed -i '/^server/,/^}/s~^}~\n\tlocation /admin.html {\n\tauth_basic "Authorized access only";\n\tauth_basic_user_file /etc/nginx/.htpasswd;\n\t}\n}~' /etc/nginx/sites-available/default

# install python, sqlalchemy and cors,
pip3 install flask flask_sqlalchemy flask_cors

#setup authentication:
# add user
echo -n $1':' >> /etc/nginx/.htpasswd

# add password (openssl will prompt twice):
openssl passwd -apr1 >> /etc/nginx/.htpasswd

# start services
/etc/init.d/php7.?-fpm start
/etc/init.d/nginx start

# then launch the api
cd /var/www/amg/api
flask run

# load your page, and enjoy!
