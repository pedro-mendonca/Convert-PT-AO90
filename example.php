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
 * Sentences examples to test the conversion in convert_diff_table().
 */
$convert_pt_ao90_texts = array(
	'Palavra',
	'Janeiro e Fevereiro.',
	'Acção :-) com <a href="https://pt.wordpress.org/">ligação</a>.',
	'Não me pélo pelo pêlo de quem pára para resistir!',
	'Alto e pára o baile!',
	'Janeiro é uma altura óptima do ano para Fulano, Beltrano e Sicrano...',
	'Acção na primeira palavra da frase.',
	'Acções na primeira palavra da frase e acções no resto da frase.',
	'Redireccionar e fazer redireccionamentos.',
	'Isto está a ficar com óptimo aspecto!',
	'A opção está desactivada, tem de activá-la.',
	'Teste de dois pontos: Junho é quando começa o Verão! Acção na primeira palavra da frase. Encontrar uma acção em Abril.  Dois espaços antes? Abril e Janeiro são meses. A.C. é antes de cristo. Nunca mais chega o Verão?! Espero que não demore... Fim',
	'Olá ###USERNAME###,

Este aviso confirma que o seu endereço de email em ###SITENAME### foi alterado para ###NEW_EMAIL###.




Se não alterou o seu email, por favor contacte o administrador do site através de
###ADMIN_EMAIL###

Este email foi enviado para ###EMAIL###

Atenciosamente,
A equipa ###SITENAME###
###SITEURL###',
	'Descompactei o pacote e que estava compactado, compacto.',
	'Ao contactar, contactei o meu contacto, e depois deste acto e fiquei intacto.',
);


/**
 * Show comparative table with 2 columns:
 *  - Forma do Acordo Ortográfico de 1945
 *  - Palavras alteradas pelo Acordo Ortográfico de 1990
 *
 * @since 1.0.0
 *
 * @param array<int,string> $texts   Array of texts do convert to Portuguese AO90.
 *
 * @return void
 */
function convert_pt_ao90_diff_table( $texts = null ) {

	if ( null === $texts ) {
		return;
	}

	?>
	<style>
	td.left {
		background-color: rgba(255,0,0,.1);
	}
	td.right {
		background-color: rgba(0,255,0,.1);
	}
	</style>
	<table>
		<tr>
			<th>Português pré-AO90</th>
			<th>Português pós-AO90</th>
		</tr>
		<?php
		foreach ( $texts as $text ) {
			?>
			<tr>
				<td class="left"><?php echo $text; ?></td>
				<td class="right"><?php echo Convert_PT_AO90\convert_pt_ao90( $text ); ?></td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
}
convert_pt_ao90_diff_table( $convert_pt_ao90_texts );


/**
 * Show all the conversion replace pairs by type.
 *
 * @since 1.0.0
 *
 * @return void
 */
function convert_pt_ao90_table_replace_pairs() {

	$replace_pairs = Convert_PT_AO90\get_replace_pairs();

	if ( ! $replace_pairs ) {
		return;
	}

	?>
	<h2>Tabela de conversão de português AO90</h2>
	<h3>Geral (<?php echo count( $replace_pairs['general']['original'] ); ?>)</h3>
	<div>
		<pre>
			<?php
			echo print_r( $replace_pairs['general'], true );
			?>
		</pre>

	</div>
	<h3>Alteração de maiúsculas (<?php echo count( $replace_pairs['case_change']['original'] ); ?>)</h3>
	<div>
		<pre>
			<?php
			echo print_r( $replace_pairs['case_change'], true );
			?>
		</pre>
	</div>
	<?php
}
convert_pt_ao90_table_replace_pairs();
