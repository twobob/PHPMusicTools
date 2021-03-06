<?php
namespace ianring;
require_once 'PMTObject.php';

/**
 * NoteStem is a glyph that indicates that a note or rest's duration should be extended
 */
class NoteDot extends PMTObject
{

    var $types = array(
                  'single',
                  'double',
                  'star', // this one is special. See http://ianring.com/stardots/
                 );

}
