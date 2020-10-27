#!/bin/bash
# installs the About Me Generator
#
# Requires typical webserver installation
# with php installed and the php-curl module enabled
# and Python/flask/sqlalchemy/CORS installed for the backend api
#
# Usage (as root or sudo): ./install.sh <username>

# check for first argument to be used as username
if [ -z "$1" ]
  then
    echo 'Usage: '$0' <username>'
    exit
fi

# export for flask (may not be needed for gunicorn)
export LC_ALL=C.UTF-8
export LANG=C.UTF-8

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
sed -i '/location.*php/s/#location/location/;/location.*php/,/#}/s/#}/}/;/include.*fastcgi-php/s/#//;/fastcgi_pass.*sock/s/#//' /etc/nginx/sites-available/default

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

# -rather than running directly below,
# -api needs to instead use gunicorn,
# -started with other services above

# then launch the api
cd /var/www/amg/api
flask run

# load your page, and enjoy!
