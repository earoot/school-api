# School-API

School-API is a Laravel 7 project that consist of a web-api server (REST API) that allows to maintain courses and students via api, using a JWT to secure the requests.

Some of the laravel packages used in this project are:

  - [https://github.com/tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)

Please follow the installation steps to configure the packages.

## PRE-REQUISITES:

  - PHP >= 7.2.5
  - MySQL 5.7.x

All the server requirements of a laravel application are also required to execute this project (composer, extensions, etc), you can find more information on the official website [https://laravel.com/docs/7.x].

## INSTALLATION

    $ git clone https://github.com/earoot/school-api.git
    $ cd school-api/

Create .env file from .env.example and fill the database information with your own, it is also necessary to fill the DEFAULT_API_USER and  DEFAULT_API_PASSWORD variables with your desired data.

NOTE: Normally the information of credentials and sensitive data should not be store in the repository, we are making an exception for this example because the project was made to be shown as a test.

RUN THE FOLLOWING COMMANDS TO CONFIGURE AND FINISH INSTALLATION:

    $ composer install
    $ php artisan key:generate
    $ php artisan config:cache
    $ php artisan migrate --seed
    $ chmod -R 777 storage/
    $ chmod -R 777 bootstrap/cache

## RUN SERVER (LOCALLY)

Open the terminal and go to the project folder and run:

    $ php artisan serve

## EXECUTE VIA DOCKER

Open the terminal and go to the project folder and run:

    $ docker build -t school_api .
	$ docker run --name school-api -p 8080:80 --restart=unless-stopped -d school_api:latest

That`s it...!
