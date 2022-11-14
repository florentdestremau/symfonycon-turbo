# Symfony con turbo example project

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
