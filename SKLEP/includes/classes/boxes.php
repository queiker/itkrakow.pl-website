<?php
/*
  $Id: boxes.php,v 1.33 2003/06/09 22:22:50 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/


// KONFIGURACJA BOXOW
define(BOX_ODSETP, 0);
// BOX_HEADING
define(WYMUS_NAROZNIKI, true);
define(BOX_IMG_LEFT, 'gfx/cl.png');
define(BOX_IMG_RIGHT, 'gfx/cr.png');
define(WYSOKOSC_BOX_HEAD, 20);
define(BOX_TLO_BEZ_NAROZNIKOW, 'background="images/gfx/box_head_top_standard.png"');
define(BOX_TLO_Z_NAROZNIKAMI, '');
// BOX_CONTENT
define(BOX_CONTENT_BORDER_LEFT_WIDTH,1);
define(BOX_CONTENT_BORDER_LEFT, 'bgcolor="#D0D0D0"');
define(BOX_CONTENT_BORDER_RIGHT_WIDTH,1);
define(BOX_CONTENT_BORDER_RIGHT, 'bgcolor="#D0D0D0"');
define(BOX_CONTENT_TLO, '');
// BOX_BOTTOM
define(BOX_BOTTOM_LEFT, 'gfx/box_standard.png');
define(BOX_BOTTOM_RIGHT, 'gfx/box_standard.png');
define(BOX_BOTTOM_TLO, 'bgcolor="#D0D0D0"');
define(BOX_BOTTOM_WIDTH, 1);



  class tableBox {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '2';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';



// class constructor
    function tableBox($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . tep_output_string($this->table_border) . '" width="' . tep_output_string($this->table_width) . '" cellspacing="' . tep_output_string($this->table_cellspacing) . '" cellpadding="' . tep_output_string($this->table_cellpadding) . '"';
      if (tep_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if (tep_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
            if (isset($contents[$i][$x]['text']) && tep_not_null($contents[$i][$x]['text'])) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && tep_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (tep_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td';
          if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (tep_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td>' . "\n";
        }

        $tableBox_string .= '  </tr>' . "\n";
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
  }


################################################################################

  class infoBox extends tableBox {
    function infoBox($contents) {

	  $info_box_contents = array();
	  $info_box_contents[] = array(
		  array(	
					'text' => tep_draw_separator('pixel_trans.gif', '1', '1'),
					'params' => 'width="' . BOX_CONTENT_BORDER_LEFT_WIDTH .'" ' . BOX_CONTENT_BORDER_LEFT 
				),
		  array(
					'text' => $this->infoBoxContents($contents),
					'params' => BOX_CONTENT_TLO
				),
		  array(	
					'text' => tep_draw_separator('pixel_trans.gif', '1', '1'),
					'params' => 'width="' . BOX_CONTENT_BORDER_RIGHT_WIDTH .'" ' . BOX_CONTENT_BORDER_RIGHT 
				),

		  );


//      $info_box_contents[] = array('text' => $this->infoBoxContents($contents));

      $this->table_cellpadding = '0';
//      $this->table_parameters = 'class="infoBox"';
      $this->tableBox($info_box_contents, true);

// ewentualne zaokraglenie
      $info_box_contents = array();
	  $info_box_contents[] = array(
		  array(
					'text' => tep_image_t(BOX_BOTTOM_LEFT),
		  			'params' => 'width="' . BOX_BOTTOM_WIDTH . '"'
				),
		  array(
					'text' => tep_draw_separator('pixel_trans.gif', '1', '1'),
					'params' => BOX_BOTTOM_TLO
				),
		  array(
					'text' => tep_image_t(BOX_BOTTOM_RIGHT),
		  			'params' => 'width="' . BOX_BOTTOM_WIDTH . '"'
				)
		  );

// przerwa pomiedzy boxami
//	  $info_box_contents[] = array('text' => tep_draw_separator('pixel_trans.gif', '1', BOX_ODSETP));

      $this->tableBox($info_box_contents, true);

    }

    function infoBoxContents($contents) {
      $this->table_cellpadding = '3';
//      $this->table_parameters = 'class="infoBoxContents"';
      $info_box_contents = array();
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => 'class="boxText"',
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }

################################################################################

  class infoBoxC extends tableBox {
    function infoBoxC($contents) {

	  $info_box_contents = array();
	  $info_box_contents[] = array(
		  array(	
					'text' => tep_draw_separator('pixel_trans.gif', '1', '1'),
					'params' => 'width="' . BOX_CONTENT_BORDER_LEFT_WIDTH .'" ' . BOX_CONTENT_BORDER_LEFT 
				),
		  array(
					'text' => $this->infoBoxContents($contents),
					'params' => BOX_CONTENT_TLO
				),
		  array(	
					'text' => tep_draw_separator('pixel_trans.gif', '1', '1'),
					'params' => 'width="' . BOX_CONTENT_BORDER_RIGHT_WIDTH .'" ' . BOX_CONTENT_BORDER_RIGHT 
				),

		  );


//      $info_box_contents[] = array('text' => $this->infoBoxContents($contents));

      $this->table_cellpadding = '0';
//      $this->table_parameters = 'class="infoBox"';
      $this->tableBox($info_box_contents, true);

// ewentualne zaokraglenie
      $info_box_contents = array();
	  $info_box_contents[] = array(
		  array(
					'text' => tep_image_t(BOX_BOTTOM_LEFT),
		  			'params' => 'width="' . BOX_BOTTOM_WIDTH . '"'
				),
		  array(
					'text' => tep_draw_separator('pixel_trans.gif', '1', '1'),
					'params' => BOX_BOTTOM_TLO
				),
		  array(
					'text' => tep_image_t(BOX_BOTTOM_RIGHT),
		  			'params' => 'width="' . BOX_BOTTOM_WIDTH . '"'
				)
		  );

// przerwa pomiedzy boxami
//	  $info_box_contents[] = array('text' => tep_draw_separator('pixel_trans.gif', '1', BOX_ODSETP));

      $this->tableBox($info_box_contents, true);

    }
 
    function infoBoxContents($contents) {
      $this->table_cellpadding = '0';
//      $this->table_parameters = 'class="infoBoxContents"';
      $info_box_contents = array();
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => 'class="boxText"',
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }
################################################################################

  class infoBoxClear extends tableBox {
    function infoBoxClear($contents) {

	  $info_box_contents = array();


      $info_box_contents[] = array('text' => $this->infoBoxContents($contents));

      $this->table_cellpadding = '0';
//      $this->table_parameters = 'class="infoBox"';
      $this->tableBox($info_box_contents, true);

    }

    function infoBoxContents($contents) {
      $this->table_cellpadding = '3';
//      $this->table_parameters = 'class="infoBoxContents"';
      $info_box_contents = array();
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => 'class="boxText"',
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }

################################################################################

  class infoBoxHeading extends tableBox {
    function infoBoxHeading($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
	  global $template;
      $this->table_cellpadding = '0';

	  if(WYMUS_NAROZNIKI)
		{
			$left_corner = true;
			$right_corner = true;
		}

      if ($left_corner == true) {
        $left_corner = tep_image_t(BOX_IMG_LEFT); 
      } else {
        $left_corner = tep_image_t('gfx/cc.png');
      }

      if ($right_arrow == true) {
        $right_arrow = '<a href="' . $right_arrow . '">' . tep_image_t('gfx/arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner == true) {
        $right_corner = $right_arrow . tep_image_t(BOX_IMG_RIGHT);
      } else {
        $right_corner = $right_arrow . tep_draw_separator('pixel_trans.gif', '11', WYSOKOSC_BOX_HEAD);
      }

      $info_box_contents = array();

// aktywacja lewego i prawego naroznika
	  if(WYMUS_NAROZNIKI)
		{
		  $info_box_contents[] = array(array('params' => 'height="' . WYSOKOSC_BOX_HEAD . '" class="infoBoxHeading"',
											 'text' => $left_corner),
									   array('params' => 'width="100%" height="' . WYSOKOSC_BOX_HEAD . '" class="infoBoxHeading" ' . BOX_TLO_Z_NAROZNIKAMI,
											 'text' => $contents[0]['text']),
									   array('params' => 'height="' . WYSOKOSC_BOX_HEAD . '" class="infoBoxHeading" nowrap',
											 'text' => $right_corner));

		}
		else
		{


	  $info_box_contents[] = array( array('params' => 'height="' . WYSOKOSC_BOX_HEAD . '" width="1" class="infoBoxHeading" ' . BOX_BOTTOM_TLO,
										 'text' => tep_draw_separator('pixel_trans.gif', '1', '1')
									),
									array(	'params' => 'width="100%" height="' . WYSOKOSC_BOX_HEAD . '" class="infoBoxHeading"  ' . BOX_TLO_BEZ_NAROZNIKOW . ' align="center"',
										    'text' => $contents[0]['text']),
									array('params' => 'height="' . WYSOKOSC_BOX_HEAD . '" width="1" class="infoBoxHeading" ' . BOX_BOTTOM_TLO,
										 'text' => tep_draw_separator('pixel_trans.gif', '1', '1')
									)
								  );
		}
	  $this->tableBox($info_box_contents, true);
    }
  }


################################################################################


  class infoBoxHeadingO extends tableBox {
    function infoBoxHeadingO($contents, $left_corner = true, $right_corner = true, $right_arrow = false) {
	  global $template;
      $this->table_cellpadding = '0';

	  if(WYMUS_NAROZNIKI)
		{
			$left_corner = true;
			$right_corner = true;
		}

      if ($left_corner == true) {
        $left_corner = tep_image_t('gfx/cl2.png'); 
      } else {
        $left_corner = tep_image_t('gfx/cc2.png');
      }

      if ($right_arrow == true) {
        $right_arrow = '<a href="' . $right_arrow . '">' . tep_image_t('gfx/arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner == true) {
        $right_corner = $right_arrow . tep_image_t('gfx/cr2.png');
      } else {
        $right_corner = $right_arrow . tep_draw_separator('pixel_trans.gif', '11', WYSOKOSC_BOX_HEAD);
      }

      $info_box_contents = array();

// aktywacja lewego i prawego naroznika
	  if(WYMUS_NAROZNIKI)
		{
		  $info_box_contents[] = array(array('params' => 'height="' . WYSOKOSC_BOX_HEAD . '" class="infoBoxHeadingO"',
											 'text' => $left_corner),
									   array('params' => 'width="100%" height="' . WYSOKOSC_BOX_HEAD . '" class="infoBoxHeadingO" ' . BOX_TLO_Z_NAROZNIKAMI,
											 'text' => $contents[0]['text']),
									   array('params' => 'height="' . WYSOKOSC_BOX_HEAD . '" class="infoBoxHeadingO" nowrap',
											 'text' => $right_corner));

		}
		else
		{


	  $info_box_contents[] = array( array('params' => 'height="' . WYSOKOSC_BOX_HEAD . '" width="1" class="infoBoxHeadingO" ' . BOX_BOTTOM_TLO,
										 'text' => tep_draw_separator('pixel_trans.gif', '1', '1')
									),
									array(	'params' => 'width="100%" height="' . WYSOKOSC_BOX_HEAD . '" class="infoBoxHeadingO"  ' . BOX_TLO_BEZ_NAROZNIKOW . ' align="center"',
										    'text' => $contents[0]['text']),
									array('params' => 'height="' . WYSOKOSC_BOX_HEAD . '" width="1" class="infoBoxHeadingO" ' . BOX_BOTTOM_TLO,
										 'text' => tep_draw_separator('pixel_trans.gif', '1', '1')
									)
								  );
		}
	  $this->tableBox($info_box_contents, true);
    }
  }


################################################################################



  class contentBox extends tableBox {
    function contentBox($contents) {
      $info_box_contents = array();
//      $info_box_contents[] = array('text' => $this->contentBoxContents($contents));


	  $info_box_contents = array();
	  $info_box_contents[] = array(
		  array(	
					'text' => tep_draw_separator('pixel_trans.gif', '1', '1'),
					'params' => 'width="' . BOX_CONTENT_BORDER_LEFT_WIDTH .'" ' . BOX_CONTENT_BORDER_LEFT 
				),
		  array(
					'text' => $this->contentBoxContents($contents),
					'params' => BOX_CONTENT_TLO
				),
		  array(	
					'text' => tep_draw_separator('pixel_trans.gif', '1', '1'),
					'params' => 'width="' . BOX_CONTENT_BORDER_RIGHT_WIDTH .'" ' . BOX_CONTENT_BORDER_RIGHT 
				),

		  );

      $this->table_cellpadding = '0';
//      $this->table_parameters = 'class="infoBox"';
      $this->tableBox($info_box_contents, true);


// ewentualne zaokraglenie
      $info_box_contents = array();
	  $info_box_contents[] = array(
		  array(
					'text' => tep_image_t(BOX_BOTTOM_LEFT),
		  			'params' => 'width="' . BOX_BOTTOM_WIDTH . '"'
				),
		  array(
					'text' => tep_draw_separator('pixel_trans.gif', '1', '1'),
					'params' => BOX_BOTTOM_TLO
				),
		  array(
					'text' => tep_image_t(BOX_BOTTOM_RIGHT),
		  			'params' => 'width="' . BOX_BOTTOM_WIDTH . '"'
				)
		  );


      $this->tableBox($info_box_contents, true);

    }




    function contentBoxContents($contents) {
      $this->table_cellpadding = '0';
      $this->table_parameters = 'class="infoBoxContents"';
      return $this->tableBox($contents);
    }
  }



################################################################################

  class contentBoxHeading extends tableBox {
    function contentBoxHeading($contents) {
      $this->table_width = '100%';
      $this->table_cellpadding = '0';

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'height="' . WYSOKOSC_BOX_HEAD . '" class="infoBoxHeading"',
                                         'text' => tep_image_t(BOX_IMG_LEFT)),
                                   array('params' => 'height="' . WYSOKOSC_BOX_HEAD . ' "class="infoBoxHeading" width="100%"',
                                         'text' => $contents[0]['text']),
                                   array('params' => 'height="' . WYSOKOSC_BOX_HEAD . '" class="infoBoxHeading"',
                                         'text' => tep_image_t('gfx/cc.png')));

      $this->tableBox($info_box_contents, true);
    }
  }


################################################################################

  class errorBox extends tableBox {
    function errorBox($contents) {
      $this->table_data_parameters = 'class="errorBox"';
      $this->tableBox($contents, true);
    }
  }

  class productListingBox extends tableBox {
    function productListingBox($contents) {
      $this->table_parameters = 'class="productListing"';
      $this->tableBox($contents, true);
    }
  }

  class imagesBox extends tableBox {      
    function imagesBox($contents) {        
      $info_box_contents = array();        
      $info_box_contents[] = array('text' => $this->imagesBoxContents($contents));        
      $this->table_cellpadding = '1';        
      $this->tableBox($info_box_contents, true);      
  }
    function imagesBoxContents($contents) {
      $this->table_cellpadding = '4';
      $this->table_parameters = 'class="imagesBoxContents"';
      return $this->tableBox($contents);
    }
  }
?>