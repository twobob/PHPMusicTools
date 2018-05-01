<?php

require_once('Visualization.php');
require_once(__DIR__ . '/../classes/Scale.php');

class CircleFifths extends Visualization {

	public function __construct($lines=array(), $args=array()) {
		$this->lines = $lines;
		$this->args = array_merge(
			$args,
			array(
				'size' => 200,
			)
		);
	}


	public function render() {
		$lines = $this->lines;
		$size = $this->args['size'];

		$fifths = array('C','G','D','A','E','B','F#','D-','A-','E-','B-','F');

		$s = '';
		if ($size > 100) {
			$stroke = 3;
		} elseif ($size > 70) {
			$stroke = 2;
		} else {
			$stroke = 1;
		}

		$smallrad = floor(($size / 12));
		$centerx = $size / 2;
		$centery = $size / 2;
		$radius = floor(($size - ($smallrad*2) - ($stroke*4)) / 2);
		$flatsign = '<path d="M 98.166,443.657 C 98.166,444.232 97.950425,444.78273 97.359,445.52188 C 96.732435,446.30494 96.205,446.75313 95.51,447.28013 L 95.51,443.848 C 95.668,443.449 95.901,443.126 96.21,442.878 C 96.518,442.631 96.83,442.507 97.146,442.507 C 97.668,442.507 97.999,442.803 98.142,443.393 C 98.158,443.441 98.166,443.529 98.166,443.657 z M 98.091,441.257 C 97.66,441.257 97.222,441.376 96.776,441.615 C 96.33,441.853 95.908,442.172 95.51,442.569 L 95.51,435.29733 L 94.947,435.29733 L 94.947,447.75213 C 94.947,448.10413 95.043,448.28013 95.235,448.28013 C 95.346,448.28013 95.483913,448.18713 95.69,448.06413 C 96.27334,447.71598 96.636935,447.48332 97.032,447.23788 C 97.482617,446.95792 97.99,446.631 98.661,445.991 C 99.124,445.526 99.459,445.057 99.667,444.585 C 99.874,444.112 99.978,443.644 99.978,443.179 C 99.978,442.491 99.795,442.002 99.429,441.713 C 99.015,441.409 98.568,441.257 98.091,441.257 z " />';

		$s .= '<svg xmlns="http://www.w3.org/2000/svg" height="'. ($size + 3).'" width="'.($size + 3) .'">';
		$s .= '<circle r="'.$radius.'" cx="'.$centerx.'" cy="'.$centery.'" stroke-width="'.$stroke.'" fill="white" stroke="black"/>';

		$points = array();
		$symmetryshape = array();
		for ($i=0; $i<12; $i++) {
			$deg = $i * 30 - 90;
			
			$x1 = floor($centerx + ($radius * cos(deg2rad($deg))));
			$y1 = floor($centery + ($radius * sin(deg2rad($deg))));

			$innerx1 = floor($centerx + (($radius -10) * cos(deg2rad($deg))));
			$innery1 = floor($centery + (($radius -10) * sin(deg2rad($deg))));

			$outerx1 = floor($centerx + (($radius +10) * cos(deg2rad($deg))));
			$outery1 = floor($centery + (($radius +10) * sin(deg2rad($deg))));

			$points[$i] = array('x' => $x1, 'y'=>$y1);

			$s .= '<circle r="2" cx="'.$x1.'" cy="'.$y1.'" stroke="black" stroke-width="'.$stroke.'"/>';
			$addflat = false; $addsharp = false;
			$text = $text = $fifths[$i];
			if (strchr($fifths[$i],'-')){
				$text = $fifths[$i][0];
				$addflat = true;
			} elseif (strchr($fifths[$i],'+')){
				$text = $fifths[$i][0];
				$addsharp = true;
			}
			$x = ($addflat||$addsharp)?($outerx1-8):($outerx1);
			$s .= '<text style="font-weight: bold;font-family:verdana;" text-anchor="middle" x="'.$x.'" y="'. ($outery1+5) .'" fill="black">'.$text.'</text>';
			if ($addflat){
				$s .= '<g transform="translate('.($outerx1 - 96).','.($outery1 - 445).')" style="fill:#000000" id="g2111">'.$flatsign.'</g>';
			}

		}

      
		// print_r($points);
		// print_r($lines);

		if (count($lines) > 1) {
			for ($i=0; $i<count($lines); $i++) {
				$from = $i;
				$to = ($i + 1) % (count($lines));

				$frompoint = $points[$lines[$from]];
				$topoint = $points[$lines[$to]];

				$s .= '<path d="M' . $frompoint['x'] . ',' . $frompoint['y'] . ' L' . $topoint['x'] . ',' . $topoint['y'] . '" stroke="black" stroke-width="'.$stroke.'" />';
			}
		}
		$s .= '</svg>';
		return $s;
	}


}