<?php
/**
 * Convert-PT-AO90
 *
 * Ferramenta de conversão de língua portuguesa da forma do Acordo Ortográfico de 1945 para a forma do Acordo Ortográfico de 1990.
 * Portuguese language conversion tool from the 1945 Orthographic Agreement form to the 1990 Orthographic Agreement form.
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
 * @version    1.0.2
 */

namespace Convert_PT_AO90;

/**
 * Convert text string to Portuguese AO90.
 *
 * @since 1.0.0
 *
 * @param string $text   Text to convert.
 *
 * @return string|null   Text converted to Portuguese AO90. Return null if no $text or no replace_pairs.
 */
function convert_pt_ao90( $text = null ) {

	if ( null === $text ) {
		return null;
	}

	// Get Replace Pairs JSON file.
	$replace_pairs = get_replace_pairs( 'inc/replace_pairs.min.json' );

	if ( ! $replace_pairs ) {
		return null;
	}

	/**
	 * Convert words that changed from uppercase to lowercase, except the first word on each sentence.
	 */
	// Set the delimiters used to separate sentences.
	$delimiters = '/([.?!:\n(<(.|\n)*?>)])\s+\b/';

	// Separate in sentences. Returns false if preg_split do not split the string.
	$sentences = preg_split( $delimiters, $text, -1, PREG_SPLIT_OFFSET_CAPTURE );

	// Check if split failed.
	if ( ! $sentences ) {
		return null;
	}

	// Loop sentences in reverse order to allow the position to work.
	foreach ( array_reverse( $sentences ) as $sentence ) {

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
		$sentence_ending_ao90 = str_replace( array_keys( $replace_pairs['case_change'] ), $replace_pairs['case_change'], $sentence_ending );

		// Convert sentence ending.
		$text = substr_replace( $text, $sentence_ending_ao90, $sentence_ending_pos, $sentence_ending_len );

	}

	/**
	 * Convert all general replace_pairs.
	 */
	$text_ao90 = str_replace( array_keys( $replace_pairs['general'] ), $replace_pairs['general'], $text );

	return $text_ao90;
}


/**
 * Get replace pairs from JSON file.
 *
 * @since 1.1.0
 *
 * @param string $filename  Path to the JSON file.
 *
 * @return false|array{
 *             case_change: array<string, string>,
 *             general: array<string, string>,
 *         }
 *         Multi-dimensional array replace pairs with both types 'general' and 'case_change'. Return false if files not found.
 */
function get_replace_pairs( $filename = '' ) {

	// Check for given file name.
	if ( ! $filename ) {
		return false;
	}

	// Check if JSON file exist.
	if ( ! file_exists( $filename ) || ! is_readable( $filename ) ) {
		return false;
	}

	// Check JSON data.
	$json = file_get_contents( $filename ); // phpcs:ignore
	if ( ! $json ) {
		return false;
	}

	$replace_pairs = json_decode( $json, true );

	if ( ! is_array( $replace_pairs ) ) {
		return false;
	}

	if ( ! isset( $replace_pairs['case_change'] ) || ! is_array( $replace_pairs['case_change'] ) ) {
		return false;
	}

	if ( ! isset( $replace_pairs['general'] ) || ! is_array( $replace_pairs['general'] ) ) {
		return false;
	}

	$result = array(
		'case_change' => $replace_pairs['case_change'],
		'general'     => $replace_pairs['general'],
	);

	return $result;
}
