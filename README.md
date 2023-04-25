# Symfony con 2022 turbo example project

_Note: this repo is now read-only, serving as an example. I made another talk @ Symfony LIve Paris 2023 about this and created another project: https://github.com/florentdestremau/turbo-paris-live_

## Requirements

- php 8.1 with sqlite extension
- symfony cli
- node v16
- yarn

## Install

```shell
git clone git@github.com:florentdestremau/symfonycon-turbo.git
cd symfonycon-turbo/
composer install
yarn install
bin/console doctrine:migrations:migrate -n
symfony server:start -d
yarn encore dev-server

# go to https://localhost:8000
```


## Frankenphp

You can run the project with [frankenphp](https://github.com/dunglas/frankenphp) using the command `make frankenphp` (requires docker usage).
