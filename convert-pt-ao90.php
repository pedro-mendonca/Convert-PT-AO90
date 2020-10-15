<?php
/**
 * Convert-PT-AO90
 *
 * Ferramenta de conversão de língua portuguesa da forma do Acordo Ortográfico de 1945 para a forma do Acordo Ortográfico de 1990.
 *
 * Lista de palavras alteradas pelo Acordo Ortográfico de 1990 obtida do projecto LanguageTool:
 * https://languagetool.org/
 *
 * Módulos de língua portuguesa:
 * https://github.com/languagetool-org/languagetool/tree/master/languagetool-language-modules/pt/src/main/resources/org/languagetool/rules/pt
 * https://github.com/TiagoSantos81/languagetool/tree/master/languagetool-language-modules/pt/src/main/resources/org/languagetool/rules/pt
 *
 * Instructions:
 *   $string = 'Não me pélo pelo pêlo de quem pára para resistir';
 *   $string_ao90 = Convert_PT_AO90\convert_pt_ao90( $string );
 *   echo $string_ao90;
 *
 * @package    Convert-PT-AO90
 * @link       https://github.com/pedro-mendonca/Convert-PT-AO90
 * @author     Pedro Mendonça
 * @copyright  2020 Pedro Mendonça
 * @license    GPLv3
 * @version    1.0
 */

namespace Convert_PT_AO90;

/**
 * Convert text string to Portuguese AO90.
 *
 * @since 1.0.0
 *
 * @param string $text   Text to convert.
 *
 * @return string|false   Text converted to Portuguese AO90. Return false if no $text or no replace_pairs.
 */
function convert_pt_ao90( $text = null ) {

	if ( null === $text ) {
		return false;
	}

	$replace_pairs = get_replace_pairs();

	if ( ! $replace_pairs ) {
		return false;
	}

	/**
	 * Convert words that changed from uppercase to lowercase, except the first word on each sentence.
	 */
	// Set the delimiters used to separate sentences.
	$delimiters = '/([.?!:])\s+\b/';

	// Separate in sentences. Returns false if preg_split do not split the string.
	$sentences = preg_split( $delimiters, $text, -1, PREG_SPLIT_OFFSET_CAPTURE );

	// Check if split failed.
	if ( false === $sentences ) {
		return false;
	}

	// Loop sentences in reverse order to allow the position to work.
	foreach ( array_reverse( $sentences ) as $key => $sentence ) {

		// Separate sentece by words.
		$words = explode( ' ', trim( $sentence[0] ) );

		// Check if the sentence has more than one word.
		if ( 1 === count( $words ) ) {
			continue;
		}

		// Sentence ending.
		$sentence_ending_pos = intval( $sentence[1] ) + strlen( $words[0] . ' ' );
		$sentence_ending_len = strlen( $sentence[0] ) - strlen( $words[0] . ' ' );
		$sentence_ending     = substr( $sentence[0], strlen( $words[0] . ' ' ) );

		// Convert case changing words from sentence ending.
		$sentence_ending_ao90_lowercase = str_replace( $replace_pairs['case_change']['original'], $replace_pairs['case_change']['replacement'], $sentence_ending );

		// Convert sentence ending.
		$text = substr_replace( $text, $sentence_ending_ao90_lowercase, $sentence_ending_pos, $sentence_ending_len );

	}

	/**
	 * Convert all general replace_pairs.
	 */
	$text_ao90 = str_replace( $replace_pairs['general']['original'], $replace_pairs['general']['replacement'], $text );

	return $text_ao90;
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
 * @return array<string|int,mixed>|false   Multi-dimensional array replace pairs with both types 'general' and 'case-change'. Return false ir files not found.
 */
function get_replace_pairs() {

	// Import main AOreplace file.
	$file_main = csv_to_array(
		'lib/languagetool/AOreplace.txt',
		'=',  // Delimiter.
		'#'   // Row comment character.
	);

	// Import AOreplace file with aditional custom items.
	$file_additional = csv_to_array(
		'inc/AOreplace_add.txt',
		'=',  // Delimiter.
		'#'   // Row comment character.
	);

	// Import AOreplace file with items to exclude.
	$file_remove = csv_to_array(
		'inc/AOreplace_remove.txt',
		'=',  // Delimiter.
		'#'   // Row comment character.
	);

	if ( ! $file_main || ! $file_additional || ! $file_remove ) {
		return false;
	}

	$files = array_merge( $file_main['data'], $file_additional['data'] );

	$intersect = array_intersect( $files, $file_remove['data'] );

	$replace_pairs = array_diff( $files, $intersect );

	foreach ( $replace_pairs as $key => $replace_pair ) {

		// Make sure that $key is always a string.
		$key = strval( $key );

		// Check if starts with the same letter but case has changed.
		if ( strtolower( substr( $key, 0, 1 ) ) === strtolower( substr( $replace_pair, 0, 1 ) ) && substr( $key, 0, 1 ) !== substr( $replace_pair, 0, 1 ) ) {

			// Add item.
			$replace_pairs['case_change']['original'][]    = $key;
			$replace_pairs['case_change']['replacement'][] = $replace_pair;

		} else {

			// Add item.
			$replace_pairs['general']['original'][]    = $key;
			$replace_pairs['general']['replacement'][] = $replace_pair;

			// Duplicate Uppercase item, for sentences first words.
			$replace_pairs['general']['original'][]    = ucfirst( $key );
			$replace_pairs['general']['replacement'][] = ucfirst( $replace_pair );

		}

		// Remove from main array.
		unset( $replace_pairs[ $key ] );

	}

	return $replace_pairs;

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
 * @return array<string,array>|false   Associative array of the file Comments and Data. Return false if file not found.
 */
function csv_to_array( $filename = '', $delimiter = ',', $comment_start = '#' ) {

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
				$file_data['data'][ $row[0] ] = $row[1];

			}
		} // End while.

		fclose( $handle );
	}

	return $file_data;
}
