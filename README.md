<img src="https://repository-images.githubusercontent.com/304012585/a73f6380-0fa2-11eb-86ad-933e046ae964" align="right" width="112" height="56" alt="">

# Convert PT AO90

[![Packagist version](https://img.shields.io/packagist/v/pedro-mendonca/Convert-PT-AO90?label=Packagist)](https://packagist.org/packages/pedro-mendonca/convert-pt-ao90)
[![Release Date](https://img.shields.io/github/release-date/pedro-mendonca/Convert-PT-AO90?label=Release%20Date)](https://github.com/pedro-mendonca/Convert-PT-AO90/releases)
[![License](https://img.shields.io/github/license/pedro-mendonca/Convert-PT-AO90?label=License)](https://opensource.org/licenses/GPL-3.0)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/pedro-mendonca/convert-pt-ao90?label=PHP%20Required&logo=PHP&logoColor=white)](https://github.com/pedro-mendonca/Convert-PT-AO90/actions/workflows/php-compatibility.yml)
[![Sponsor](https://img.shields.io/badge/GitHub-🤍%20Sponsor-ea4aaa?logo=github)](https://github.com/sponsors/pedro-mendonca)

[![Test](https://github.com/pedro-mendonca/Convert-PT-AO90/actions/workflows/test.yml/badge.svg)](https://github.com/pedro-mendonca/Convert-PT-AO90/actions/workflows/test.yml)
[![Coding Standards](https://github.com/pedro-mendonca/Convert-PT-AO90/actions/workflows/coding-standards.yml/badge.svg)](https://github.com/pedro-mendonca/Convert-PT-AO90/actions/workflows/coding-standards.yml)
[![Static Analysis](https://github.com/pedro-mendonca/Convert-PT-AO90/actions/workflows/static-analysis.yml/badge.svg)](https://github.com/pedro-mendonca/Convert-PT-AO90/actions/workflows/static-analysis.yml)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/cbdc5b23059143879de61527501ba199)](https://app.codacy.com/gh/pedro-mendonca/Convert-PT-AO90?utm_source=github.com&utm_medium=referral&utm_content=pedro-mendonca/Convert-PT-AO90&utm_campaign=Badge_Grade)

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

### 1.2.3

*   Rebuild replace pairs.

### 1.2.2

*   Fix sentence boundary issue with HTML after ending.
*   Add sentence boundary after two new lines.
*   Add more tests: new lines followed by HTML.

### 1.2.1

*   Fix JSON path issue when used as dependency.

### 1.2.0

*   Rebuild code to allow a detailed control over sentence and word boundaries.
*   Fix problem of partial find+replace of words, now only whole words can be converted.
*   Remove temporary bug fix of partial find+replace (acto->ato).
*   Update main replace pairs library.
*   Add more custom replace pairs rules.
*   Rebuild and add both replace pairs JSON, minified and source (pretty).
*   Add more tests for many different types of texts: Multiline, HTML, multiple sentences, etc.

### 1.1.0

*   Use a pre-built Replace Pairs JSON file to improve performance (5x faster).
*   Simplify Replace Pairs data.
*   Bump minimum PHP to 7.2.
*   Add Tests! [Run the Convert PT AO90](https://github.com/pedro-mendonca/Convert-PT-AO90/actions/workflows/test.yml) against a [set of text strings](https://github.com/pedro-mendonca/Convert-PT-AO90/blob/main/tests/convert-pt-ao90-test.php#L26:L70) with expected results.
*   Add some custom replace pairs rules.

### 1.0.3

*   Move CI to GitHub Actions.
*   Bump PHPStan Level to 9.
*   Add Markdownlint and PHPMD.
*   Fix coding standards.

### 1.0.2

*   Fix autoload and library path for package installed as composer dependency.

### 1.0.1

*   Add Composer install support.

### 1.0.0

*   Initial release.
