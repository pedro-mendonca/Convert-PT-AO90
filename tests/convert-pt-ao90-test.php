<?php
/**
 * Convert-PT-AO90
 *
 * Conversion tests.
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
 * Require Convert-PT-AO90.
 */
require_once 'convert-pt-ao90.php';


/**
 * Sentences examples and its expected conversion.
 */
$convert_pt_ao90_texts = array(
	'Palavra'                                           => 'Palavra',
	'Janeiro e Fevereiro.'                              => 'Janeiro e fevereiro.',
	'Acção :-) com <a href="https://pt.wordpress.org/">ligação</a>.' => 'Ação :-) com <a href="https://pt.wordpress.org/">ligação</a>.',
	'Não me pélo pelo pêlo de quem pára para resistir!' => 'Não me pélo pelo pelo de quem para para resistir!',
	'Alto e pára o baile!'                              => 'Alto e para o baile!',
	'Janeiro é uma altura óptima do ano para Fulano, Beltrano e Sicrano...' => 'Janeiro é uma altura ótima do ano para fulano, beltrano e sicrano...',
	'Acção na primeira palavra da frase.'               => 'Ação na primeira palavra da frase.',
	'Acções na primeira palavra da frase e acções no resto da frase.' => 'Ações na primeira palavra da frase e ações no resto da frase.',
	'Redireccionar e fazer redireccionamentos.'         => 'Redirecionar e fazer redirecionamentos.',
	'Isto está a ficar com óptimo aspecto!'             => 'Isto está a ficar com ótimo aspecto!',
	'A opção está desactivada, tem de activá-la.'       => 'A opção está desativada, tem de ativá-la.',
	'Teste de dois pontos: Junho é quando começa o Verão! Acção na primeira palavra da frase. Encontrar uma acção em Abril. Dois espaços antes? Abril e Janeiro são meses. A.C. é antes de cristo. Nunca mais chega o Verão?! Espero que não demore... Fim' => 'Teste de dois pontos: Junho é quando começa o verão! Ação na primeira palavra da frase. Encontrar uma ação em abril. Dois espaços antes? Abril e janeiro são meses. A.C. é antes de cristo. Nunca mais chega o verão?! Espero que não demore... Fim',
	'Olá ###USERNAME###,

Este aviso confirma que o seu endereço de email em ###SITENAME### foi alterado para ###NEW_EMAIL###.




Se não alterou o seu email, por favor contacte o administrador do site através de
###ADMIN_EMAIL###

Este email foi enviado para ###EMAIL###

Atenciosamente,
A equipa ###SITENAME###
###SITEURL###'                                          => 'Olá ###USERNAME###,

Este aviso confirma que o seu endereço de email em ###SITENAME### foi alterado para ###NEW_EMAIL###.




Se não alterou o seu email, por favor contacte o administrador do site através de
###ADMIN_EMAIL###

Este email foi enviado para ###EMAIL###

Atenciosamente,
A equipa ###SITENAME###
###SITEURL###',
	'Descompactei o pacote e que estava compactado, compacto.' => 'Descompactei o pacote e que estava compactado, compacto.',
	'Ao contactar, contactei o meu contacto, e depois deste acto e fiquei intacto.' => 'Ao contactar, contactei o meu contacto, e depois deste ato e fiquei intacto.',
);


/**
 * Runs conversion tests for given array of text strings.
 *
 * @since 1.1.0
 *
 * @param array<string, string> $tests   Array of texts to test the conversion.
 *
 * @return void
 */
function convert_pt_ao90_test( $tests = array() ) {

	/**
	 *Banner created with https://manytools.org/hacker-tools/ascii-banner/
	 */
	echo "\e[32m" . ' ___ _____     ' . "\e[33m" . '_   ___  ' . "\e[31m" . '___  __' . "\n";
	echo "\e[32m" . '| _ \_   _|   ' . "\e[33m" . '/_\ / _ \\' . "\e[31m" . '/ _ \/  \\' . "\n";
	echo "\e[32m" . '|  _/ | |    ' . "\e[33m" . '/ _ \ (_) ' . "\e[31m" . '\_, / () |' . "\n";
	echo "\e[32m" . '|_|   |_|   ' . "\e[33m" . '/_/ \_\___/ ' . "\e[31m" . '/_/ \__/' . "\e[39m\n\n\n";

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

	echo 'Testing: ';

	$errors = array();

	foreach ( $tests as $original => $expected ) {

		// Convert text.
		$test = convert_pt_ao90( $original );

		if ( $expected !== $test ) {
			// Print yellow 'E' (Error).
			echo "\e[33m" . 'E' . "\e[39m";
			$errors[] = $test;
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
			printf(
				' - %s%s%s' . "\n",
				"\e[33m",
				$error,
				"\e[39m"
			);
		}

		echo "\n\n";

	}

	if ( empty( $errors ) ) {
		// Green red result message.
		$result = "\e[32m" . 'All tests passed successfuly!' . "\e[39m";
	} else {
		// Color red result message.
		$result = "\e[31m" . sprintf( 'Tests finished with %d error(s).', count( $errors ) ) . "\e[39m";
	}

	echo $result . "\n\n";

	exit( count( $errors ) );

}


// Test the conversion.
convert_pt_ao90_test( $convert_pt_ao90_texts );
