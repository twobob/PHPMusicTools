<?php
namespace ianring;

require_once('Visualization.php');


/**
 * renders a guitar chord diagram
 * @param  [type] $notes [description]
 * @return [type]        [description]
 */
class GuitarChord extends Visualization {

	public function __construct($diagram = null, $args=array()) {
		if (is_array($diagram)) {
			$this->diagram = $diagram;
		} else {
			$this->getDiagram($diagram);
		}

		if (empty($args['style'])) {
			$args['style'] = 'width:100px;';
		}

		$this->args = array_merge(
			array(),
			$args
		);

	}

	public function getDiagram($chord) {
		$json = file_get_contents(__DIR__.'/GuitarChords.json');
		$map = json_decode($json, true);
		if (array_key_exists($chord, $map)) {
			$this->diagram = $map[$chord];
		} else {
			$this->diagram = null;
		}
	}


	function render() {

	    $stroke = 'black';
	    $fill = 'white';
	    $strokeWidth = '4pt';

	    $diagram = $this->diagram;
	    if (is_null($diagram)) {
	    	return '';
	    }

		$output  = '
			<svg viewBox="0 0 300 300" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="'.$this->args['style'].'">
    		<g id="Layer1">';

    $parts = array(
    	'string1' => '<path d="M30,50 L30,222" style1 />',
    	'string2' => '<path d="M80,50 L80,222" style1 />',
    	'string3' => '<path d="M130,50 L130,222" style1 />',
    	'string4' => '<path d="M180,50 L180,222" style1 />',
    	'string5' => '<path d="M230,50 L230,222" style1 />',
    	'string6' => '<path d="M280,50 L280,222" style1 />',

    	'fret0' => '<path d="M30,60 L280,60" style1 />',
    	'fret1' => '<path d="M30,100 L280,100" style1 />',
    	'fret2' => '<path d="M30,140 L280,140" style1 />',
    	'fret3' => '<path d="M30,180 L280,180" style1 />',
    	'fret4' => '<path d="M30,220 L280,220" style1 />',
    );

    if (empty($diagram['capo'])) {
    	$parts[] = '<rect width="250" height="10" x="30" y="50"></rect>';
    }
    if (!empty($diagram['capo'])) {
    	$parts[] = '<path d="M30,50 L280,50" style1 />';
    	$parts[] = '<text style="font-family:verdana;font-weight:bold;font-style:bold;font-size:30px;" text-anchor="left" x="0" y="65" fill="black">'.$diagram['capo'].'</text>';
    }
    if (!empty($diagram['label'])) {
    	$parts[] = '<text style="font-family:verdana;font-weight:bold;font-style:bold;font-size:50px;" text-anchor="middle" x="150" y="280" fill="black">'.$diagram['label'].'</text>';
    }

    if (!empty($diagram['bars'])) {
	    foreach($diagram['bars'] as $bar) {
	    	$x = (($bar['start'] * 50)+30);
	    	$width = (($bar['end'] * 50)+20) - $x;
	    	$y = (($bar['fret'] * 40)+35);
	    	$parts[] = '<rect width="'.$width.'" height="10" x="'.$x.'" y="'.$y.'"></rect>';    	
	    }
	}

    foreach($diagram['strings'] as $i => $string) {
    	if ($string['fret'] == 'open' || $string['fret'] === 0) {
	    	$parts[] = '<circle cx="'.((50*$i)+31).'" cy="28" r="10" style1 />';
    	} else if ($string['fret'] == 'closed') {
	    	$parts[] = '<path d="M' . ((50 * $i)+20) . ',20 L'.((50 * $i)+40).',40 	M'.((50 * $i)+40).',20 L'.((50 * $i)+20).',40" style1 />';
    	} else if (is_numeric($string['fret'])) {
    		$parts[] = '<circle cx="'.((50 * $i)+30).'" cy="'.((40 * $string['fret'])+40).'" r="15" style="fill:black;"/>';
    		if (!empty($string['finger'])) {
    			// draw the number here
    			$parts[] = '<text style="font-family:verdana;font-weight:bold;font-style:italic;font-size:25px;" text-anchor="middle" x="'.((50 * $i)+30).'" y="'.((40 * $string['fret'])+48).'" fill="white">'.$string['finger'].'</text>';
    		}
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