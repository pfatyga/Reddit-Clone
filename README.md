# CS 546 Reddit Clone

## Team Members

* Matt Continisio
* Piotr Fatyga
* Ben Barnett
* Michael Abramo

## Run

### Install Dependencies

Install LAMP.

Example (Ubuntu):

    sudo apt-get install apache2
    sudo apt-get install mysql-server
    sudo apt-get install php5 libapache2-mod-php5
    sudo apt-get install php5-mysqlnd
    sudo /etc/init.d/apache2 restart
  
The web app can be run with PHP's built-in web server or with Apache 2.

### Run using PHP's built-in web server

Run

    ./scripts/ss.sh

### Run with Apache 2

Enable Apache modules:

    sudo a2enmod rewrite
    sudo a2enmod mime
    sudo service apache2 restart

Virtual host config (change DocumentRoot and Directory to location of project's web folder):

    <VirtualHost *:80>
        ServerName leddit.com
        ServerAlias www.leddit.com

        ServerAdmin admin@leddit.com
        DocumentRoot /var/www/leddit.com/cs-546-reddit-clone/web

        <Directory /var/www/leddit.com/cs-546-reddit-clone/web>
                Options Indexes FollowSymLinks
                AllowOverride All
                Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>

## Directory Layout

    config/ - php configuration
    scripts/ - maintenance and build scripts
        ss.sh - runs PHP's built-in webserver
    server/ - server application files
        controllers/ - controller classes
        docs/ - documentation
        models/ - model classes
        services/ - service classes
        config.php - main configuration file
    web/ - document root
        app/ - Angular application files
        css/ - CSS stylesheets
        img/ - images
        js/ - JavaScript library files
        index.html - etry point for Angular app
        index.php - entry point for API
        router.php entry point when using ss.sh