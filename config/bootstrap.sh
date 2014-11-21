sudo /usr/bin/perl -p -i -e "s/vagrant.dev/$1/g" /etc/httpd/conf/httpd.conf
sudo /usr/bin/perl -p -i -e "s/\/var\/www\/public/\/var\/www\/web/g" /etc/httpd/conf/httpd.conf

mysql -u root -e "GRANT ALL PRIVILEGES ON *.* to 'root'@'%' IDENTIFIED BY '' WITH GRANT OPTION; FLUSH PRIVILEGES;"

sudo apachectl restart