<img src="https://repository-images.githubusercontent.com/304012585/a73f6380-0fa2-11eb-86ad-933e046ae964" align="right" width="112" height="56" alt="">

# Convert PT AO90

[![Packagist version](https://img.shields.io/packagist/v/pedro-mendonca/Convert-PT-AO90)](https://packagist.org/packages/pedro-mendonca/convert-pt-ao90)
[![Release Date](https://img.shields.io/github/release-date/pedro-mendonca/Convert-PT-AO90)](https://github.com/pedro-mendonca/Convert-PT-AO90/releases)
[![License](https://img.shields.io/github/license/pedro-mendonca/Convert-PT-AO90)](https://opensource.org/licenses/GPL-3.0)
[![PHP from Travis config](https://img.shields.io/travis/php-v/pedro-mendonca/Convert-PT-AO90/main.svg?logoColor=white&label=PHP%20Required&logo=php)](https://travis-ci.org/pedro-mendonca/Convert-PT-AO90)
[![Sponsor](https://img.shields.io/badge/GitHub-🤍%20Sponsor-ea4aaa?logo=github)](https://github.com/sponsors/pedro-mendonca)

[![Build Status](https://img.shields.io/travis/com/pedro-mendonca/Convert-PT-AO90?label=Build&logo=travis)](https://travis-ci.com/github/pedro-mendonca/Convert-PT-AO90)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/cbdc5b23059143879de61527501ba199)](https://app.codacy.com/gh/pedro-mendonca/Convert-PT-AO90?utm_source=github.com&utm_medium=referral&utm_content=pedro-mendonca/Convert-PT-AO90&utm_campaign=Badge_Grade)
[![PHPStan Level](https://img.shields.io/badge/PHPStan%20Level-Max-brightgreen)](https://github.com/pedro-mendonca/Convert-PT-AO90/blob/main/phpstan.neon#L10)

## Description

Language tool to convert text according to the [Portuguese Language Orthographic Agreement of 1990](https://en.wikipedia.org/wiki/Portuguese_Language_Orthographic_Agreement_of_1990) ([PT AO90](https://pt.wikipedia.org/wiki/Acordo_Ortogr%C3%A1fico_de_1990))

## Installation instructions

Installation can be done with [Composer](https://getcomposer.org/), by requiring this package as a dependency:

```command-line
composer require pedro-mendonca/convert-pt-ao90
```

Make sure to include composer autoload in your project:

```php
/**
 * Include Composer autoload.
 */
require 'vendor/autoload.php';
```

If you don't use [Composer](https://getcomposer.org/), you can **install manually** by downloading the [latest release](https://github.com/pedro-mendonca/Convert-PT-AO90/releases/latest), add it to your project folder and **include** the main file in your code:

```php
/**
 * Include Convert-PT-AO90.
 */
require_once '<path-to-folder>/convert-pt-ao90/convert-pt-ao90.php';
```

## Usage

Examples:

1. Convert text string:

   ```php
   $text = 'Não me pélo pelo pêlo de quem pára para resistir!';
   $string_ao90 = Convert_PT_AO90\convert_pt_ao90( $text );
   echo $string_ao90;
   ```

2. See more examples and the complete replace pairs in the file [example.php](https://github.com/pedro-mendonca/Convert-PT-AO90/blob/main/example.php).

## Changelog

### 1.0.2

*   Fix autoload and library path for package installed as composer dependency.

### 1.0.1

*   Add Composer install support.

### 1.0.0

*   Initial release.
