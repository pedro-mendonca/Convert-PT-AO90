<?php
/**
 * Convert-PT-AO90
 *
 * Script to build the JSON file with the replace pairs.
 *
 * Build with composer:
 *   > composer build-replace-pairs
 *
 * @package    Convert-PT-AO90
 * @link       https://github.com/pedro-mendonca/Convert-PT-AO90
 * @author     Pedro Mendonça
 * @copyright  2020 Pedro Mendonça
 * @license    GPLv3
 * @version    1.1.0
 */

namespace Convert_PT_AO90;

/**
 * Build JSON file with replace pairs.
 *
 * @since 1.1.0
 *
 * @return void
 */
function build_replace_pairs_json() {

	echo "\n" . 'Build Replace Pairs JSON file' . "\n\n";

	$replace_pairs = get_replace_pairs_csv();

	// File to build.
	$file = 'inc/replace_pairs.json';

	$build = file_put_contents( // phpcs:ignore
		$file,
		json_encode( $replace_pairs, JSON_UNESCAPED_UNICODE ) // phpcs:ignore
	);

	// Check if replace pairs exist and build was successful.
	if ( ! $replace_pairs || ! $build ) {
		printf(
			"\e[31m" . 'File not created: %s' . "\e[39m",
			$file
		);

		echo "\n\n";

		exit( 1 );
	}

	printf(
		"\e[32m" . 'File created successfully: %s' . "\e[39m",
		$file
	);

	echo "\n\n";

	exit( 0 );

}


/**
 * Get all the replace pairs:
 * Main replace pairs from 'AOreplace.txt'
 * Source: languageTool
 * https://github.com/languagetool-org/languagetool/blob/master/languagetool-language-modules/pt/src/main/resources/org/languagetool/rules/pt/AOreplace.txt
 *
 * Customize the replace pairs:
 * 'inc/AOreplace_add.txt' - Add more replace pairs.
 * 'inc/AOreplace_remove.txt' - Remove replace pairs.
 *
 * Information from here:
 * http://www.portaldalinguaportuguesa.org/index.php?action=vop&&page=crit1
 *
 * @since 1.0.0
 *
 * @return false|array{
 *             case_change: array{
 *                 original: array<int, string>,
 *                 replacement: array<int, string>
 *             },
 *             general: array{
 *                 original: array<int, string>,
 *                 replacement: array<int, string>
 *             }
 *         }
 *         Multi-dimensional array replace pairs with both types 'general' and 'case_change'. Return false if files not found.
 */
function get_replace_pairs_csv() {

	$errors = array();

	$library_files = array(
		'main'   => '../lib/languagetool/AOreplace.txt', // Import main AOreplace file.
		'add'    => '../lib/AOreplace_add.txt',          // Import AOreplace file with custom items to add.
		'remove' => '../lib/AOreplace_remove.txt',       // Import AOreplace file with custom items to exclude.
	);

	$files = array();

	foreach ( $library_files as $type => $library_file ) {
		$files[ $type ] = csv_to_array( $library_file, '=', '#' );
		if ( ! $files[ $type ] ) {
			$errors[] = sprintf(
				'File not found: %s',
				$library_file
			);
		}
	}

	if ( ! empty( $errors ) ) {

		echo "\n" . 'Building error(s):' . "\n";

		foreach ( $errors as $error ) {
			printf(
				' - %s%s%s' . "\n",
				"\e[33m",
				$error,
				"\e[39m"
			);
		}

		echo "\n\n";

		return false;

	}

	$files_merge = array_merge( $files['main']['data'], $files['add']['data'] );

	$files_intersect = array_intersect( $files_merge, $files['remove']['data'] );

	$replace_pairs = array_diff( $files_merge, $files_intersect );

	$result = array(
		'case_change' => array(
			'original'    => array(),
			'replacement' => array(),
		),
		'general'     => array(
			'original'    => array(),
			'replacement' => array(),
		),
	);

	foreach ( $replace_pairs as $key => $replace_pair ) {

		// Make sure that $key is always a string.
		$key = strval( $key );

		// Check if starts with the same letter but case has changed.
		if ( strtolower( substr( $key, 0, 1 ) ) === strtolower( substr( $replace_pair, 0, 1 ) ) && substr( $key, 0, 1 ) !== substr( $replace_pair, 0, 1 ) ) {

			// Add item.
			$result['case_change']['original'][]    = $key;
			$result['case_change']['replacement'][] = strval( $replace_pair );

		} else {

			// Add item.
			$result['general']['original'][]    = $key;
			$result['general']['replacement'][] = $replace_pair;

			// Duplicate Uppercase item, for sentences first words.
			$result['general']['original'][]    = ucfirst( $key );
			$result['general']['replacement'][] = ucfirst( $replace_pair );

		}
	}

	return $result;

}


/**
 * Convert specified delimiter separated file into an associative array.
 * The commented and empty rows are excluded.
 *
 * Inspired in http://gist.github.com/385876 by Jay Williams.
 *
 * @since 1.0.0
 *
 * @param string $filename        Path to the text file.
 * @param string $delimiter       The separator used in the file.
 * @param string $comment_start   The character used to comment the row.
 *
 * @return false|array{
 *             comments: array<int, string>,
 *             data: array<string, string>
 *         }
 *         Associative array of the file Comments and Data. Return false if file not found.
 */
function csv_to_array( $filename = '', $delimiter = ',', $comment_start = '#' ) {

	$filename = __DIR__ . DIRECTORY_SEPARATOR . $filename;

	if ( ! file_exists( $filename ) || ! is_readable( $filename ) ) {
		return false;
	}

	$file_data = array(
		'comments' => array(),
		'data'     => array(),
	);

	if ( false !== ( $handle = fopen( $filename, 'r' ) ) ) {

		while ( false !== ( $row = fgetcsv( $handle, 1000, $delimiter ) ) ) {

			if ( is_array( $row ) && substr( trim( $row[0] ), 0, 1 ) === $comment_start ) { // Check if row is comment.

				// Add full row to comments array.
				$file_data['comments'][] = implode( $delimiter, $row );

			} elseif ( is_array( $row ) && null !== $row[0] ) { // Check if is not an empty row.

				// Add lowercase entry.
				$file_data['data'][ strval( $row[0] ) ] = strval( $row[1] );

			}
		} // End while.

		fclose( $handle );
	}

	return $file_data;
}


/*
 * Build the replace pairs JSON file.
 */
build_replace_pairs_json();
