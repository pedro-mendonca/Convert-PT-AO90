<?php
/**
 * Convert-PT-AO90
 *
 * Portuguese language conversion tool from the 1945 Orthographic Agreement form to the 1990 Orthographic Agreement form.
 * Ferramenta de conversão de língua portuguesa da forma do Acordo Ortográfico de 1945 para a forma do Acordo Ortográfico de 1990.
 *
 * List of words altered by the 1990 Orthographic Agreement obtained from the LanguageTool project:
 * Lista de palavras alteradas pelo Acordo Ortográfico de 1990 obtida do projecto LanguageTool:
 * https://languagetool.org/
 *
 * Portuguese language modules:
 * Módulos de língua portuguesa:
 * https://github.com/languagetool-org/languagetool/tree/master/languagetool-language-modules/pt/src/main/resources/org/languagetool/rules/pt
 * https://github.com/TiagoSantos81/languagetool/tree/master/languagetool-language-modules/pt/src/main/resources/org/languagetool/rules/pt
 *
 * Source:
 * https://github.com/languagetool-org/languagetool/blob/master/languagetool-language-modules/pt/src/main/resources/org/languagetool/rules/pt/AOreplace.txt
 *
 * Instructions:
 *   $string = 'Não me pélo pelo pêlo de quem pára para resistir';
 *   $string_ao90 = Convert_PT_AO90\convert_pt_ao90( $string );
 *   echo $string_ao90;
 *
 * @package    Convert-PT-AO90
 * @link       https://github.com/pedro-mendonca/Convert-PT-AO90
 * @author     Pedro Mendonça
 * @copyright  2021 Pedro Mendonça
 * @license    GPLv3
 * @version    1.2.1
 */

namespace Convert_PT_AO90;

/**
 * Convert text string to Portuguese AO90.
 *
 * @since 1.0.0
 *
 * @param string $text   Text to convert.
 *
 * @return string|null   Text converted to Portuguese AO90. Return null if no $text, no replace_pairs or if separation of sentences or words fails.
 */
function convert_pt_ao90( $text = null ) {

	if ( null === $text ) {
		return null;
	}

	// Separate in sentences. Returns false if preg_split do not split the string.
	$sentences = get_text_sentences( $text );

	// Check if split failed.
	if ( ! $sentences ) {
		return null;
	}

	// Get Replace Pairs JSON file.
	$replace_pairs = get_replace_pairs( __DIR__ . '/inc/replace_pairs.min.json' );

	if ( ! $replace_pairs ) {
		return null;
	}

	// Walk through sentences.
	foreach ( $sentences as $sentence_key => $sentence ) {

		// Separate in words. Returns false if preg_split do not split the string.
		$words = get_sentence_words( $sentence );

		// Check if split failed.
		if ( ! $words ) {
			return null;
		}

		$word_index = 0;

		// Walk through words.
		foreach ( $words as $word_key => $word ) {

			// Check if $word is a word to convert.
			$delimiters = '/^(\w+)/u';

			if ( preg_match( $delimiters, $word ) ) {

				// Increase word count.
				$word_index++;

				// Check if is not the first word. Check for the first actual word, skips initial empty spaces.
				if ( 1 < $word_index ) {

					// Check all words after the first one for case_change replacements, because the first word should not be changed.
					if ( array_key_exists( $word, $replace_pairs['case_change'] ) ) {
						// Actual conversion of the word according the replace pairs.
						$words[ $word_key ] = $replace_pairs['case_change'][ $word ];
					}
				}

				// Check all words for general replacements.
				if ( array_key_exists( $word, $replace_pairs['general'] ) ) {
					// Actual conversion of the word according the replace pairs.
					$words[ $word_key ] = $replace_pairs['general'][ $word ];
				}
			}
		}

		// Concatenate converted words.
		$sentence = implode( $words );

		// Convert sentence.
		$sentences[ $sentence_key ] = $sentence;

	}

	// Concatenate converted sentences.
	$text_ao90 = implode( $sentences );

	return $text_ao90;
}


/**
 * Separate the sentences from a given text in an array.
 *
 * @since 1.2.0
 *
 * @param string $text   Text to separate in sentences.
 *
 * @return false|array<int, string>   Array of sentences.
 */
function get_text_sentences( $text = null ) {

	if ( null === $text ) {
		return false;
	}

	// Sentence endings used to split text into sentences.
	$endings = array(
		'.',
		'?',
		'!',
		':',
		'\n',
	);

	/**
	 * Any number of any kind of invisible character, following the sentence endings.
	 */
	$empty_space = '\s';

	// Abreviations with '.' that are not sentence endings (eg. 'Sr.', 'Dr.' ).
	$abreviations = array(
		'Sr.',
		'Dr.',
	);

	$exceptions = '';

	foreach ( $abreviations as $abreviation ) {
		$exceptions .= '(?<!' . $abreviation . '\s)';
	}

	/**
	 * Set the delimiters used to separate sentences.
	 * Ideally (?<=[.?!:\n]\s+) with \s+ to split after any number of spaces, which is currently not possible on PHP. Need to check the sentence for the first word afterwards.
	 *
	 * One of [.] or [?] or [!] or [:] or [\n] folowed by [any number of spaces], with the exception of the array of abreviations.
	 * Tested on https://regex101.com/
	 */
	$delimiters = '/(?<=[' . implode( $endings ) . ']' . $empty_space . ')' . $exceptions . '/';

	// Separate in sentences. Returns false if preg_split do not split the string.
	$sentences = preg_split( $delimiters, $text );

	// Check if split failed.
	if ( ! $sentences ) {
		return false;
	}

	// Check if split doesn't lose any character.
	if ( implode( $sentences ) !== $text ) {
		echo "An error ocurred while spliting text in sentences...\n";
		return false;
	}

	return $sentences;
}


/**
 * Separate the words from a given sentence in an array.
 *
 * @since 1.2.0
 *
 * @param string $sentence   Sentence to separate in words.
 *
 * @return false|array<int, string>   Array of words.
 */
function get_sentence_words( $sentence = null ) {

	if ( null === $sentence ) {
		return false;
	}

	/**
	 * Strip HTML because it's not safe to convert HTML tags content. Any text in it should be set on separate strings as variables.
	 * <[^>]*>                           Exclude HTML.
	 * (\b(?!\b-\b)(?<!\b-\b))           All words, keeping words with hyphens unseparated.
	 * (\b(?!\b-\b)(?<!\b-\b))|<[^>]*>   All words, keeping words with hyphens unseparated, excluding HTML.
	 */
	$delimiters = '/((\b(?!\b-\b)(?<!\b-\b))|<[^>]*>)/u';

	// Split sentence in words.
	$words = preg_split( $delimiters, $sentence, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );

	// Check if split failed.
	if ( ! $words ) {
		return false;
	}

	// Check if split doesn't lose any character.
	if ( implode( $words ) !== $sentence ) {
		echo "An error ocurred while spliting sentence in words...\n";
		return false;
	}

	return $words;
}


/**
 * Get replace pairs from JSON file.
 *
 * @since 1.1.0
 *
 * @param string $filename   Path to the JSON file.
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
