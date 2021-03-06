<?php
/**
 * Instrument Class
 *
 * Instrument is a physical device that produces sound, like a piano or trumpet. We can grab one of the predefined
 * instrument classes, but we should also be allowed to construct an abstract instrument with bespoke properties
 *
 * @package ianring/PHPMusicTools
 * @author  Ian Ring <httpwebwitch@gmail.com>
 */

namespace ianring;
require_once 'PMTObject.php';

class Instrument extends PMTObject
{


	function __construct($name, $rangeMin=null, $rangeMax=null, $transpose=0, $family=null) {
		$this->name      = $name;
		$this->rangeMin  = $rangeMin;
		$this->rangeMax  = $rangeMax;
		$this->transpose = $transpose;
		$this->family    = $family;

	}


	public static function constructFromArray($props) {
		$name      = $props['name'];
		$rangeMin  = Pitch::constructFromArray($props['rangeMin']);
		$rangeMax  = Pitch::constructFromArray($props['rangeMax']);
		$transpose = $props['transpose'];
		$family    = $props['family'];
		return new Instrument($name, $rangeMin, $rangeMax, $transpose, $family);

	}


	/**
	 * For example, new Instrument('Piano') would create an InstrumentPiano
	 */
	public static function constructFromName($name) {
		if (in_array($this->instruments, $name)) {
			return new
		}
	}


	public static $instruments = array(
		'Piano',
		'AltoSaxophone',
	);

}
