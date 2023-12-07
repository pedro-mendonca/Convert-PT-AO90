<?php
/**
 * Test conversions with Convert PT AO90.
 *
 * @package Convert_PT_AO90
 */

namespace Convert_PT_AO90;

/**
 * Require Convert PT AO90.
 */
require_once 'convert-pt-ao90.php';

/**
 * Require test cases.
 */
require_once 'test-cases.php';


/**
 * Runs conversion tests for given array of text strings.
 *
 * @since 1.1.0
 *
 * @param array<int|string, string|null> $tests   Array of texts to test the conversion.
 *
 * @return void
 */
function convert_pt_ao90_test( $tests = array() ) {

	// Bright white header.
	echo "\n\e[97m" . 'Convert tests with Convert PT AO90';
	echo "\n" . '----------------------------------' . "\e[39m\n";

	/**
	 *Banner created with https://manytools.org/hacker-tools/ascii-banner/
	 */
	echo "\e[32m" . '  ___ _____     ' . "\e[33m" . '_   ___  ' . "\e[31m" . '___  __' . "\n";
	echo "\e[32m" . ' | _ \_   _|   ' . "\e[33m" . '/_\ / _ \\' . "\e[31m" . '/ _ \/  \\' . "\n";
	echo "\e[32m" . ' |  _/ | |    ' . "\e[33m" . '/ _ \ (_) ' . "\e[31m" . '\_, / () |' . "\n";
	echo "\e[32m" . ' |_|   |_|   ' . "\e[33m" . '/_/ \_\___/ ' . "\e[31m" . '/_/ \__/' . "\e[39m\n\n\n";

	if ( empty( $tests ) ) {
		echo 'No strings found to test.';
		exit( 0 );
	} else {
		printf(
			'Found %s text strings to test.',
			count( $tests )
		);
	}

	echo "\n\n";

	echo 'Testing:' . "\n";

	$errors = array();

	foreach ( $tests as $original => $expected ) {

		// Convert text.
		$test = convert_pt_ao90( $original );

		if ( $expected !== $test ) {
			// Print yellow 'E' (Error).
			echo "\e[33m" . 'E' . "\e[39m";
			$errors[] = array(
				'expected' => $expected,
				'test'     => $test,
			);
			continue;
		}

		// Print green '.' (Item).
		echo "\e[32m" . '.' . "\e[39m";

	}

	printf(
		' (%s of %s passed)',
		count( $tests ) - count( $errors ),
		count( $tests )
	);

	echo "\n\n\n";

	if ( ! empty( $errors ) ) {

		echo 'Conversion error(s):' . "\n";

		foreach ( $errors as $error ) {
			echo "\n";
			printf(
				' - %s%s%s' . "\n",
				"\e[33m",
				'"' . $error['expected'] . '"',
				"\e[39m"
			);
			printf(
				' + %s%s%s' . "\n",
				"\e[31m",
				is_null( $error['test'] ) ? 'NULL' : '"' . $error['test'] . '"',
				"\e[39m"
			);
		}

		echo "\n\n";

	}

	if ( empty( $errors ) ) {
		// Green bright white result message.
		$result = "\e[97m" . 'All tests passed successfuly!' . "\e[39m";
	} else {
		// Color yellow result message.
		$result = "\e[33m" . sprintf( 'Tests finished with %d error(s).', count( $errors ) ) . "\e[39m";
	}

	echo $result . "\n\n";

	exit( count( $errors ) );
}


// Test the conversion.
convert_pt_ao90_test( convert_pt_ao90_test_cases() );
