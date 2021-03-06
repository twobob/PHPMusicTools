<?php
/**
 * Layer Class
 *
 * Layer is a collection of chords, aka a "voice" of consecutive sets of notes in a measure
 *
 * @package ianring/PHPMusicTools
 * @author  Ian Ring <httpwebwitch@gmail.com>
 */

namespace ianring;
require_once 'PMTObject.php';
require_once 'Chord.php';

class Layer extends PMTObject
{

    public $chords = array();


    public function __construct($name, $chords) {
        foreach (array('name', 'chords') as $var) {
            $this->$var = $$var;
        }

    }


    public static function constructFromArray($props) {
        $name   = null;
        if (isset($props['name'])) {
            $name = $props['name'];
        }
        $chords = array();
        if (isset($props['chords'])) {
            foreach ($props['chords'] as $chord) {
                if ($chord instanceof Chord) {
                    $chords[] = $chord;
                } else {
                    $chords[] = Chord::constructFromArray($chord);
                }
            }
        }

        return new Layer($name, $chords);

    }


    function addNote($note) {
        $chord = new Chord();
        $chord->addNote($note);
        $this->addChord($chord);

    }


    function addChord($chord) {
        $this->chords[] = clone $chord;

    }


    function clear() {
        $this->chords[] = array();

    }


    /**
     * renders this object as MusicXML
     *
     * @return string MusicXML representation of the object
     */
    function toMusicXML() {
        $out = '';
        foreach ($this->chords as $chord) {
            $out .= $chord->toMusicXML();
        }

        return $out;
    }



    /**
     * transposes all the notes in this layer by $interval
     *
     * @param  integer $interval            a signed integer telling how many semitones to transpose up or down
     * @param  integer $preferredAlteration either 1, or -1 to indicate whether the transposition should prefer sharps or flats.
     * @return null
     */
    public function transpose($interval, $preferredAlteration = 1) {
        foreach ($this->chords as &$chord) {
            $chord->transpose($interval, $preferredAlteration);
        }

    }


    /**
     * using the 's own Key, will quantize all the notes to be part of a given scale.
     * If scale is omitted, will use the scale implied by the Key's "mode" property.
     *
     * @param  $key    a Pitch, like "C" or "G#"
     * @param  $scale  a Scale object
     * @return null
     */
    public function autoTune($key, $scale=null) {
        foreach ($this->chords as &$chord) {
            $chord->autoTune($key, $scale);
        }

    }


    /**
     * analyze the current layer, and return an array of all the Scales that its notes fit into.
     *
     * @param  Pitch $root if the root is known and we only want to learn about matching modes, provide a Pitch for the root.
     * @return [type] [description]
     */
    public function getScales($root=null) {
        $scales = Scale::getScales($this);

    }


    /**
     * returns an array of Pitch objects, for every pitch of every note in the layer.
     *
     * @param  boolean $heightless if true, will return heightless pitches all mudul to the same octave. Useful for analysis, determining mode etc. analysis, determining mode etc.
     *                              analysis, determining mode etc.
     * @return array  an array of Pitch objects
     */
    public function getAllPitches($heightless=false) {
        $pitches = array();
        foreach ($this->chords as $chord) {
            $chordPitches = $chord->getAllPitches($heightless);
            $pitches      = array_merge_recursive($pitches, $chordPitches);
        }

        return $pitches;

    }


}
