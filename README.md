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

[Installation](#installation) | [Functionality](#functionality) | [Usage](#usage) | [For developers](#for-developers) | [License](#license)

## Installation

### Requirements

- PHP8.0 or higher

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

| Exception                          | Parent               | Message pattern                                               | Code |
|:-----------------------------------|:---------------------|:--------------------------------------------------------------|------|
| InvalidItemTypeCollectionException | CollectionException  | Collection: %s &#124; Expected item type: %s &#124; Given: %s | 100  |
| InvalidKeyCollectionException      | CollectionException  | Collection: %s &#124; Invalid key: %d                         | 200  |

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

Initialize:

```bash
make init # Create ./docker/.env 
```

Build container with the different php version:

```bash
make up80 # php8.0
make up81 # php8.1
make up82 # php8.2
make up83 # php8.3
```

Also you need to run this command before build container with another php version:

```bash
make down # Removes network and container
```

Other commands:

```bash
make inside # Go inside of the container
make php-v # Check php version
make v # Check package version
```

### Run tests and linters

Using `make` util:

```bash
make test-c # Run tests with code coverage
make psalm # Run Psalm
make phpcs # Run PHP_CSFixer
```

Or from the inside of the container: 

```bash
composer check-all
```

## License

The [php-collection](https://github.com/PetrenkoAnton/php-collection/) library is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).