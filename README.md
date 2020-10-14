# Convert PT AO90

## Description
Open source language tool to convert Portuguese to AO90

## Installation

1. Add this package folder to your project.
2. Link the main `convert-pt-ao90.php` file in your project.
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

## Changelog ##

### 1.0.0 ###
*   Initial release.
