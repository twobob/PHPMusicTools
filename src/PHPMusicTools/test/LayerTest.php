<?php

require_once 'PHPMusicToolsTest.php';
require_once __DIR__.'/../classes/Layer.php';

class LayerTest extends PHPMusicToolsTest
{

protected function setUp(){
	}

	public function test_constructFromArray(){

		$input = array(
			'name' => 'Voice 1',
			'chords' => array(
				0 => array(
					'notes' => array(
						0 => array(
							'pitch' => array(
								'step' => 'C',
								'alter' => 1,
								'octave' => 4,
							),
							'rest' => false,
							'duration' => 4,
							'voice' => 1,
							'type' => 'eighth',
							'accidental' => 'sharp',
							'dot' => false,
							'tie' => true,
							'timeModification' => array(
								'actualNotes' => 3,
								'normalNotes' => 2,
							),
							'defaultX' => 3,
							'defaultY' => 1,
							'chord' => true,
							'notations' => array(
								0 => array(
									'notationType' => 'tuplet',
									'number' => 1,
									'type' => 'stop',
								),
								1 => array(
									'notationType' => 'slur',
									'type' => 'start',
									'number' => 1,
								)
							),
							'articulations' => array(
								0 => array('articulationType' => 'staccato'),
								1 => array(
									'articulationType' => 'accent',
									'defaultX' => -1,
									'defaultY' => -71,
									'placement' => 'below',
								),
							),
							'staff' => 1,
							'beams' => array(
								0 => array(
									'number' => 1,
									'type' => 'begin',
								),
								1 => array(
									'number' => 2,
									'type' => 'begin',
								)
							),
							'stem' => array(
								'defaultX' => 2,
								'defaultY' => 3,
								'direction' => 'up',
							)
						),
						1 => array(
							'pitch' => array(
								'step' => 'C',
								'alter' => 1,
								'octave' => 4,
							),
							'accidental' => array(
								'type' => 'double-sharp' // sharp, flat, natural, double-sharp, sharp-sharp, flat-flat, natural-sharp, natural-flat, quarter-flat, quarter-sharp, three- quarters-flat, and three-quarters-sharp
							),
							'rest' => false,
							'duration' => 4,
							'voice' => 1,
							'type' => 'eighth',
							'staff' => 1,
						)							)
				),
				1 => array(
					'notes' => array(
						0 => array(
							'accidental' => array(
								'courtesy' => true,
								'editorial' => null,
								'bracket' => false,
								'parentheses' => true,
								'size' => false,
								'type' => 'natural' // sharp, flat, natural, double-sharp, sharp-sharp, flat-flat, natural-sharp, natural-flat, quarter-flat, quarter-sharp, three- quarters-flat, and three-quarters-sharp
							)
						)
					)
				)
			)
		);

		$layer = \ianring\Layer::constructFromArray($input);

		$this->assertInstanceOf(\ianring\Layer::class, $layer);
			$this->assertEquals('Voice 1', $layer->name);
			$this->assertObjectHasAttribute('chords', $layer);
			$this->assertObjectHasAttribute('notes', $layer->chords[0]);
			$this->assertObjectHasAttribute('pitch', $layer->chords[0]->notes[0]);
			$this->assertInstanceOf(\ianring\Pitch::class, $layer->chords[0]->notes[0]->pitch);
			$this->assertEquals(false, $layer->chords[0]->notes[0]->rest);
			$this->assertEquals(4, $layer->chords[0]->notes[0]->pitch->octave);

			$this->assertInstanceOf(\ianring\TimeModification::class, $layer->chords[0]->notes[0]->timeModification);

			$this->assertInstanceOf(\ianring\Articulation::class, $layer->chords[0]->notes[0]->articulations[0]);
			$this->assertInstanceOf(\ianring\Articulation::class, $layer->chords[0]->notes[0]->articulations[1]);

			$this->assertInstanceOf(\ianring\NoteBeam::class, $layer->chords[0]->notes[0]->beams[0]);
			$this->assertEquals('begin', $layer->chords[0]->notes[0]->beams[0]->type);
			$this->assertEquals(1, $layer->chords[0]->notes[0]->beams[0]->number);
			$this->assertInstanceOf(\ianring\NoteBeam::class, $layer->chords[0]->notes[0]->beams[1]);
			$this->assertEquals(2, $layer->chords[0]->notes[0]->beams[1]->number);

			$this->assertEquals(false, $layer->chords[0]->notes[0]->rest);

			$this->assertInstanceOf(\ianring\Accidental::class, $layer->chords[1]->notes[0]->accidental);
			$this->assertEquals('natural', $layer->chords[1]->notes[0]->accidental->type);

	}


}
