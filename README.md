<p align="center">

[![Version][version-shield]][version]
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]

</p>

<br />

<h2 align="center">symfony-ddd-hexarch-cqrs</h3>
<p align="center">
    Code examples and good practices using Domain Drive Development, Hexagonal Architecture, CQRS, 
    Symfony 6, PHP8 and anything else I can think of... 
    <br /><br />
    <a href="https://symfony.com/"><img src="https://img.shields.io/badge/Symfony-6-42a7ff.svg?style=flat-square&logo=symfony" alt="Symfony 5"/></a>
    <a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-8-777BB4.svg?style=flat-square&logo=php" alt="PHP"/></a>
    <a href="https://www.docker.com/"><img src="https://img.shields.io/badge/docker-20.10-2496ED.svg?style=flat-square&logo=docker" alt="Docker"/></a>
    <a href="https://www.mysql.com/"><img src="https://img.shields.io/badge/mysql-8-4479A1.svg?style=flat-square&logo=mysql" alt="MySql"/></a>
    <a href="https://www.sqlite.org/index.html"><img src="https://img.shields.io/badge/sqlite-3-003B57.svg?style=flat-square&logo=sqlite" alt="SQLite"/></a>
    <br /><br />
    <a href="https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/issues">Report Bug</a>
    ·
    <a href="https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/issues">Request Feature</a>
</p>

<br />

[![Build Status](https://api.travis-ci.com/masfernandez/symfony-ddd-hexarch-cqrs.svg?branch=master)](https://app.travis-ci.com/github/masfernandez/symfony-ddd-hexarch-cqrs)
[![Coverage Status](https://coveralls.io/github/masfernandez/symfony-ddd-hexarch-cqrs)](https://coveralls.io/github/masfernandez/symfony-ddd-hexarch-cqrs)

<br />

<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
        <li><a href="#running-prod-env">Running prod env</a></li>
        <ul>
            <li><a href="#curl-examples">Curl examples</a></li>
        </ul>
        <li><a href="#docker-services">Docker services</a></li>
        <ul>
            <li><a href="#rabbitmq">RabbitMQ</a></li>
            <li><a href="#kibana">Kibana</a></li>
        </ul>
        <li><a href="#running-dev-env">Running dev env</a></li>
        <li><a href="#tests">Tests</a></li>
      </ul>
    </li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgements">Acknowledgements</a></li>
  </ol>
</details>

## About The Project

I have created this project to have a guide of code examples and good practices as a future reference for me and for anyone who may be interested.

I will be adding more examples that I think are interesting and that provide an extra for anyone who wants to get started in the technologies mentioned bellow.

**Features**

- [x] PHP8
- [x] Symfony 6
- [x] DDD guidelines
- [x] Hexagonal Architecture
- [x] SOLID
- [x] Docker
- [x] Doctrine ORM & DB migrations
- [x] Albums module with CQRS pattern (command and query bus)
- [x] Static code analysis: PHPCS, Rector, Psalm 
- [x] Unit and integration tests: PHPUnit
- [x] Acceptance tests: Behat
- [x] Basic Authorization, with mandatory token to http POST endpoints
- [x] Basic JWT Authorization, with mandatory token to http PUT endpoints  
- [x] NoSql: Redis examples
- [x] Frontend examples (React, Redux, Webpack, Babel, etc.): on this [repo](https://github.com/masfernandez/react-front-webapp)
- [x] Elastic stack (Elasticsearch, Logstash, Kibana, Filebeat) 

**Upcoming Features**
- Aggregates organization  
- Using native PHP amqp extension to publish events (instead of Symfony/Messenger)
- RabbitMQ configuration wizard (queues and exchanges, retry, dead-letter and bindings)
- Supervisor configuration wizard (file .ini per queue)


## Getting Started

I will add new features and examples, this project is constantly evolving! You can see unreleased code at [here](https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/compare/master...develop)

### Prerequisites

- docker: How to install docker? [Please click here](https://docs.docker.com/install/)
- make

### Installation

Clone repo, download deps and create docker services:

```bash
git clone https://github.com/masfernandez/symfony-ddd-hexarch-cqrs.git
cd symfony-ddd-hexarch-cqrs
make composer-install
make up
```

### Running prod env
Execute at root path:

```bash
make prod-start
```

#### Request examples

In order to create a new `Album` is mandatory to include a valid `Token` in request's Authorization header. So first, let's  create a new User:

```bash
make create-demo-user
# Credentials for demo user: test@email.com 1234567890
```

**Now, it's time to get a valid token**:

```bash
curl -i -X POST 'http://api.musiclabel.127.0.0.1.nip.io/authentication' \
-H 'Content-Type: application/json' \
--data-raw '{
    "email": "test@email.com",
    "password": "1234567890"
}'
```

You can find the Token in response's Location header:

```bash
Server: nginx/1.19.5
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/8.0.0
Location: 4ac71eeda13c8fe7f0e4c017412bd9f2d886288cb8c88331007f2a9c7652385b
Cache-Control: no-cache, private
Date: Fri, 15 Jan 2021 11:23:45 GMT
X-Robots-Tag: noindex
Strict-Transport-Security: max-age=31536000

{}
```

**We can publish new Albums now**: (replace the value of the token here with the one you got before... obviously)

```bash
curl -i -X POST 'http://api.musiclabel.127.0.0.1.nip.io/albums' \
-H 'Authorization: Bearer 4ac71eeda13c8fe7f0e4c017412bd9f2d886288cb8c88331007f2a9c7652385b' \
-H 'Content-Type: application/json' \
--data-raw '{
    "id": "0da69030-3ed7-42b5-8aa5-25fb61dab1b2",
    "title": "Abbey Road",
    "release_date": "1969-09-26 00:00:00"  
}'
```

**Verifying the Album created**:
```bash
curl -X GET 'http://api.musiclabel.127.0.0.1.nip.io/albums?page[number]=1&page[size]=1&sort=title&fields[albums]=id,title,release_date'
```

**We need a JWToken to make PUT operations on Albums, so let's get one**:
```bash
curl -i -X POST 'http://api.musiclabel.127.0.0.1.nip.io/authentication/jwt' \
-H 'Content-Type: application/json' \
--data-raw '{
    "email": "test@email.com",
    "password": "1234567890"
}'
```

You can find the JWToken (header.payload.signature) in response's headers:
* header+payload in Location header
* signature in set-cookie header

```bash
HTTP/2 201 
server: nginx/1.19.8
content-type: application/json
location: header+payload:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJqdGkiOiJlWFZocHBTR0JwZllTeHNZIiwiaWF0IjoxNjE3MzU1NTMyLjQyNzU3MSwibmJmIjoxNjE3MzU1NTMzLjQyNzU3MSwiZXhwIjoxNjE3MzU5MTMyLjQyNzU3MSwidWlkIjoiMGY4MzNjMjItZmVmZC00ZmFmLWE3YzItNGEwNzlhMjJjMzdjIn0
x-powered-by: PHP/8.0.3
cache-control: no-cache, private
date: Fri, 02 Apr 2021 09:25:32 GMT
x-robots-tag: noindex
set-cookie: signature=GFZiEgVkKIbv5YszK_5wKmhLpqlkhYUUS1N1nCLLavs; path=/; secure; httponly; samesite=none
strict-transport-security: max-age=31536000
```

You may be asking why sending the JWToken like this... well, I'm to lazy to write hundred of words when there is a lot of information already on there. Just few tips:

* Main reason is security (XSS and CSRF). This is an evolved example of the following medium article:
* [https://medium.com/@ryanchenkie_40935/react-authentication-how-to-store-jwt-in-a-cookie-346519310e81](https://medium.com/@ryanchenkie_40935/react-authentication-how-to-store-jwt-in-a-cookie-346519310e81)
  
Recommend read:
* [http://cryto.net/~joepie91/blog/2016/06/13/stop-using-jwt-for-sessions/](http://cryto.net/~joepie91/blog/2016/06/13/stop-using-jwt-for-sessions/)

Don't forget the purpose of this repo: *just to show some examples, crazy dev ideas and my opinionated vision on how to approach some scenarios* ;)   


**Let's replace Album created before**:

The client (React, Vue, Curl, Postman... whatever) should know how to re-construct the JWToken to make a request (remember, header + payload in Authorization header and signature in cookie)

Note: replace the values of the token here with the one you got before... obviously
```bash
curl -i -X PUT 'http://api.musiclabel.127.0.0.1.nip.io/albums/0da69030-3ed7-42b5-8aa5-25fb61dab1b2' \
-H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJqdGkiOiJlWFZocHBTR0JwZllTeHNZIiwiaWF0IjoxNjE3MzU1NTMyLjQyNzU3MSwibmJmIjoxNjE3MzU1NTMzLjQyNzU3MSwiZXhwIjoxNjE3MzU5MTMyLjQyNzU3MSwidWlkIjoiMGY4MzNjMjItZmVmZC00ZmFmLWE3YzItNGEwNzlhMjJjMzdjIn0' \
-H 'Content-Type: application/json' \
-H 'Cookie: signature=GFZiEgVkKIbv5YszK_5wKmhLpqlkhYUUS1N1nCLLavs' \
--data-raw '{
    "title": "New album value here",
    "release_date": "2021-04-02 00:00:00"
}'
```

Response:
```bash
HTTP/2 204 
server: nginx/1.19.8
x-powered-by: PHP/8.0.3
cache-control: no-cache, private
date: Fri, 02 Apr 2021 09:58:22 GMT
x-robots-tag: noindex
strict-transport-security: max-age=31536000

```

**Verifying the Album updated**:
```bash
curl -i -X GET 'http://api.musiclabel.127.0.0.1.nip.io/albums?page[number]=1&page[size]=1&sort=title&fields[albums]=id,title,release_date'
```

Response:
```bash
HTTP/2 200 
server: nginx/1.19.8
content-type: application/json
x-powered-by: PHP/8.0.3
cache-control: no-cache, private
date: Fri, 02 Apr 2021 09:59:36 GMT
x-robots-tag: noindex
strict-transport-security: max-age=31536000

{
    "data": [
        {
            "id": "0da69030-3ed7-42b5-8aa5-25fb61dab1b2",
            "title": "New album value here",
            "release_date": "2021-04-02 00:00:00"
        }
    ],
    "links": {
        "self": "\/albums?page%5Bnumber%5D=1&page%5Bsize%5D=1",
        "first": "\/albums?page%5Bnumber%5D=1&page%5Bsize%5D=1",
        "prev": "\/albums?page%5Bnumber%5D=1&page%5Bsize%5D=1",
        "next": "\/albums?page%5Bnumber%5D=1&page%5Bsize%5D=1",
        "last": "\/albums?page%5Bnumber%5D=1&page%5Bsize%5D=1"
    },
    "meta": {
        "total_pages": 1
    }
} 
```

### Docker services

Several docker services will be available and ready for use when the app starts: 

**RabbitMQ** 

> [http://localhost:15672](http://localhost:15672)\
> user: rabbit_user\
> password: rabbit_pass

**Kibana**

>[http://localhost:5601](http://localhost:5601)

Kibana Nginx logs configuration:

* Execute below command after all ELK services are started: 
    ```
    make filebeat-dashboards
    ```
    
* Go to http://localhost:5601/app/dashboards and search for "Nginx"

Kibana Symfony logs configuration:
  
* Create a index pattern at [http://localhost:5601/app/management/kibana/indexPatterns/create](http://localhost:5601/app/management/kibana/indexPatterns/create)

  * Step 1. Write "logstash*" as index pattern and press "Next" button
  * Step 2. Select @timestamp for Time field and press "Create index" button
    
* Configure logs
  * Step 3. Go to [http://localhost:5601/app/logs/settings](http://localhost:5601/app/logs/settings) and include "logs-*,filebeat-*,logstash*" in `Log indices´ field and confirm pressing Apply button at bottom page.

Logs can be visualized now at [http://localhost:5601/app/logs/stream](http://localhost:5601/app/logs/stream)

### Running dev env

```
make dev-start
```

### Tests
```
make test
```

### Docker info
There are several services in the Docker stack for this project. All services are built from official docker images except:

- Nginx: Custom docker image. I will optimize some parameters soon but at this moment is just a wrapper of the official docker image. More info [here](https://github.com/masfernandez/symfony-docker-nginx-phpfpm/blob/master/docker/nginx/Dockerfile)
- PHP-FPM: Custom docker image. It has 2 main targets, for production and development environment. Each env has some deps that you can check at [here](https://github.com/masfernandez/symfony-docker-nginx-phpfpm/blob/master/docker/php/Dockerfile). This is also a repo I'm working on.

## Roadmap

See the [open issues](https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/issues) for a list of proposed features (and known issues).


## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request


## License

Distributed under the MIT License. See `LICENSE.txt` for more information.


## Contact

Miguel Ángel Sánchez Fernández - mangel.sanfer@gmail.com

(linkedin hiden profile - require login)

[![LinkedIn][linkedin-shield]][linkedin-url] 

Project Link: [https://github.com/masfernandez/symfony-ddd-hexarch-cqrs](https://github.com/masfernandez/symfony-ddd-hexarch-cqrs)


## Acknowledgements

* README template based on: [https://github.com/othneildrew/Best-README-Template](https://github.com/othneildrew/Best-README-Template)
* CHANGELOG template based on: [https://keepachangelog.com/en/1.0.0/](https://keepachangelog.com/en/1.0.0/)

## Stats

<p>
    <img src="https://views.whatilearened.today/views/github/masfernandez/views.svg"/>
</p>

[version-shield]: https://img.shields.io/github/v/tag/masfernandez/symfony-ddd-hexarch-cqrs?style=for-the-badge
[version]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/tags

[contributors-shield]: https://img.shields.io/github/contributors/masfernandez/symfony-ddd-hexarch-cqrs.svg?style=for-the-badge
[contributors-url]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/graphs/contributors

[forks-shield]: https://img.shields.io/github/forks/masfernandez/symfony-ddd-hexarch-cqrs.svg?style=for-the-badge
[forks-url]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/network/members

[stars-shield]: https://img.shields.io/github/stars/masfernandez/symfony-ddd-hexarch-cqrs.svg?style=for-the-badge
[stars-url]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/stargazers

[issues-shield]: https://img.shields.io/github/issues/masfernandez/symfony-ddd-hexarch-cqrs.svg?style=for-the-badge
[issues-url]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/issues

[license-shield]: https://img.shields.io/github/license/masfernandez/symfony-ddd-hexarch-cqrs.svg?style=for-the-badge
[license-url]: https://github.com/masfernandez/symfony-ddd-hexarch-cqrs/blob/master/LICENSE.txt

[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/masfernandez