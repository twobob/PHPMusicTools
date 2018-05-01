<?php

require_once('Visualization.php');


/**
 * renders a guitar chord diagram
 * @param  [type] $notes [description]
 * @return [type]        [description]
 */
class GuitarFretboardScale extends Visualization {

	public function __construct($scale) {
		$this->scale = $scale;
	}

	function getDiagram() {
		return array();
	}

	function render() {

	    $stroke = 'black';
	    $fill = 'white';
	    $strokeWidth = '4pt';
	    $fretCount = 24;

		$output  = '
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg width="1400" height="240" viewBox="0 0 2800 300" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve">
    <g id="Layer1">';

    $parts = array(
    	'string1' => '<path d="M90,30 L1970,30" style1 />',
    	'string2' => '<path d="M90,80 L1970,80" style1 />',
    	'string3' => '<path d="M90,130 L1970,130" style1 />',
    	'string4' => '<path d="M90,180 L1970,180" style1 />',
    	'string5' => '<path d="M90,230 L1970,230" style1 />',
    	'string6' => '<path d="M90,280 L1970,280" style1 />',
    );

    for($i=0;$i<$fretCount;$i++) {
    	$parts['fret'.$i] = '<path d="M'.(($i * 80) + 90).',30 L'.(($i * 80) + 90).',280" style1 />';
    }


    // strings, expressed as semitones above middle C, starting from the lowest
    $strings = array(
    	new \ianring\Pitch('E', 0, 6),
    	new \ianring\Pitch('B', 0, 5),
    	new \ianring\Pitch('G', 0, 5),
    	new \ianring\Pitch('D', 0, 5),
    	new \ianring\Pitch('A', 0, 4),
    	new \ianring\Pitch('E', 0, 4),
    );

    for($i=1;$i<$fretCount;$i++) {
    	$parts[] = '<text style="font-family:verdana;font-weight:bold;font-style:italic;font-size:25px;" text-anchor="middle" x="'.((80 * $i) + 50).'" y="330" fill="black">'.$i.'</text>';
    }

    foreach($strings as $index=>$string) {
    	$tone = $strings[$index];
    	for($i=0;$i<$fretCount;$i++){

    		if ($this->scale->containsPitch($tone)) {
	    		$parts[] = '<circle cx="'.((80 * $i) + 50).'" cy="'.((50 * $index) + 30).'" r="23" style="fill:black;"/>';
	    		$parts[] = '<text style="font-family:verdana;font-weight:bold;font-style:italic;font-size:25px;" text-anchor="middle" x="'.((80 * $i) + 50).'" y="'.((50 * $index)+39).'" fill="white">'.$tone->step . ($tone->alter == -1 ? 'b' : '') .'</text>';
    		}
    		$tone->transpose(1, -1);    		
    	}
    }


    // foreach($diagram['strings'] as $i => $string) {
    // 	if ($string['fret'] == 'open' || $string['fret'] === 0) {
	   //  	$parts[] = '<circle cx="'.((50*$i)+31).'" cy="28" r="10" style1 />';
    // 	} else if ($string['fret'] == 'closed') {
	   //  	$parts[] = '<path d="M' . ((50 * $i)+20) . ',20 L'.((50 * $i)+40).',40 	M'.((50 * $i)+40).',20 L'.((50 * $i)+20).',40" style1 />';
    // 	} else if (is_numeric($string['fret'])) {
    // 		$parts[] = '<circle cx="'.((50 * $i)+30).'" cy="'.((40 * $string['fret'])+40).'" r="15" style="fill:black;"/>';
    // 		if (!empty($string['finger'])) {
    // 			// draw the number here
    // 			$parts[] = '<text style="font-family:verdana;font-weight:bold;font-style:italic;font-size:25px;" text-anchor="middle" x="'.((50 * $i)+30).'" y="'.((40 * $string['fret'])+48).'" fill="white">'.$string['finger'].'</text>';
    // 		}
    // 	}
    // }

	foreach($parts as $part => $svg) {
	    $style = 'style="fill:'.$fill.';stroke:'.$stroke.';stroke-width:'.$strokeWidth.';"';
		$svg = str_replace('style1', $style, $svg);
		$output .= $svg;
	}

 $output .= '       
    </g>
</svg>';

		return $output;


	}
}