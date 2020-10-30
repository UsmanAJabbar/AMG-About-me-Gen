#!/bin/bash
# installs the About Me Generator
#
# Requires typical webserver installation
# with php installed and the php-curl module enabled
# and Python/flask/sqlalchemy/CORS installed for the backend api
#
# Usage (as root or sudo): ./install.sh <username>

echo
echo 'Welcome to the AMG installer!'
echo
read -p 'Please enter a username: ' uservar
echo

#setup authentication:
# add user
echo -n "$uservar": > htpasswd
echo Please enter a password for "$uservar"
# add password (openssl will prompt twice):
openssl passwd -apr1 >> /etc/nginx/.htpasswd

echo
read -p 'Please enter the http host you'll use for your site: ' httphost
echo
echo 'Installing system... '
echo

# export for flask (may not be needed for gunicorn)
export LC_ALL=C.UTF-8
export LANG=C.UTF-8

# install nginx, php-fpm, php-curl, git, and pip3
apt-get -y install nginx php-fpm php-curl git python3-pip

# cd to /var/www and git clone the repo
cd /var/www/ || exit
git clone https://github.com/UsmanGTA/AMG-About-me-Gen.git amg

# Move html to html_dist and link webroot to html
mv html html_dist
ln -s amg/webroot html

# chown amg folder to nginx user (assuming www-data)
chown -R www-data amg 

# insert provided hostname for api endpoint
sed -i "s/HTTPHOST/$httphost/" /var/www/amg/webroot/assets/js/populate.js

# enable php in sites-available/default
sed -i '/location.*php/s/#location/location/;/location.*php/,/#}/s/#}/}/;/include.*fastcgi-php/s/#//;/fastcgi_pass.*sock/s/#//;/fastcgi_pass.*sock/s/7.0/7.2/' /etc/nginx/sites-available/default

# add basic auth for admin page
sed -i '/^server/,/^}/s~^}~\n\tlocation /admin.html {\n\tauth_basic "Authorized access only";\n\tauth_basic_user_file /etc/nginx/.htpasswd;\n\t}\n}~' /etc/nginx/sites-available/default

# install python, sqlalchemy and cors,
pip3 install flask flask_sqlalchemy flask_cors gunicorn

cat >> /lib/systemd/system/gunicorn.service << EOF
# gunicorn startup dance
# =======================
#
[Unit]
Description=A Python WSGI HTTP server
After = network.target

[Service]
WorkingDirectory=/var/www/amg/api
User=www-data
Group=www-data
ExecStart=/usr/local/bin/gunicorn --bind 0.0.0.0:5000 amg:app -w 3 --access-logfile /tmp/amgapi-access.log --error-logfile /tmp/amgapi-error.log
ExecReload=/bin/kill -1 $MAINPID
ExecStop=/bin/kill -15 $MAINPID

[Install]
WantedBy=multi-user.target
EOF

# start services
systemctl enable gunicorn
systemctl start gunicorn
systemctl restart php7.?-fpm
systemctl restart nginx 

# Success!
echo
echo "Congratulations! The amg profile generator has been installed."
echo
echo "Please visit http://""$httphost""/admin.html to set up your new webpage."
echo
