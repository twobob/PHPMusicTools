<?php
namespace ianring;

require_once 'Score.php';

class MusicXMLParser {

	public static function parse($xml) {
		$x = new \SimpleXMLElement($xml);

		$score = \ianring\Score::parseFromXmlObject($x);

		echo '<pre>';
		print_r($score);
		return $score;
	}

}