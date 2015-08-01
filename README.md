# CS 546 Reddit Clone

## Team Members

* Matt Continisio
* Piotr Fatyga
* Ben Barnett
* Michael Abramo

## Run

Run using PHP's built-in web server.

    ./scripts/serve.sh

## Directory Layout

        server/ - server application files
            controllers/ - controller classes
            docs/ - documentation
            models/ - model classes
            services/ - service classes
            config.php - main configuration file
        config/ - php configuration
        scripts/ - maintenance and build scripts
            ss.sh - runs PHP's built-in webserver
        vendor/ - 3rd party files
        web/ - document root
            app/ - Angular application files
            css/ - CSS stylesheets
            img/ - images
            js/ - JavaScript library files
            index.html - etry point for Angular app
            index.php - entry point for API
            router.php entry point when using ss.sh
