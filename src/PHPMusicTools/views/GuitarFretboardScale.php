<?php
namespace ianring;

require_once('Visualization.php');


/**
 * renders a guitar chord diagram
 * @param  [type] $notes [description]
 * @return [type]        [description]
 */
class GuitarFretboardScale extends Visualization {

	public function __construct($scale, $args = array()) {
		$this->scale = $scale;

		$this->args = array_merge(
			array(
				'style' => '',
				'frets' => 24,
				'accidental' => -1
			),
			$args
		);
	}

	function getDiagram() {
		return array();
	}

	function render() {

	    $stroke = 'black';
	    $fill = 'white';
	    $strokeWidth = '4pt';
	    $fretCount = $this->args['frets'];

	    $fretDistance = 80;
	    $stringDistance = 50;

	    $totalWidth = ($fretDistance * $fretCount) + 60;

		$output  = '
			<svg viewBox="0 0 '.$totalWidth.' 310" style="'.$this->args['style'].'">
		    <g id="Layer1">';


		    $stringWidth = $fretCount * $fretDistance;
    $parts = array(
    	'string1' => '<path d="M90,30 L'.($stringWidth + 90).',30" style1 />',
    	'string2' => '<path d="M90,80 L'.($stringWidth + 90).',80" style1 />',
    	'string3' => '<path d="M90,130 L'.($stringWidth + 90).',130" style1 />',
    	'string4' => '<path d="M90,180 L'.($stringWidth + 90).',180" style1 />',
    	'string5' => '<path d="M90,230 L'.($stringWidth + 90).',230" style1 />',
    	'string6' => '<path d="M90,280 L'.($stringWidth + 90).',280" style1 />',
    );

    for($i=0;$i<$fretCount;$i++) {
    	$parts['fret'.$i] = '<path d="M'.(($i * $fretDistance) + 90).',30 L'.(($i * $fretDistance) + 90).',280" style1 />';
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
    	$parts[] = '<text style="font-family:verdana;font-weight:bold;font-style:italic;font-size:25px;" text-anchor="middle" x="'.(($fretDistance * $i) + 50).'" y="330" fill="black">'.$i.'</text>';
    }

    foreach($strings as $index=>$string) {
    	$tone = $strings[$index];
    	for($i=0;$i<$fretCount;$i++){

    		if ($this->scale->containsPitch($tone, false)) {
	    		$parts[] = '<circle cx="'.(($fretDistance * $i) + 50).'" cy="'.(($stringDistance * $index) + 30).'" r="23" style="fill:black;"/>';
	    		$a = '';
	    		echo $tone->alter;
	    		switch($tone->alter) {
	    			case -1:
	    				$a = 'b';
	    				break;
	    			case 1:
	    				$a = '#';
	    			default:
	    				$a = '';
	    		}
	    		$parts[] = '<text style="font-family:verdana;font-weight:bold;font-style:italic;font-size:25px;" text-anchor="middle" x="'.(($fretDistance * $i) + 50).'" y="'.(($stringDistance * $index)+39).'" fill="white">'.$tone->step . $a .'</text>';
    		}
    		$tone->transpose(1, $this->args['accidental']);
    	}
    }

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