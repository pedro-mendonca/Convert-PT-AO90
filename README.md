# Convert PT AO90

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/cbdc5b23059143879de61527501ba199)](https://app.codacy.com/gh/pedro-mendonca/Convert-PT-AO90?utm_source=github.com&utm_medium=referral&utm_content=pedro-mendonca/Convert-PT-AO90&utm_campaign=Badge_Grade)

## Description
Open source language tool to convert Portuguese to AO90

## Installation

1. Add this package to your project folder.

2. Include the main file `convert-pt-ao90.php` in your project.
```
/**
 * Require Convert-PT-AO90.
 */
require_once 'convert-pt-ao90/convert-pt-ao90.php';
```

## Usage

Examples:

1. `Convert_PT_AO90\convert_pt_ao90( 'Não me pélo pelo pêlo de quem pára para resistir!' );`

2.
```
$string = 'Não me pélo pelo pêlo de quem pára para resistir!';
$string_ao90 = Convert_PT_AO90\convert_pt_ao90( $string );
echo $string_ao90;
```

3. See more examples and the complete replace pairs in the file [example.php](https://github.com/pedro-mendonca/Convert-PT-AO90/blob/main/example.php).

## Changelog ##

### 1.0.0 ###
*   Initial release.
