<?php

require_once 'PHPMusicToolsTest.php';
require_once '../classes/Scale.php';
require_once '../classes/Pitch.php';

class ScaleTest extends PHPMusicToolsTest
{
	
	protected function setUp(){
	}
	
	public function testConstructFromArray(){

		$input = array(
			'scale' => 4033,
			'root' => array(
				'step' => 'C',
				'alter' => 1,
				'octave' => 4,
			),
			'direction' => 'ascending'
		);

		$scale = \ianring\Scale::constructFromArray($input);

		$this->assertObjectHasAttribute('scale', $scale);
		$this->assertObjectHasAttribute('root', $scale);
		$this->assertObjectHasAttribute('direction', $scale);

		$this->assertInstanceOf(\ianring\Pitch::class, $scale->root);
		$this->assertEquals('C', $scale->root->step);
		$this->assertEquals(1, $scale->root->alter);
		$this->assertEquals(4, $scale->root->octave);

		$this->assertEquals('ascending', $scale->direction);

	}

	/**
	 * [testNormalizeScalePitches description]
	 * @return [type] [description]
	 * @dataProvider normalizeScalePitchesProvider
	 */
	public function testNormalizeScalePitches($scale, $pitches, $expected) {
		$scale = new \ianring\Scale($scale, $pitches[0]);
		$actual = $scale->_normalizeScalePitches($pitches);
		$this->assertEquals($expected, $actual);
	}
	public function normalizeScalePitchesProvider() {
		return array(
			array(
				'scale' => 2741,
				'pitches' => array(
					new \ianring\Pitch('C', 0, 3),
					new \ianring\Pitch('D', 0, 3),
					new \ianring\Pitch('F', -1, 3), // this one should change to an E natural
					new \ianring\Pitch('F', 0, 3),
					new \ianring\Pitch('G', 0, 3),
					new \ianring\Pitch('A', 0, 3),
					new \ianring\Pitch('B', 0, 3),
				),
				'expected' => array(
					new \ianring\Pitch('C', 0, 3),
					new \ianring\Pitch('D', 0, 3),
					new \ianring\Pitch('E', 0, 3),
					new \ianring\Pitch('F', 0, 3),
					new \ianring\Pitch('G', 0, 3),
					new \ianring\Pitch('A', 0, 3),
					new \ianring\Pitch('B', 0, 3),
				)
			),
			array(
				'scale' => 2741,
				'pitches' => array(
					new \ianring\Pitch('C', 1, 3),
					new \ianring\Pitch('D', 1, 3),
					new \ianring\Pitch('F', 0, 3), // this one should change to an E sharp
					new \ianring\Pitch('F', 1, 3),
					new \ianring\Pitch('G', 1, 3),
					new \ianring\Pitch('A', 1, 3),
					new \ianring\Pitch('C', 0, 4), // this should become a B sharp
				),
				'expected' => array(
					new \ianring\Pitch('C', 1, 3),
					new \ianring\Pitch('D', 1, 3),
					new \ianring\Pitch('E', 1, 3),
					new \ianring\Pitch('F', 1, 3),
					new \ianring\Pitch('G', 1, 3),
					new \ianring\Pitch('A', 1, 3),
					new \ianring\Pitch('B', 1, 4),
				)
			)
		);
	}


}
