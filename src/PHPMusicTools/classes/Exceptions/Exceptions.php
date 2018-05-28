<?php
 
class ToneRowSegmentNotDivisibleException extends \Exception {
	public $message = "The segment size must be divisible into the number of tones.";
}
class ToneRowSegmentTooSmallException extends \Exception {
	public $message = "A Tone Row Segment must have a size greater than 1.";
}
class ScaleIntervalPatternInvalidException extends \Exception {
	public $message = "The Intervals in an Interval Pattern defining a scale must add up to an octave.";
}
class ScalePitchesInRootlessScaleException extends \Exception {
	public $message = "We can not get pitches from a rootless scale.";
}
class PitchHeightlessAsXMLException extends \Exception {
	public $message = "Heightless Pitches can not be expressed as XML";
}


