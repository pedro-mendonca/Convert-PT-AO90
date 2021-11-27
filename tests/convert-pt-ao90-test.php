<?php
/**
 * Test conversions with Convert PT AO90.
 *
 * @package Convert-PT-AO90
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
	// Palavra simples sem conversão.
	'Palavra'                                           => 'Palavra',
	// Palavra simples com conversão.
	'Acto'                                              => 'Ato',
	// Palavra simples com conversão e pontuação.
	'Acto.'                                             => 'Ato.',
	// Case change only in the words after the first one.
	'Janeiro'                                           => 'Janeiro',
	'Janeiro e Fevereiro.'                              => 'Janeiro e fevereiro.',
	'Janeiro é o mês dos gatos.'                        => 'Janeiro é o mês dos gatos.',
	'Beltrano em Maio com sicrano.'                     => 'Beltrano em maio com sicrano.',
	'Janeiro é uma altura óptima do ano para Fulano, Beltrano e Sicrano...' => 'Janeiro é uma altura ótima do ano para fulano, beltrano e sicrano...',
	// Variables count as words, second word should have case change.
	'%d Norte e Oeste.'                                 => '%d norte e oeste.',
	// Multiple sentences.
	'Uma acção. Duas acções.'                           => 'Uma ação. Duas ações.',
	// Don't convert words in HTML code. It's best for i18n to use variables to isolate translatable strings.
	'Acção :-) com <a href="https://pt.wordpress.org/" value="Acção">ligação com acção</a>.' => 'Ação :-) com <a href="https://pt.wordpress.org/" value="Acção">ligação com ação</a>.',
	// Para, pára, pêlo.
	'Não me pélo pelo pêlo de quem pára para resistir!' => 'Não me pélo pelo pelo de quem para para resistir!',
	// Pára.
	'Alto e pára o baile!'                              => 'Alto e para o baile!',
	// Contacto, tacto, intacto, compacto, impacto.
	'Contactei um contacto com tacto fica tudo intacto, compacto e deixa um grande impacto!' => 'Contactei um contacto com tato fica tudo intacto, compacto e deixa um grande impacto!',
	'Ao contactar, contactei o meu contacto, e depois deste acto e fiquei intacto.' => 'Ao contactar, contactei o meu contacto, e depois deste ato e fiquei intacto.',
	'Descompactei o pacote e que estava compactado com graça, compacto.' => 'Descompactei o pacote e que estava compactado com graça, compacto.',
	// Words with missing spaces after commas.
	'Descompactei o pacote e que estava compactado, compacto,pára activá-lo.' => 'Descompactei o pacote e que estava compactado, compacto,para ativá-lo.',
	// Conversion in the first word keeping the uppercase case.
	'Acção na primeira palavra da frase.'               => 'Ação na primeira palavra da frase.',
	'Acções na primeira palavra da frase e acções no resto da frase.' => 'Ações na primeira palavra da frase e ações no resto da frase.',
	// Redireccionar, óptimo, desactivar.
	'Redireccionar e fazer redireccionamentos.'         => 'Redirecionar e fazer redirecionamentos.',
	'Isto está a ficar com óptimo aspecto!'             => 'Isto está a ficar com ótimo aspecto!',
	'Ao desactivar, a opção fica desactivada, tem de activá-la.' => 'Ao desativar, a opção fica desativada, tem de ativá-la.',
	// Use of : and following uppercase. Also ...
	'Teste de dois pontos: Junho é quando começa o Verão! Acção na primeira palavra da frase. Encontrar uma acção em Abril. Dois espaços antes? Abril e Janeiro são meses. A.C. é antes de cristo. Nunca mais chega o Verão?! Espero que não demore... Fim' => 'Teste de dois pontos: Junho é quando começa o verão! Ação na primeira palavra da frase. Encontrar uma ação em abril. Dois espaços antes? Abril e janeiro são meses. A.C. é antes de cristo. Nunca mais chega o verão?! Espero que não demore... Fim',
	// Multiline texts with line breaks and assuming first letter uppercase after two linebreaks.
	'Este aviso confirma que
o seu endereço de email em ###SITENAME### foi alterado para ###NEW_EMAIL###.' => 'Este aviso confirma que
o seu endereço de email em ###SITENAME### foi alterado para ###NEW_EMAIL###.',
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
	// Words with hyphens.
	'Um co-director ultra-radical.'                     => 'Um codiretor ultrarradical.',
	// Multiple sentences, with more than one space in between, case changes, sentences starting with numbers, starting with other letters than [A-Z] (example: Ú).
	'Quatro acções.   A segunda inclui uma <a href="#" value="Acção">Acção com maiúscula</a>.  Sr. Beltrano e Sr.ª Sicrano n.º 4. Frase n.º 4. 3 colunas. Última frase.' => 'Quatro ações.   A segunda inclui uma <a href="#" value="Acção">Ação com maiúscula</a>.  Sr. beltrano e Sr.ª sicrano n.º 4. Frase n.º 4. 3 colunas. Última frase.',
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
convert_pt_ao90_test( $convert_pt_ao90_texts );
