# Be-wallet

Manage your money with ease and efficiency with your prefered device.

## Environment Requirements

The project is recommended running in a docker container with composer installed.

A LAMP stack is ideal.

Additionally, the container can have npm and NodeJs for easy of building frontend views.

## Project Setup

```sh
git clone https://github.com/thanhdung96/be_wallet
cd be_wallet
composer update
```

## Db migration

Please make your own dot env in your local deployment.

Your dot env file should comply with standard Symfony dot env file.

Official documentation can be found [here](https://symfony.com/doc/current/configuration.html#selecting-the-active-environment)

Checking for available DB migrations:

```sh
php bin/console doctrine:migrations:list
```

Migration:

```sh
php bin/console doctrine:migrations:execute --up <migration version>
```

Rollback migration:
```sh
php bin/console doctrine:migrations:execute --down <migration version>
```

## Frontend compilation

For frontend compilation, please refer to the README file in templates/vue/README.md
