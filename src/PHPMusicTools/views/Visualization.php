<?php
namespace ianring;

require_once(__DIR__ . '/../classes/Pitch.php');

require_once('UkeleleChord.php');

class Visualization {


	/**
	 * converts an array of declarations into a CSS fragment.
	 * @param  [type] $array [description]
	 * @return [type]        [description]
	 */
	public function array2CSS($array) {
		$css = '';
		foreach($array as $k=>$v) {
			$css .= $k . ':' . $v . ';';
		}
		return $css;
	}
	
}