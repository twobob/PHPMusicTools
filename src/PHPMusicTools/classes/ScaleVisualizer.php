<?php
namespace ianring;
require_once 'PMTObject.php';
require_once 'Scale.php';

/**
 * A class of public static methods that are handy for displaying scales
 */

/**
 * Scale is a series of notes all conforming to a set, moving stepwise ascending or descending
 */
class ScaleVisualizer extends Scale
{

	/**
	 * takes a scale spectrum or a scale number, and renders the "pmn" summmary string, ala Howard Hansen
	 *
	 * @param  [type] $spectrum [description]
	 * @return [type]           [description]
	 */
	public static function renderPmn($scale) {
		if (is_integer($scale)) {
			$scale = new Scale($scale);
		}
		$spectrum = $scale->spectrum();
		$string = '';
		// remember these are 0-based, so they're like the number of semitones minus 1
		$classes = array('p' => 4, 'm' => 3, 'n' => 2, 's' => 1, 'd' => 0, 't' => 5);
		foreach ($classes as $class => $interval) {
			if ($spectrum[$interval] > 0) {
				$string .= $class;
			}
			if ($spectrum[$interval] > 1) {
				$string .= '<sup>'.$spectrum[$interval].'</sup>';
			}
		}
		return '<em>' . $string . '</em>';
	}


	public static function renderChicklet($scale, $showName = false) {
		if (is_integer($scale)) {
			$scale = new Scale($scale);
		}
		if (is_array($scale)) {
			$str = '';
			foreach ($scale as $sc) {
				$str .= self::renderChicklet($sc);
			}
			return $str;
		}
		$s = '<span class="scale-chicklet">';
		$s .= '<a href="/scales/'.$scale->scale.'">'.$scale->scale.'</a>';
		if ($showName) {
			$name = $scale->name();
			if (!empty($name)) {
				$s .= ' ('.$name.')';
			}
		}

		$middleC = new \ianring\Pitch('C', 0, 4);
		$scale->root = $middleC;
		$pitches = $scale->getPitches();
		foreach ($pitches as $pitch) {
			$c = array();
			$c[] = $pitch->toMidiKeyNumber();
			$notes[] = $c;
		}
		$jsonNotes = json_encode($notes, true);

		$s .= '&nbsp;<i class="icon-play2 player" data-midi="'.htmlspecialchars($jsonNotes).'"></i>';
		$s .= '</span>';
		return $s;

	}

	public static function pitchClassSet($scale) {
		if (is_integer($scale)) {
			$scale = new Scale($scale);
		}
		$tones = $scale->getTones();
		return '{' . implode(',', $tones) . '}';
	}

	public static function distributionSpectrum($spectrum) {
	 	$str = '';
	 	foreach ($spectrum as $key => $value) {
	 		$str .= '&lt;'.$key.'&gt; = {'.implode(',', $value).'}<br/>';
	 	}
	 	return $str;
	}

	public static function braceletHTML($scale, $grouped = false) {
		if (is_integer($scale)) {
			$scale = new Scale($scale);
		}
		if (is_array($scale)) {
			$str = '';
			if ($grouped) {
				$str .= '<div class="bracelet-group">';
			}
			foreach ($scale as $s) {
				$str .= self::braceletHTML($s);
			}
			if ($grouped) {
				$str .= '</div>';
			}
			return $str;
		}

		$middleC = new \ianring\Pitch('C', 0, 4);
		$scale->root = $middleC;
		$pitches = $scale->getPitches();
		foreach ($pitches as $pitch) {
			$c = array();
			$c[] = $pitch->toMidiKeyNumber();
			$notes[] = $c;
		}
		$jsonNotes = json_encode($notes, true);

		$s = '<div class="bracelet">';
		$s .= self::drawSVGBracelet($scale, 50);
		$s .= '<br/>';
		$s .= '<a href="https://ianring.com/musictheory/scales/'.$scale->scale.'">'.$scale->scale.'</a>';
		$s .= '&nbsp;<i class="icon-play2 player" data-midi="'.htmlspecialchars($jsonNotes).'"></i>';
		$s .= '</div>';
		return $s;
	}

	/**
	 * generates an SVG representation of a scale bracelet. tries to make it look decent at various sizes.
	 *
	 * @param  integer $scale             the scale being represented, ie a bitmask integer
	 * @param  integer $size              size in pixels
	 * @param  string  $text              if present, puts text in the middle of the bracelet
	 * @param  boolean $showImperfections if true, puts an "i" on imperfect notes in the scale
	 * @return string                     SVG as a string that you can insert into an HTML page
	 */
	public static function drawSVGBracelet($scale, $size = 200, $text = null, $showImperfections = false, $showSymmetries = false) {
		if (is_integer($scale)) {
			$scale = new Scale($scale);
		}

		if ($showImperfections) {
			$imperfections = $scale->imperfections();
		}
		if ($showSymmetries) {
			$symmetries = $scale->symmetries();
		}

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
		$s .= '<svg xmlns="http://www.w3.org/2000/svg" height="'. ($size + 3).'" width="'.($size + 3) .'">';
		$s .= '<circle r="'.$radius.'" cx="'.$centerx.'" cy="'.$centery.'" stroke-width="'.$stroke.'" fill="white" stroke="black"/>';
		$symmetryshape = array();
		for ($i=0; $i<12; $i++) {
			$deg = $i * 30 - 90;
			$x1 = floor($centerx + ($radius * cos(deg2rad($deg))));
			$y1 = floor($centery + ($radius * sin(deg2rad($deg))));

			$innerx1 = floor($centerx + (($radius - $smallrad) * cos(deg2rad($deg))));
			$innery1 = floor($centery + (($radius - $smallrad) * sin(deg2rad($deg))));

			if ($i == 0) {
				$symmetryshape[] = array($innerx1, $innery1);
			}

			$s .= '<circle r="'.$smallrad.'" cx="'.$x1.'" cy="'.$y1.'" stroke="black" stroke-width="'.$stroke.'"';
			if ($scale->scale & (1 << $i)) {
				$s .= ' fill="black"';
			} else {
				$s .= ' fill="white"';
			}
			$s .= '/>';

			if ($showImperfections) {
				if (in_array($i, $imperfections)) {
					$s .= '<text style="font-family: Times New Roman;font-weight:bold;font-style:italic;font-size:30px;" text-anchor="middle" x="'.$x1.'" y="'. ($y1 + 9) .'" fill="white">i</text>';
				}
			}
			if ($showSymmetries) {
				if (in_array($i, $symmetries)) {
					$symmetryshape[] = array($innerx1, $innery1);
				}
			}
		}
		if (count($symmetryshape) > 1) {
			for ($i = 0; $i < count($symmetryshape) - 1; $i++) {
				$s .= '<line x1="'.$symmetryshape[$i][0].'" y1="'.$symmetryshape[$i][1].'" x2="'.$symmetryshape[$i+1][0].'" y2="'.$symmetryshape[$i+1][1].'" style="stroke:#000;stroke-width:'.$stroke.'" />';
			}
			$s .= '<line x1="'.$symmetryshape[count($symmetryshape)-1][0].'" y1="'.$symmetryshape[count($symmetryshape)-1][1].'" x2="'.$symmetryshape[0][0].'" y2="'.$symmetryshape[0][1].'" style="stroke:#000;stroke-width:'.$stroke.'" />';
		}
		if (!empty($text)) {
			$s .= '<text style="font-weight: bold;" text-anchor="middle" x="'.$centerx.'" y="'. ($centery + 5) .'" fill="black">'.$text.'</text>';
		}
		$s .= '</svg>';
		return $s;
	}


}