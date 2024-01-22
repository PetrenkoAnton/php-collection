# php-collection

[![PHP Version](https://img.shields.io/packagist/php-v/petrenkoanton/php-collection)](https://packagist.org/packages/petrenkoanton/php-collection)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/petrenkoanton/php-collection.svg)](https://packagist.org/packages/petrenkoanton/php-collection)
[![Total Downloads](https://img.shields.io/packagist/dt/petrenkoanton/php-collection.svg)](https://packagist.org/packages/petrenkoanton/php-collection)
[![License](https://img.shields.io/packagist/l/petrenkoanton/php-collection)](https://packagist.org/packages/petrenkoanton/php-collection)

[![PHP Composer](https://github.com/PetrenkoAnton/php-collection/actions/workflows/tests.yml/badge.svg)](https://github.com/PetrenkoAnton/php-collection/actions/workflows/tests.yml)
[![Coverage Status](https://coveralls.io/repos/github/PetrenkoAnton/php-collection/badge.svg)](https://coveralls.io/github/PetrenkoAnton/php-collection)
[![type-coverage](https://shepherd.dev/github/petrenkoanton/php-collection/coverage.svg)](https://shepherd.dev/github/petrenkoanton/php-collection)
[![psalm-level](https://shepherd.dev/github/petrenkoanton/php-collection/level.svg)](https://shepherd.dev/github/petrenkoanton/php-collection)
[![Build Status](https://github.com/petrenkoanton/php-collection/workflows/coding-style/badge.svg)](https://github.com/petrenkoanton/php-collection/actions)

[Installation](#installation) | [Functionality](#functionality) | [Usage](#usage) | [For developers](#for-developers) | [License](#license) | [Related projects](#related-projects)

## Installation

### Requirements

- php 8.0 or higher

### Composer

```bash
composer require petrenkoanton/php-collection
```

## Functionality

### Public methods

| Method                                 | Exception                          |
|:---------------------------------------|:-----------------------------------|
| __construct(Collectable ...$items)     | -                                  |
| add(Collectable $item): void           | InvalidItemTypeCollectionException |
| filter(callable $callback): Collection | -                                  |
| getItems(): array                      | -                                  |
| getItem(int $key): Collectable         | InvalidKeyCollectionException      |
| first(): Collectable                   | InvalidKeyCollectionException      |
| count(): int                           | -                                  |

### Exceptions

Main library exception is [CollectionException](./src/Exception/CollectionException.php).

| Code | Message pattern                                               | Exception                          | Parent               |
|------|:--------------------------------------------------------------|:-----------------------------------|:---------------------|
| 100  | Collection: %s &#124; Expected item type: %s &#124; Given: %s | InvalidItemTypeCollectionException | CollectionException  |
| 200  | Collection: %s &#124; Invalid key: %d                         | InvalidKeyCollectionException      | CollectionException  |

## Usage

All collection items must implements `Collection\Collectable` interface:

```php
interface EntityInterface extends Collectable
{
    // ...
}
```

You must call `parent::__construct(...$items);` in your Collection instance:

```php
class EntityInterfaceCollection extends Collection
{
    public function __construct(EntityInterface ...$items)
    {
        parent::__construct(...$items);
    }
}
```

## For developers

### Requirements

Utils:
- make
- [docker-compose](https://docs.docker.com/compose/gettingstarted)

### Setup

#### Initialize

Create `./docker/.env`
```bash
make init 
```

#### Build container with the different php version

php 8.0
```bash
make up80
```

php 8.1
```bash
make up81
```

php 8.2
```bash
make up82
```

php 8.3
```bash
make up83
```

Also you need to run this command before build container with another php version.
It will remove network and previously created container.
```bash
make down
```

#### Other commands

Go inside of the container
```bash
make inside
```

Check php version
```bash
make php-v
```

Check package version
```bash
make v
```

### Run tests and linters

Run [PHPUnit](https://github.com/sebastianbergmann/phpunit) tests with code coverage
```bash
make test-c 
```

Run [Psalm](https://github.com/vimeo/psalm)
```bash
make psalm
```

Run [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
```bash
make phpcs
```

Or by all-in-one command from the inside of the container

```bash
composer check-all
```

## License

The [php-collection](https://github.com/PetrenkoAnton/php-collection) library is open-sourced software licensed under the
[MIT license](https://opensource.org/licenses/MIT).

## Related projects

- [PetrenkoAnton/php-dto](https://github.com/PetrenkoAnton/php-dto)