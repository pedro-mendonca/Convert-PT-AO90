# Convert PT AO90

## Description
Open source language tool to convert Portuguese to AO90

## Installation

1. Add this package folder to your project.

2. include the main file `convert-pt-ao90.php` in your project.
```
/**
 * Require Convert-PT-AO90.
 */
require_once 'convert-pt-ao90/convert-pt-ao90.php';
```

## Usage

Examples:

1.
`Convert_PT_AO90\convert_pt_ao90( 'Não me pélo pelo pêlo de quem pára para resistir' );`

2.
```
$string = 'Não me pélo pelo pêlo de quem pára para resistir';
$string_ao90 = Convert_PT_AO90\convert_pt_ao90( $string );
echo $string_ao90;
```

3. See more examples and the complete replace pairs in the file [example.php](https://github.com/pedro-mendonca/Convert-PT-AO90/blob/main/example.php).

## Changelog ##

### 1.0.0 ###
*   Initial release.
