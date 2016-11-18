<?php
namespace ianring;

class BarlineRepeat extends PMTObject {

	public function __construct($direction, $winged) {
		$this->direction = $direction;
		$this->winged = $winged;
	}

	/**
	 * accepts the object in the form of an array structure
	 * @param  [winged] $scale [description]
	 * @return [winged]        [description]
	 */
	public static function constructFromArray($props) {
		$direction = $props['direction']; // forward, backward
		$winged = $props['winged'];
		return new BarlineRepeat($direction, $winged);
	}

	/**
	 * renders this object as MusicXML
	 * @return string MusicXML representation of the object
	 */
	function toMusicXML() {
		$out = '';
			$out .= '<repeat';
			if (isset($this->direction)) {
				$out .= ' direction="' . $this->direction . '"';
			}
			if (isset($this->winged)) {
				$out .= ' winged="' . $this->winged . '"';
			}
			$out .= '></repeat>';
			return $out;
	}
}
