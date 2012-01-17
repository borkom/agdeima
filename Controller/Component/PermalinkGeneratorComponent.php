<?php
// a simple CakePHP component that converts strings to SEO friendly format for permalinks
class PermalinkGeneratorComponent extends Component {
	function toAscii($str) {
		setlocale(LC_ALL, 'en_US.UTF8');
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_| -]+/", '-', $clean);

		return $clean;
	}

}
?>