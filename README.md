# Twig component

[![Actions Status](https://github.com/OXID-eSales/twig-component/workflows/Build/badge.svg)](https://github.com/OXID-eSales/twig-component/actions)

Includes Twig template engine for OXID eShop

## Requirements

* OXID eShop compilation v7.0

## Installation
This component can be installed 
- automatically, as a dependency of one of the OXID Twig themes:
  * [Twig Theme](https://github.com/OXID-eSales/twig-theme) for shop area
  * [Twig Admin Theme](https://github.com/OXID-eSales/twig-admin-theme) for admin area
- or manually:
- 
```bash
composer require oxid-esales/twig-component
```

## Running tests
Update your `test_config.yaml`:
```
additional_test_paths: ./vendor/oxid-esales/twig-component/tests
```
and run:

``vendor/bin/runtests``

## License

See LICENSE file for details.

## Bugs and Issues

If you experience any bugs or issues, please report them in the section **OXID eShop (all versions)** under category **Twig engine** of https://bugs.oxid-esales.com
