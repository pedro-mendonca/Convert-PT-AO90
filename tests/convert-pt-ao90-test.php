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

if ( empty( $convert_pt_ao90_texts ) ) {
	echo 'No strings found to test.' . "\n";
	exit( 0 );
}

echo 'Start text conversion tests.' . "\n";
echo '============================' . "\n\n";

foreach ( $convert_pt_ao90_texts as $convert_pt_ao90_original => $convert_pt_ao90_expected ) {

	// Convert text.
	$convert_pt_ao90_test = convert_pt_ao90( $convert_pt_ao90_original );

	if ( $convert_pt_ao90_expected === $convert_pt_ao90_test ) {
		echo 'Passed.' . "\n";
		continue;
	}

	echo 'Failed:' . "\n";
	echo $convert_pt_ao90_test . "\n";

	exit( 1 );
}

echo "\n";
echo '====================================' . "\n";
echo 'Conversion tests ended with success!' . "\n";

exit( 0 );
