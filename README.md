# Numeric Calculus

- [Containers](https://gitlab.com/integrativebioinformatics/infrastructure/metavolcano#containers)
- [Infrastructure](https://gitlab.com/integrativebioinformatics/infrastructure/metavolcano#infrastructure)
- [Installation](https://gitlab.com/integrativebioinformatics/infrastructure/metavolcano#installation)
- [Pre-execution](https://gitlab.com/integrativebioinformatics/infrastructure/metavolcano#pre-execution)
- [Execution](https://gitlab.com/integrativebioinformatics/infrastructure/metavolcano#execution)
- [SSL](https://gitlab.com/integrativebioinformatics/infrastructure/metavolcano#ssl)

## Containers

- *Webserver* - Nginx;
- *Backend PHP* - PHP-fpm;

2 Containers.

## Infrastructure

![Infrastructure metavolcano](build/images/infra-metavolcano.jpeg)

## Requisites

- Git
- Docker version 17.09.1-ce or above (https://docs.docker.com/install/)
- Docker Compose 1.20.1 or above (https://docs.docker.com/compose/install)

## Installation

Clone the repository recursively with:
```
user@host:~# git clone --recurse-submodules https://gitlab.com/integrativebioinformatics/infrastructure/metavolcano.git
```
This mode the repositorys the frontend and backend are cloned.


## Pre-execution

Create file `.env` in root directory on repository informing enviremont variables, example content:

```bash
user@host:~/metavolcano# cat .env
REPOSITORY=git@gitlab.com:integrativebioinformatics/frontend/metavolcano-front.git
BRANCH_STABLE=master
TOKEN=dEfInEsEcUrItYtOkEnFoRuSeInWeBhOoK
```

Define permissions for user `www-data` in directory back/front which will be mounted as volume in container. Because the user may not exist on the host host, we use the gid that is standard on any system. Execute:

```bash
user@host:~/metavolcano# chown 33:33 -R volumes/metavolcano-front
```

## Execution

In the root repository, execute the next command:

```bash
user@host:~/metavolcano# docker-compose up -d
```
The option `-d` execute containers in background.

## SSL

Per default, the first execution use no-ssl. Case need use ssl, after execution (with containers running), do following:

```
user@host:~/metavolcano# docker exec numerico_letsencrypt  bash -c 'certbot certonly --email ${EMAIL_LETS} -a webroot --webroot-path=${DIRETORIO} -d ${FQDN} -d ${DOMAIN} --agree-tos'
```

OBS.: Use option -d according with need.

After, in projecty directory:

```
user@host:~/metavolcano# docker-compose restart webserver_metavolcano
Restarting proxy ... done
```

Enjoy!
