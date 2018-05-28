<?php
namespace ianring;

require_once('Visualization.php');


/**
 * renders a piano keyboard, with notes indicated
 * @param  [type] $notes [description]
 * @return [type]        [description]
 */
class PianoKeyboard extends Visualization {

	public function __construct($args=array()) {

		$this->args = array_merge(
			array(
				'range' => '21,108',
				'selected' => '',
				'style' => ''
			),
			$args
		);

		$this->args['range'] = explode(',',$this->args['range']);

	}


	function render() {

		$notes = $this->pitchesToNotes($this->args['selected']);

		// define an array with all the notes from 0 to 88 and their x y
		$keys = array(
			0 => array("x" => 3, "color" => "white"),
			2 => array("x" => 13, "color" => "white"),
			3 => array("x" => 23, "color" => "white"),
			5 => array("x" => 33, "color" => "white"),
			7 => array("x" => 43, "color" => "white"),
			8 => array("x" => 53, "color" => "white"),
			10 => array("x" => 63, "color" => "white"),
			12 => array("x" => 73, "color" => "white"),
			14 => array("x" => 83, "color" => "white"),
			15 => array("x" => 93, "color" => "white"),
			17 => array("x" => 103, "color" => "white"),
			19 => array("x" => 113, "color" => "white"),
			20 => array("x" => 123, "color" => "white"),
			22 => array("x" => 133, "color" => "white"),
			24 => array("x" => 143, "color" => "white"),
			26 => array("x" => 153, "color" => "white"),
			27 => array("x" => 163, "color" => "white"),
			29 => array("x" => 173, "color" => "white"),
			31 => array("x" => 183, "color" => "white"),
			32 => array("x" => 193, "color" => "white"),
			34 => array("x" => 203, "color" => "white"),
			36 => array("x" => 213, "color" => "white"),
			38 => array("x" => 223, "color" => "white"),
			39 => array("x" => 233, "color" => "white"),
			41 => array("x" => 243, "color" => "white"),
			43 => array("x" => 253, "color" => "white"),
			44 => array("x" => 263, "color" => "white"),
			46 => array("x" => 273, "color" => "white"),
			48 => array("x" => 283, "color" => "white"),
			50 => array("x" => 293, "color" => "white"),
			51 => array("x" => 303, "color" => "white"),
			53 => array("x" => 313, "color" => "white"),
			55 => array("x" => 323, "color" => "white"),
			56 => array("x" => 333, "color" => "white"),
			58 => array("x" => 343, "color" => "white"),
			60 => array("x" => 353, "color" => "white"),
			62 => array("x" => 363, "color" => "white"),
			63 => array("x" => 373, "color" => "white"),
			65 => array("x" => 383, "color" => "white"),
			67 => array("x" => 393, "color" => "white"),
			68 => array("x" => 403, "color" => "white"),
			70 => array("x" => 413, "color" => "white"),
			72 => array("x" => 423, "color" => "white"),
			74 => array("x" => 433, "color" => "white"),
			75 => array("x" => 443, "color" => "white"),
			77 => array("x" => 453, "color" => "white"),
			79 => array("x" => 463, "color" => "white"),
			80 => array("x" => 473, "color" => "white"),
			82 => array("x" => 483, "color" => "white"),
			84 => array("x" => 493, "color" => "white"),
			86 => array("x" => 503, "color" => "white"),
			87 => array("x" => 513, "color" => "white"),

			1 => array("x" => 10.5, "color" => 'black'),
			4 => array("x" => 30.5, "color" => 'black'),
			6 => array("x" => 40.5, "color" => 'black'),
			9 => array("x" => 60.5, "color" => 'black'),
			11 => array("x" => 70.5, "color" => 'black'),
			13 => array("x" => 80.5, "color" => 'black'),
			16 => array("x" => 100.5, "color" => 'black'),
			18 => array("x" => 110.5, "color" => 'black'),
			21 => array("x" => 130.5, "color" => 'black'),
			23 => array("x" => 140.5, "color" => 'black'),
			25 => array("x" => 150.5, "color" => 'black'),
			28 => array("x" => 170.5, "color" => 'black'),
			30 => array("x" => 180.5, "color" => 'black'),
			33 => array("x" => 200.5, "color" => 'black'),
			35 => array("x" => 210.5, "color" => 'black'),
			37 => array("x" => 220.5, "color" => 'black'),
			40 => array("x" => 240.5, "color" => 'black'),
			42 => array("x" => 250.5, "color" => 'black'),
			45 => array("x" => 270.5, "color" => 'black'),
			47 => array("x" => 280.5, "color" => 'black'),
			49 => array("x" => 290.5, "color" => 'black'),
			52 => array("x" => 310.5, "color" => 'black'),
			54 => array("x" => 320.5, "color" => 'black'),
			57 => array("x" => 340.5, "color" => 'black'),
			59 => array("x" => 350.5, "color" => 'black'),
			61 => array("x" => 360.5, "color" => 'black'),
			64 => array("x" => 380.5, "color" => 'black'),
			66 => array("x" => 390.5, "color" => 'black'),
			69 => array("x" => 410.5, "color" => 'black'),
			71 => array("x" => 420.5, "color" => 'black'),
			73 => array("x" => 430.5, "color" => 'black'),
			76 => array("x" => 450.5, "color" => 'black'),
			78 => array("x" => 460.5, "color" => 'black'),
			81 => array("x" => 480.5, "color" => 'black'),
			83 => array("x" => 490.5, "color" => 'black'),
			85 => array("x" => 500.5, "color" => 'black'),
		);

		// keys are numbered 0 to 87
		// midi numbers are 21 to 108

		$rects = array();
		$minx = 99999999;
		$maxx = 0;
		$range = $this->args['range'];

		sort($range);
		print_r($notes);

		foreach($keys as $index => $key) {
			if ($index >= self::midi2key($range[0]) && $index <= self::midi2key($range[1])) {
				$minx = min($minx, $key['x']);
				$maxx = max($maxx, $key['x']);
				$height = ($key['color'] == 'white') ? 50 : 25;
				$width = ($key['color'] == 'white') ? 10 : 5;
				$stroke = ($key['color'] == 'white') ? '#888888' : '#000000';
				$fill = in_array($index, $notes) ? '#ff0000' : $key['color'];
				$rects[] .= '<rect x="'.$key['x'].'" y="20" height="'.$height.'" width="'.$width.'" style="stroke:'.$stroke.'; fill: '.$fill.'"></rect>';
			}
		}


		$output = '<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="'.$minx.' 0 '.$maxx.' 100" style="'.$this->args['style'].'">';
		$output .= implode('', $rects);
		$output .= '</svg>';
		return $output;
	}

	private static function midi2key($midi){
		return $midi - 21;
	}
	private static function key2midi($key){
		return $key + 21;
	}

	private function pitchesToNotes() {
		$output = array();
		foreach($this->args['selected'] as $pitch) {
			$output[] = $pitch->toNoteNumber() + 39;
		}
		return $output;
	}

}

// for($i=0;$i<88;$i++) {
// 	echo $i;
// 	render(array($i));
// 	echo '<br/>';
// }


