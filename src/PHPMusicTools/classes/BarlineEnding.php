<?php
namespace ianring;
require_once 'PMTObject.php';

/**
 * BarlineEnding is a notation for the final bar in a repeated section
 */
class BarlineEnding extends PMTObject
{


    public function __construct($number, $type)
    {
        foreach (array('number', 'type') as $var) {
            $this->$var = $$var;
        }

    }//end __construct()


    /**
     * accepts the object in the form of an array structure
     *
     * @param  [type] $scale [description]
     * @return [type]        [description]
     */
    public static function constructFromArray($props)
    {
        $number = $props['number'];
        $type   = $props['type'];
        return new BarlineEnding($number, $type);

    }//end constructFromArray()


    /**
     * renders this object as MusicXML
     *
     * @return string MusicXML representation of the object
     */
    function toMusicXML()
    {
        $out .= '<ending';
        if (isset($this->number)) {
            $out .= ' number="'.$this->number.'"';
        } else {
            $out .= ' number="1"';
        }

        if (isset($this->type)) {
            $out .= ' type="'.$this->type.'"';
        }

        $out .= '>';
        $out .= '</ending>';

    }//end toMusicXML()


}//end class
