# RNAmining

https://gitlab.com/integrativebioinformatics/RNAmining

## Containers

- *Webserver* - Nginx;
- *Backend PHP* - PHP-fpm;

2 Containers.

## Requisites

- Git version 2 or above
- Docker version 17.09.1-ce or above (https://docs.docker.com/install/)
- Docker Compose 1.20.1 or above (https://docs.docker.com/compose/install)

## Installation

Clone the repository recursively with:
```
user@host:~# git clone https://gitlab.com/integrativebioinformatics/RNAmining.git
```
This mode the repositorys the frontend and backend are cloned.


## Pre-execution

Create file `.env` in root directory on repository informing enviremont variables, example content:

```bash
user@host:~/RNAmining# vim .env
DOCUMENT_ROOT=/var/www/html
```

Define permissions for user `www-data` in directory back/front which will be mounted as volume in container. Because the user may not exist on the host host, we use the gid that is standard on any system. Execute:

```bash
user@host:~/RNAmining# chown 33:33 -R volumes/rnamining-front
```

## Execution

In the root repository, execute the next command:

```bash
user@host:~/RNAmining# docker-compose -f docker-compose2.yml up --build -d
```
The option `-d` execute containers in background.

Cite the code: [![DOI](https://zenodo.org/badge/359168403.svg)](https://zenodo.org/badge/latestdoi/359168403)

Enjoy!
