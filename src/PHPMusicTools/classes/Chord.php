<?php
namespace ianring;

require_once 'PMTObject.php';
require_once 'Note.php';

/**
 * Chord is a collection of notes that share the same stem, and which are sounded simultaneously.
 */
class Chord extends PMTObject {

	public $notes = array();

	public function __construct($notes = array()) {
		if (!is_array($notes)) {
			$notes = array($notes);
		}
		foreach ($notes as $note) {
			$this->addNote($note);
		}
	}

	/**
	 * accepts the scale object in the form of an array structure
	 * @param  [winged] $scale [description]
	 * @return [winged]        [description]
	 */
	public static function constructFromArray($props) {
		$notes = array();
		if (isset($props['notes'])) {
			foreach ($props['notes'] as $note) {
				if ($note instanceof Note) {
					$notes[] = $note;
				} else {
					$notes[] = Note::constructFromArray($note);
				}
			}
		}

		return new Chord($notes);
	}


	/**
	 * transposes all the notes in this chord by $interval
	 * @param  integer  $interval  a signed integer telling how many semitones to transpose up or down
	 * @param  integer  $preferredAlteration  either 1, or -1 to indicate whether the transposition should prefer sharps or flats.
	 * @return  null
	 */
	public function transpose($interval, $preferredAlteration = 1) {
		foreach ($this->notes as &$note) {
			$note->transpose($interval, $preferredAlteration);
		}
	}


	function addNote($note) {
		if (!$note instanceof Note) {
			$note = new Note($note);
		}
		$this->notes[] = clone $note;
	}

	function clear() {
		$this->notes[] = array();
	}

	/**
	 * renders this object as MusicXML
	 * @return string MusicXML representation of the object
	 */
	function toMusicXML() {
		$out = '';
		$n = 0;
		foreach ($this->notes as $note) {
			if (count($this->notes) > 1 && $n > 0) {
				$note->setProperty('chord', true);
			}
			$out .= $note->toMusicXML();
			$n++;
		}
		return $out;
	}

	/**
	 * analyze the current chord, and return an array of all the Scales that its notes fit into.
	 * @param  Pitch  $root  if the root is known and we only want to learn about matching modes, provide a Pitch for the root.
	 * @return [type] [description]
	 */
	public function getScales($root = null) {
		$scales = Scale::getScales($this);
	}


	/**
	 * returns an array of Pitch objects, for every pitch of every note in the chord.
	 * @param  boolean  $heightless  if true, will return heightless pitches all mudulo to the same octave. Useful for
	 *                              analysis, determining mode etc.
	 * @return array                a key for every pitch represented in string form (like "C#4" or "A-7", and inside that an array
	 *                      	    of Pitch objects.
	 */
	public function getAllPitches($heightless = false) {
		$pitches = array();

		foreach ($this->notes as $note) {
			$pitch = $note->properties['pitch'];
			if ($heightless) {
				$pitch->setProperty('octave', null);
			}
			$pitchStringKey = $pitch->toString();
			if (!is_array($pitches[$pitchStringKey])) {
				$pitches[$pitchStringKey] = array();
			}
			$pitches[$pitchStringKey][] = $pitch;
		}
		// dedupe + count
		return $pitches;
	}

}

