# symfony4-ddd-hexarch-cqrs.

Main features:
- [x] Docker
- [x] Symfony 4
- [x] DDD guidelines
- [x] Hexagonal Architecture 
- [x] SOLID
- [x] Albums parts with CQRS pattern (command and query bus)
- [x] No anemic models pattern
- [x] Webpack, Yarn, Babel, Bootstrap 4 and some other frontend tools


## Installation

1.  Software requirements:

    * PHP 7.1.3+
    * Node: How to install Node? [Please click here](https://nodejs.org/en/download/)
    * Yarn: How to install Yarn? [Please click here](https://yarnpkg.com/lang/en/docs/install/)
    * docker: How to install docker? [Please click here](https://docs.docker.com/install/)

    Verify the proper installation:

    ```
    php -v ; docker -v ; node -v ; yarn -v
    ```

    It should response something like: (versions could be different)

    ```
    PHP 7.1.14 (cli) (built: Feb  2 2018 08:42:59) ( NTS )
    Copyright (c) 1997-2018 The PHP Group
    Zend Engine v3.1.0, Copyright (c) 1998-2018 Zend Technologies
        with the ionCube PHP Loader v10.0.4, Copyright (c) 2002-2017, by ionCube Ltd.
        with Xdebug v2.6.0, Copyright (c) 2002-2018, by Derick Rethans
    Docker version 17.12.0-ce, build c97c6d6
    v9.7.1
    1.5.1
    ```

2.  Download dependencies:
    ```
    composer install;composer update
    yarn  
    ```
3.  Generate frontend assets
    ```
    yarn build:prod
    ```
4.  Creates docker database container:
    ```
    docker run --name db --rm \
        -e MYSQL_HOST=127.0.0.1 \
        -e MYSQL_ROOT_HOST=% \
        -e MYSQL_DATABASE=db \
        -e MYSQL_ROOT_USER=root \
        -e MYSQL_ROOT_PASSWORD=root \
        -e MYSQL_USER=dev \
        -e MYSQL_PASSWORD=dev \
        -p 3306:3306 \
        -v `pwd`/src/Infrastructure/Docker/mysql/:/etc/mysql/conf.d/ \
        -v `pwd`/var/storage/db/:/var/lib/mysql \
        -d mysql:5.7 --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci --init-connect='SET NAMES UTF8;' --innodb-flush-log-at-trx-commit=0
    ```
5.  Execute migrations (schema):
    ```
    bin/console doctrine:migrations:migrate --no-interaction
    ```
    Note: If you get "PDO::\_\_construct(): MySQL server has gone away" please few seconds in order to MySQL container generate all local files needed.
6.  Configure environment:

    ```
    cp .env.dist .env
    ```

## Run the code

```
sudo php -S 127.0.0.1:80 -t src/Infrastructure/UserInterface/Web/Public
```

And open in browser: [http://localhost](http://localhost)

## Running the tests

1.  Software requirements:
    
    Install software requirements in the 'Installation' section of this document. 

2.  Creates docker testing database container:
    ```
    docker run --name db_testing --rm \
        -e MYSQL_HOST=127.0.0.1 \
        -e MYSQL_ROOT_HOST=% \
        -e MYSQL_DATABASE=db_testing \
        -e MYSQL_ROOT_USER=root \
        -e MYSQL_ROOT_PASSWORD=root \
        -e MYSQL_USER=dev \
        -e MYSQL_PASSWORD=dev \
        -p 3307:3306 \
        -v `pwd`/src/Infrastructure/Docker/mysql_testing/:/etc/mysql/conf.d/ \
        -v `pwd`/var/storage/db_testing/:/var/lib/mysql \
        -d mysql:5.7 --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci --init-connect='SET NAMES UTF8;' --innodb-flush-log-at-trx-commit=0
    ```
3.  Configure test environment:

    ```
    cp .env-test.dist .env
    ```
4.  Execute migrations (schema):
    ```
    bin/console doctrine:migrations:migrate --no-interaction
    ```

**Run the tests:**

```
bin/phpunit
```

**Note**: There is no 100% coverage test @todo

## Assets

Common tasks:

```
# generate development assets
yarn build:dev
```

```
# generate production (minify and optimize) assets
yarn build:prod
```
