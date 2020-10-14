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

/**
 * Require Convert-PT-AO90.
 */
require_once 'convert-pt-ao90.php';


/**
 * Show table with example of sentences to test the conversion.
 *
 * @since 1.0.0
 *
 * @return void
 */
function convert_sentences() {

	$texts = array(
		'Não me pélo pelo pêlo de quem pára para resistir!',
		'Alto e pára o baile!',
		'Janeiro é uma altura óptima do ano para Fulano, Beltrano e Sicrano...',
		'Acção na primeira palavra da frase.',
		'Acções na primeira palavra da frase e acções no resto da frase.',
		'Teste de dois pontos: Junho é quando começa o Verão! Acção na primeira palavra da frase. Encontrar uma acção em Abril.  Dois espaços antes? Abril e Janeiro são meses. A.C. é antes de cristo. Nunca mais chega o Verão?! Espero que não demore... Fim',
	);

	Convert_PT_AO90\convert_diff_table( $texts );
}
convert_sentences();


/**
 * Show all the conversion replace pairs by type.
 *
 * @since 1.0.0
 *
 * @return void
 */
Convert_PT_AO90\conversion_table_replace_pairs();
