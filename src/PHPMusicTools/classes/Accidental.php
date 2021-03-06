<?php
/**
 * Accidental Class
 *
 * Accidental is a symbol that represents a pitch alteration, e.g. a sharp, flat, natural, etc.
 *
 * @package      PHPMusicTools
 * @author       Ian Ring <httpwebwitch@email.com>
 */

namespace ianring;
require_once 'PMTObject.php';

/**
 * Accidental Class
 */
class Accidental extends PMTObject {

	/**
	 * @var  array  $properties    the properties of this object
	 */
	public static $properties = array(
		'type',
		'size',
		'parentheses',
		'bracket',
		'editorial',
		'courtesy',
	);

	/**
	 * @var  array  $types  the types of accidentals
	 * @see  https://usermanuals.musicxml.com/MusicXML/Content/ST-MusicXML-accidental-value.htm
	 */
	public static $types = array(
		'sharp',
		'flat',
		'natural',
		'double-sharp',
		'double-flat',
		'sharp-sharp',
		'flat-flat',
		'natural-sharp',
		'natural-flat',
		'quarter-flat',
		'quarter-sharp',
		'three-quarters-flat',
		'three-quarters-sharp',
    	'sharp-down',
    	'sharp-up',
    	'natural-down',
    	'natural-up',
    	'flat-down',
    	'flat-up',
    	'triple-sharp',
    	'triple-flat',
    	'slash-quarter-sharp',
    	'slash-sharp',
    	'slash-flat',
    	'double-slash-flat',
    	'sharp-1',
    	'sharp-2',
    	'sharp-3',
    	'sharp-5',
    	'flat-1',
    	'flat-2',
    	'flat-3',
    	'flat-4',
    	'sori',
    	'koron',
	);


	/**
	 * Constructor.
	 *
	 * @param string  $type        the type may be one of the $types
	 * @param string  $size        size of the accidental - may be "full", "cue", or "large"
	 * @param boolean $parentheses true if the accidental should be enclosed in parentheses
	 * @param boolean $bracket     true if the accidental should be enclosed in brackets
	 * @param boolean $editorial   true if the accidental is an editorial accidental
	 * @param boolean $courtesy    true if the accidental is a courtesy accidental, also known as a "cautionary" accidental.
	 */
	public function __construct($type='natural', $size=false, $parentheses=false, $bracket=false, $editorial=false, $courtesy=false) {
		foreach (self::$properties as $var) {
			$this->$var = $$var;
		}

	}


	/**
	 * constructs the object from an array serialization
	 *
	 * @param  array $props the array of properties
	 * @return Accidental the Accidental object.
	 */
	public static function constructFromArray($props) {
		if (!is_array($props)) {
			$props = array('type' => $props);
		}

		$defaults = array_fill_keys(self::$properties, null);
		$props    = array_merge($defaults, $props);
		extract($props);

		return new Accidental($type, $size, $parentheses, $bracket, $editorial, $courtesy);

	}


	/**
	 * returns the Unicode symbol given an accidental type.
	 *
	 * @return string the Unicode symbol address
	 */
	function getUnicode() {
		$codes = array(
			'sharp'                => '266F',
			'flat'                 => '266D',
			'natural'              => '266E',
			'double-sharp'         => '1D12A',
			'double-flat'          => '1D12B',
			'sharp-sharp'          => '1D130',
			'flat-flat'            => '1D12D',
			'natural-sharp'        => '1D12E',
			'natural-flat'         => '1D12F',
			'quarter-flat'         => '1D133',
			'quarter-sharp'        => '1D132',
			'three-quarters-flat'  => '1D12D',
			'three-quarters-sharp' => '1D130',
		);
		return $codes[$this->type];

	}


	/**
	 * renders this object as MusicXML
	 *
	 * @return string MusicXML representation of the object
	 */
	function toMusicXML() {
		$out  = '';
		$out .= '<accidental';

		$out .= '/>';
		return $out;
	}

	public static function alterToVexFlow($alter) {
        $map = array(
            -2 => 'bb',
            -1 => 'b',
            0 => 'n',
            1 => '#',
            2 => '##'
        );
        return $map[$alter];
    }

    public function toLilypond($alter) {
        $map = array(
            -2 => 'eses',
            -1 => 'es',
            0 => '',
            1 => 'is',
            2 => 'isis'
        );
        return $map[$alter];

    }

}
