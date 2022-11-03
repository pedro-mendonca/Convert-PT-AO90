<?php
/**
 * Script to build the JSON file with the replace pairs.
 *
 * Build with composer:
 *   > composer build-replace-pairs
 *
 * @package Convert-PT-AO90
 * @since   1.1.0
 * @since   1.2.0   Builds both compact and pretty JSON files.
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

	// Bright white header.
	echo "\n\e[97m" . 'Build Replace Pairs JSON file';
	echo "\n" . '-----------------------------' . "\e[39m\n";

	$replace_pairs = get_replace_pairs_csv();

	// Files to build.
	$files = array(
		array(
			'name' => 'inc/replace_pairs.json',
			'data' => $replace_pairs,
			'args' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
		),
		array(
			'name' => 'inc/replace_pairs.min.json',
			'data' => $replace_pairs,
			'args' => JSON_UNESCAPED_UNICODE,
		),
	);

	foreach ( $files as $file ) {

		$build = file_put_contents( // phpcs:ignore
			$file['name'],
			json_encode( // phpcs:ignore
				$file['data'],
				$file['args']
			)
		);

		// Check if replace pairs exist and build was successful.
		if ( ! $file['data'] || ! $build ) {
			printf(
				// Print yellow error exit.
				"\e[33m" . 'File not created: %s' . "\e[39m",
				$file['name']
			);

			echo "\n";

			exit( 1 );
		}

		printf(
			// Print bright white success exit.
			"\e[97m" . 'File created successfully: %s' . "\e[39m",
			$file['name']
		);

		echo "\n";

	}

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
 *             case_change: array<string, string>,
 *             general: array<string, string>,
 *         }
 *         Multi-dimensional array replace pairs with both types 'general' and 'case_change'. Return false if files not found.
 */
function get_replace_pairs_csv() {

	$logs = array();

	$errors = array();

	$library_files = array(
		'main'   => '../lib/languagetool/AOreplace.txt', // Import main AOreplace file.
		'add'    => '../lib/AOreplace_add.txt',          // Import AOreplace file with custom items to add.
		'remove' => '../lib/AOreplace_remove.txt',       // Import AOreplace file with custom items to exclude.
	);

	$files = array();

	foreach ( $library_files as $type => $library_file ) {

		$files[ $type ] = array();

		// Get library CSV file data.
		$file = csv_to_array( $library_file, '=', '#' );

		// Check if file exist.
		if ( false === $file ) {
			$errors[] = sprintf(
				'File not found: %s',
				$library_file
			);
			continue;
		}

		// Check if file is empty.
		if ( empty( $file ) ) {
			$logs[] = sprintf(
				'Load: %s (empty)',
				$library_file
			);
			continue;
		}

		$files[ $type ] = $file;

		// Log successful load.
		$logs[] = sprintf(
			'Load: %s',
			$library_file
		);

	}

	// Output logs.
	if ( ! empty( $logs ) ) {

		echo "\n";
		foreach ( $logs as $log ) {
			printf(
				'%s' . "\n",
				$log
			);
		}
		echo "\n";

	}

	// Output errors.
	if ( ! empty( $errors ) ) {

		echo 'Error(s):' . "\n";
		foreach ( $errors as $error ) {
			printf(
				' - %s%s%s' . "\n",
				"\e[33m",
				$error,
				"\e[39m"
			);
		}
		echo "\n";

		return false;

	}

	// Merge Main and Additional data files.
	$files_merge = array_merge( $files['main'], $files['add'] );

	// Get data to remove.
	$files_intersect = array_intersect( $files_merge, $files['remove'] );

	// Actually remove data.
	$replace_pairs = array_diff( $files_merge, $files_intersect );

	$result = array(
		'case_change' => array(), // Pairs Original (string) => Replacement (string).
		'general'     => array(), // Pairs Original (string) => Replacement (string).
	);

	foreach ( $replace_pairs as $original => $replacement ) {

		// Make sure that $key is always a string.
		$original = strval( $original );

		// Check if starts with the same letter but case has changed.
		if ( mb_strtolower( mb_substr( $original, 0, 1 ) ) === mb_strtolower( mb_substr( $replacement, 0, 1 ) ) && mb_substr( $original, 0, 1 ) !== mb_substr( $replacement, 0, 1 ) ) {

			// Add item.
			$result['case_change'][ $original ] = strval( $replacement );

		} else {

			// Add item lowercase.
			$result['general'][ $original ] = $replacement;

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
 * @return false|array<string, string>   Associative array of the file Comments and Data. Return false if file not found.
 */
function csv_to_array( $filename = '', $delimiter = ',', $comment_start = '#' ) {

	$filename = __DIR__ . DIRECTORY_SEPARATOR . $filename;

	if ( ! file_exists( $filename ) || ! is_readable( $filename ) ) {
		return false;
	}

	$file = array(
		'comments' => array(),
		'data'     => array(),
	);

	if ( false !== ( $handle = fopen( $filename, 'r' ) ) ) {

		while ( false !== ( $row = fgetcsv( $handle, 1000, $delimiter ) ) ) {

			// Check if is not an empty row.
			if ( ! isset( $row[0] ) ) {

				// Skip row.
				continue;

			} elseif ( substr( trim( $row[0] ), 0, 1 ) === $comment_start ) { // Check if row is comment.

				// Add full row to comments array.
				$file['comments'][] = implode( $delimiter, $row ); // Currently not necessary.

			} else { // Check if is not an empty row.

				// Add lowercase entry.
				$file['data'][ strval( $row[0] ) ] = strval( $row[1] );

			}
		} // End while.

		fclose( $handle );
	}

	return $file['data'];
}


/*
 * Build the replace pairs JSON file.
 */
build_replace_pairs_json();
