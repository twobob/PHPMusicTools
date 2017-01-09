<?php
namespace ianring;
require_once 'PMTObject.php';

/**
 * Instrument is a physical device that produces sound, like a piano or trumpet.
 */
class Instrument extends PMTObject
{


    function __construct($name, $rangeMin=null, $rangeMax=null, $transpose=0, $family=null)
    {
        $this->name      = $name;
        $this->rangeMin  = $rangeMin;
        $this->rangeMax  = $rangeMax;
        $this->transpose = $transpose;
        $this->family    = $family;

    }//end __construct()


    public static function constructFromArray($props)
    {
        $name      = $props['name'];
        $rangeMin  = Pitch::constructFromArray($props['rangeMin']);
        $rangeMax  = Pitch::constructFromArray($props['rangeMax']);
        $transpose = $props['transpose'];
        $family    = $props['family'];
        return new Instrument($name, $rangeMin, $rangeMax, $transpose, $family);

    }//end constructFromArray()


    public static function constructFromName($name)
    {
        $instrument = new Instrument($name);
        $instrument->getProperties();
        return $instrument;

    }//end constructFromName()


    function getProperties()
    {
        if (isset(self::$instruments[$this->name])) {
            $i               = self::$instruments[$this->name];
            $this->rangeMin  = Pitch::constructFromArray($i['rangeMin']);
            $this->rangeMax  = Pitch::constructFromArray($i['rangeMax']);
            $this->transpose = $i['transpose'];
            $this->family    = $i['family'];
        } else {
            // todo
            // search for it in otherNames
        }

    }//end getProperties()


    public static $instruments = array(
                                  'Piano'          => array(
                                                       'rangeMin'     => array(
                                                                          'step'   => 'A',
                                                                          'alter'  => 0,
                                                                          'octave' => 1,
                                                                         ),
                                                       'rangeMax'     => array(
                                                                          'step'   => 'C',
                                                                          'alter'  => 0,
                                                                          'octave' => 8,
                                                                         ),
                                                       'transpose'    => 0,
                                                       'family'       => 'percussion',
                                                       'otherNames'   => array('Pianoforte'),
                                                       'abbreviation' => 'Piano',
                                                      ),
                                  'Alto Saxophone' => array(
                                                       'rangeMin'     => array(
                                                                          'step'   => 'D',
                                                                          'alter'  => -1,
                                                                          'octave' => 3,
                                                                         ),
                                                       'rangeMax'     => array(
                                                                          'step'   => 'A',
                                                                          'alter'  => 0,
                                                                          'octave' => 5,
                                                                         ),
                                                       'transpose'    => 8,
                                                       'family'       => 'woodwind',
                                                       'otherNames'   => array(
                                                                          'E flat Alto Saxophone',
                                                                          'E flat Alto Sax',
                                                                          'Alto Sax',
                                                                         ),
                                                       'abbreviation' => 'Alto Sax',
                                                      ),
                                 );

}//end class
