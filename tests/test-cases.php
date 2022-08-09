<?php
/**
 * Test conversions with Convert PT AO90.
 *
 * @package Convert_PT_AO90
 */

namespace Convert_PT_AO90;

/**
 * Sentences examples and its expected conversion on Portuguese AO90.
 *
 * @since 1.2.4
 *
 * @return array<string, string>   Array of text strings to test the conversion.
 */
function convert_pt_ao90_test_cases() {

	/**
	 * Sentences examples and its expected conversion.
	 */
	$convert_pt_ao90_test_cases = array(
		// Palavra simples sem conversão.
		'Palavra'                                   => 'Palavra',
		// Palavra simples com conversão.
		'Acto'                                      => 'Ato',
		// Palavra simples com conversão e pontuação.
		'Acto.'                                     => 'Ato.',
		// Case change only in the words after the first one.
		'Janeiro'                                   => 'Janeiro',
		'Janeiro e Fevereiro.'                      => 'Janeiro e fevereiro.',
		'Beltrano em Maio com sicrano.'             => 'Beltrano em maio com sicrano.',
		'Janeiro é uma altura óptima do ano para Fulano, Beltrano e Sicrano...' => 'Janeiro é uma altura ótima do ano para fulano, beltrano e sicrano...',
		// Variables count as words, second word should have case change.
		'Beltranos e Sicranos.'                     => 'Beltranos e sicranos.',
		'%d Beltranos e Sicranos.'                  => '%d beltranos e sicranos.',
		// Multiple sentences.
		'Uma acção. Duas acções.'                   => 'Uma ação. Duas ações.',
		// Don't convert words in HTML code. It's best for i18n to use variables to isolate translatable strings.
		'Acção :-) com <a href="https://pt.wordpress.org/" value="Acção">ligação com acção</a>.' => 'Ação :-) com <a href="https://pt.wordpress.org/" value="Acção">ligação com ação</a>.',
		// Para, pára, pêlo.
		'Não me pélo pelo pêlo de quem pára para resistir!' => 'Não me pélo pelo pelo de quem para para resistir!',
		// Pára.
		'Alto e pára o baile!'                      => 'Alto e para o baile!',
		// Contacto, tacto, intacto, compacto, impacto.
		'Contactei um contacto com tacto fica tudo intacto, compacto e deixa um grande impacto!' => 'Contactei um contacto com tato fica tudo intacto, compacto e deixa um grande impacto!',
		'Ao contactar, contactei o meu contacto depois deste acto.' => 'Ao contactar, contactei o meu contacto depois deste ato.',
		// Words with missing spaces after commas.
		'Descompactei o pacote que estava compactado, compacto,pára de activá-lo!' => 'Descompactei o pacote que estava compactado, compacto,para de ativá-lo!',
		// Conversion in the first word keeping the uppercase case.
		'Acção na primeira palavra da frase.'       => 'Ação na primeira palavra da frase.',
		'Acções na primeira palavra da frase e acções no resto da frase.' => 'Ações na primeira palavra da frase e ações no resto da frase.',
		// Redireccionar, óptimo, desactivar.
		'Redireccionar e fazer redireccionamentos.' => 'Redirecionar e fazer redirecionamentos.',
		// Aspecto (optional - dupla grafia).
		'Isto está a ficar com óptimo aspecto!'     => 'Isto está a ficar com ótimo aspecto!',
		'Ao desactivar, a opção fica desactivada, tem de activá-la.' => 'Ao desativar, a opção fica desativada, tem de ativá-la.',
		// Use of : and following uppercase. Also ...
		'Teste de dois pontos: Junho é quando começa o Verão! Acção na primeira palavra da frase. Encontrar uma acção em Abril. Dois espaços antes? Abril e Janeiro são meses. A.C. é antes de cristo. Nunca mais chega o Verão?! Espero que não demore... Fim' => 'Teste de dois pontos: Junho é quando começa o verão! Ação na primeira palavra da frase. Encontrar uma ação em abril. Dois espaços antes? Abril e janeiro são meses. A.C. é antes de cristo. Nunca mais chega o verão?! Espero que não demore... Fim',
		// Multiline texts with line breaks and assuming first letter uppercase after two linebreaks.
		'Este aviso confirma que
o seu endereço de email em ###SITENAME### foi alterado para ###NEW_EMAIL###.' => 'Este aviso confirma que
o seu endereço de email em ###SITENAME### foi alterado para ###NEW_EMAIL###.',
		'Este aviso confirma que
Beltrano e Sicrano subscreveram.'                   => 'Este aviso confirma que
beltrano e sicrano subscreveram.',
		'Este aviso confirma que
 Beltrano e Sicrano subscreveram.'                  => 'Este aviso confirma que
 beltrano e sicrano subscreveram.',
		'Olá ###USERNAME###,

Este aviso confirma que o seu endereço de email em ###SITENAME### foi alterado para ###NEW_EMAIL###.




Se não alterou o seu email, por favor contacte o administrador do site através de
###ADMIN_EMAIL###

Este email foi enviado para ###EMAIL###

Atenciosamente,
A equipa ###SITENAME###
###SITEURL###'                                      => 'Olá ###USERNAME###,

Este aviso confirma que o seu endereço de email em ###SITENAME### foi alterado para ###NEW_EMAIL###.




Se não alterou o seu email, por favor contacte o administrador do site através de
###ADMIN_EMAIL###

Este email foi enviado para ###EMAIL###

Atenciosamente,
A equipa ###SITENAME###
###SITEURL###',
		// Words with hyphens.
		'Um co-director ultra-radical.'             => 'Um codiretor ultrarradical.',
		// Multiple sentences, with more than one space in between, case changes, sentences starting with numbers, starting with other letters than [A-Z] (example: Ú).
		'Quatro acções.   A segunda inclui uma <a href="#" value="Acção">Acção com maiúscula</a>.  Sr. Beltrano e Sr.ª Sicrano n.º 4. Frase n.º 4. 3 colunas. Última frase.' => 'Quatro ações.   A segunda inclui uma <a href="#" value="Acção">Ação com maiúscula</a>.  Sr. beltrano e Sr.ª sicrano n.º 4. Frase n.º 4. 3 colunas. Última frase.',
		// Sentence ending with HTML afterwards.
		'<strong>Erro:</strong> Beltrano é a primeira palavra a seguir a um fim de frase com HTML, mas Sicrano não.' => '<strong>Erro:</strong> Beltrano é a primeira palavra a seguir a um fim de frase com HTML, mas sicrano não.',
		// Cardinal points shouldn't be converted, are lowercase since 1945.
		'Eu sou da Geórgia do Sul. Lisboa fica na margem norte do Tejo. Vou para o Norte!' => 'Eu sou da Geórgia do Sul. Lisboa fica na margem norte do Tejo. Vou para o Norte!',
	);

	return $convert_pt_ao90_test_cases;

}
