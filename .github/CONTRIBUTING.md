# CONTRIBUTING

We are using [GitHub Actions](https://github.com/features/actions) as a continuous integration system.

For details, take a look at the following workflow configuration files:

- [`workflows/continuous-integration.yaml`](workflows/continuous-integration.yaml)
- [`workflows/lock-closed-issues.yaml`](workflows/lock-closed-issues.yaml)
- [`workflows/stale.yaml`](workflows/stale.yaml)

## Coding Standards

We are using [`ergebnis/composer-normalize`](https://github.com/ergebnis/composer-normalize) to normalize `composer.json`.

We are using [`friendsofphp/php-cs-fixer`](https://github.com/FriendsOfPHP/PHP-CS-Fixer) and [`squizlabs/php_codesniffer`](https://github.com/squizlabs/PHP_CodeSniffer) to enforce coding standards in PHP files.

Run

```sh
vendor/bin/phpcs
vendor/bin/php-cs-fixer fix --dry-run
```

to automatically fix coding standard violations.

## Static Code Analysis

We are using [`phpstan/phpstan`](https://github.com/phpstan/phpstan) to statically analyze the code.

Run

```sh
vendor/bin/phpstan analyse -c phpstan.neon
```

to run a static code analysis.

## Tests

We are using [`phpunit/phpunit`](https://github.com/sebastianbergmann/phpunit) to drive the development.

Run

```sh
vendor/bin/phpunit -c phpunit.xml
```

to run all the tests.

## Mutation Tests

We are using [`infection/infection`](https://github.com/infection/infection) to ensure a minimum quality of the tests.

Enable `pcov` or `Xdebug` and run

```sh
vendor/bin/infection
```

to run mutation tests.
