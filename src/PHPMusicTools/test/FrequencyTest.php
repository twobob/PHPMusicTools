<?php

require_once 'PHPMusicToolsTest.php';
require_once __DIR__.'/../classes/Frequency.php';

class FrequencyTest extends PHPMusicToolsTest {

	protected function setUp(){}


	/**
	 * @dataProvider provider_getFundamental
	 */
	public function test_getFundamental($fz, $max, $fuzz, $expected){
		$f = \ianring\Frequency::getFundamental($fz, $max, $fuzz);
		$this->assertEquals($expected, $f);
	}
	public function provider_getFundamental() {
		return array(
			array(
				'fz' => array(100,300,750),
				'max' => 30,
				'fuzz' => 0,
				'expected' => 50
			),
			array(
				'fz' => array(100,300,751),
				'max' => 30,
				'fuzz' => 0.01,
				'expected' => 50
			),
			array(
				'fz' => array(100,300,751),
				'max' => 200,
				'fuzz' => 0,
				'expected' => 1
			),
			array(
				'fz' => array(100,300,700),
				'max' => 20,
				'fuzz' => 0,
				'expected' => 100
			),
			array(
				'fz' => array(1000,3000,7500),
				'max' => 30,
				'fuzz' => 0,
				'expected' => 500
			),
			array(
				'fz' => array(7374,2882,3746,2736,8282,1400,9302,388,243),
				'max' => 30,
				'fuzz' => 0.01,
				'expected' => 48.6
			),
			array(
				'fz' => array(7374,2882,3746,2736,8282,1400,9302,388,243),
				'max' => 30,
				'fuzz' => 0.001,
				'expected' => null
			),
			'just one frequency' => array(
				'fz' => array(7374),
				'max' => 30,
				'fuzz' => 0.001,
				'expected' => 7374
			),
			'not an array' => array(
				'fz' => 7374,
				'max' => 30,
				'fuzz' => 0.001,
				'expected' => 7374
			),
		);
	}


	/**
	 * @dataProvider provider_getHarmonic
	 */
	public function test_getHarmonic($fz, $h, $expected){
		$f = new \ianring\Frequency($fz);
		$actual = $f->getHarmonic($h);
		$this->assertEquals($expected, $actual);
	}
	public function provider_getHarmonic() {
		return array(
			array(
				'fz' => 30,
				'h' => 2,
				'expected' => 60
			),
		);
	}

	/**
	 * @dataProvider provider_getHarmonicExeception
	 */
	public function test_getHarmonicExpection($fz, $h, $expected){
		$this->expectException($expected);
		$f = new \ianring\Frequency($fz);
		$actual = $f->getHarmonic($h);
		$this->assertEquals($expected, $actual);
	}
	public function provider_getHarmonicExeception() {
		return array(
			array(
				'fz' => 30,
				'h' => 2.5,
				'expected' => 'HarmonicIsNotPositiveIntegerException'
			),
			array(
				'fz' => 30,
				'h' => -3,
				'expected' => 'HarmonicIsNotPositiveIntegerException'
			),
			array(
				'fz' => -5,
				'h' => 1,
				'expected' => 'FrequencyIsNotPositiveNumberException'
			),
			array(
				'fz' => -5.5,
				'h' => 1.5,
				'expected' => 'FrequencyIsNotPositiveNumberException'
			),
		);
	}


}