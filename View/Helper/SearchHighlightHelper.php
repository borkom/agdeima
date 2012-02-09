<?php
App::uses('AppHelper', 'View/Helper');
//custom search highlighting helper
class SearchHighlightHelper extends AppHelper {
		
	function highlightWords($string, $word)
	{
   		
       	$string = str_ireplace($word, '<span class="highlight_word">'.$word.'</span>', $string);
   		
   		/*** return the highlighted string ***/
   		return $string;
		}
	}
?>