<?php
/*
  $Id: Great Categories v1.1 2005/01/01 20:20:00 willross Exp $
*/

  function tep_show_category($counter) {
    global $tree, $categories_string, $cPath_array, $aa;

    for ($i=0; $i<$tree[$counter]['level']; $i++) {


//      $categories_string .= "&nbsp;&nbsp;";
//            $categories_string .= "&nbsp;&nbsp;";
    }
/*    
//category start
   if ($tree[$counter]['level'] == 0)
	{
		if ($aa != 1)
		{
// commented out	
//		$categories_string .= "<hr noshade size=1>";
  $categories_string .= '<br />';
	    }
		else
		{$aa=1;}

	}



// display category name
    // $categories_string .= $foo[$counter]['name'];

	if ($ma_podkategorie) {
        if (isset($cPath_array) && in_array($counter, $cPath_array)) {
        // display category name
        $categories_string .= '<table class="categ" width="100%"><tr><td class="categ" nowrap>' . tep_image_t( 'gfx/a_cat.gif', '*') . "&nbsp;</td>";
        } else {
        // display category name
        $categories_string .= '<table class="categ" width="100%"><tr><td class="categ" nowrap>' .tep_image_t( 'gfx/a_cat.gif', '*') . "&nbsp;</td>";
        }
    } elseif ($tree[$counter]['level'] == 0) { // jesli glowne kategorie bez subkategorii
        if (isset($cPath_array) && in_array($counter, $cPath_array)) {
        // display category name
        $categories_string .= '<table class="categ" width="100%"><tr><td class="categ" nowrap>' . tep_image_t( 'gfx/a_cat.gif', '*') . "&nbsp;</td>";
        } else {
        // display category name
        $categories_string .= '<table class="categ" width="100%"><tr><td class="categ" nowrap>' .tep_image_t( 'gfx/a_cat.gif', '*') . "&nbsp;</td>";
        }	
    } else {
    $categories_string .= '<table class="categ" width="100%"><tr><td class="categ" nowrap>&nbsp;&nbsp;&nbsp;&nbsp;' .tep_image_t( 'gfx/a_cat.gif', '*') . "</td>";
    }
*/
	$level = '';
	for($i=0; $i < $tree[$counter]['level']; $i++) {
		$level .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
    $ma_podkategorie = tep_has_category_subcategories($counter);

	$categories_string .= '<div class="categ">';

    $categories_string .= '<a href="';

    if ($tree[$counter]['parent'] == 0) {
      $cPath_new = 'cPath=' . $counter;
    } else {
      $cPath_new = 'cPath=' . $tree[$counter]['path'];
    }

    $categories_string .= tep_href_link(FILENAME_DEFAULT, $cPath_new);
    
//    if (isset($cPath_array) && in_array($counter, $cPath_array)) {
		$categories_string .= '" class="categ">'.$level.tep_image_t( 'gfx/a_cat.gif', '*');
//	} else {
//		$categories_string .= '" class="categ">'.$level.tep_image_t( 'gfx/a_cat.gif', '*');
//	}

    if (isset($cPath_array) && in_array($counter, $cPath_array)) {
      $categories_string .= '<span class="textO"><b>';
    }

    //category name
    $categories_string .= $tree[$counter]['name'];



    if (isset($cPath_array) && in_array($counter, $cPath_array)) {
      $categories_string .= '</b></span>';
    }



    if (SHOW_COUNTS == 'true') {
      $products_in_category = tep_count_products_in_category($counter);
      if ($products_in_category > 0) {
        $categories_string .= '&nbsp;(' . $products_in_category . ')';
      }
    }

    $categories_string .= '</a>';

	$categories_string .= '</div>';

	$categories_string .= '<div style="width:100%">'.tep_image_t('gfx/sep_bc.gif').'</div>';

	if ($tree[$counter]['next_id'] != false) {	
       tep_show_category($tree[$counter]['next_id']);
    }
  }
?>
<!-- categories //-->

          <tr>
            <td class="borC">
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => BOX_HEADING_CATEGORIES);
  new infoBoxHeading($info_box_contents, false, false);

  $categories_string = '';
  $tree = array();

  $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and c.categories_id > '0' and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
  
  while ($categories = tep_db_fetch_array($categories_query))  {
    $tree[$categories['categories_id']] = array('name' => $categories['categories_name'],
                                        'parent' => $categories['parent_id'],
                                        'level' => 0,
                                        'path' => $categories['categories_id'],
                                        'next_id' => false);

	if (isset($parent_id)) {
      $tree[$parent_id]['next_id'] = $categories['categories_id'];
    }

    $parent_id = $categories['categories_id'];

    if (!isset($first_element)) {
      $first_element = $categories['categories_id'];
    }
  }

  //------------------------
  if (tep_not_null($cPath)) {
	$new_path = '';
    reset($cPath_array);
    while (list($key, $value) = each($cPath_array)) {
      unset($parent_id);
      unset($first_id);

	  $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$value . "' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");

      $category_check = tep_db_num_rows($categories_query);
	  $new_path .= $value;
      while ($row = tep_db_fetch_array($categories_query)) {
        $tree[$row['categories_id']] = array('name' => $row['categories_name'],
                                            'parent' => $row['parent_id'],
                                            'level' => $key+1,
                                            'path' => $new_path . '_' . $row['categories_id'],
                                            'next_id' => false);

        if (isset($parent_id)) {
          $tree[$parent_id]['next_id'] = $row['categories_id'];
        }

        $parent_id = $row['categories_id'];

        if (!isset($first_id)) {
          $first_id = $row['categories_id'];
        }

        $last_id = $row['categories_id'];
      }
      if ($category_check != 0) {
        $tree[$last_id]['next_id'] = $tree[$value]['next_id'];
        $tree[$value]['next_id'] = $first_id;
      }

             $new_path .= '_';
    }
  }

  tep_show_category($first_element);
  if (ALLOW_QUICK_SEARCH_DESCRIPTION == 'true') {
    $param = '<input type="hidden" name="search_in_description" value="1">';
  } else {
      $param = '';
  }
  $hide = tep_hide_session_id();

  $info_box_contents = array();
  $info_box_contents[] = array('text' => $categories_string.'<br />');
/*
  $info_box_contents[] = array('form' => '<br><form name="quick_find" method="get" action="' . tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false) . '">', 'align' => 'center', 'text' => $hide . $param . '<input type="text" name="keywords" size="15" maxlength="30" value="' . htmlspecialchars(StripSlashes(@$HTTP_GET_VARS["keywords"])) . '"><br>' . tep_image_submit('button_search.gif', BOX_HEADING_SEARCH). '<br />');
  //<a href="' . tep_href_link(FILENAME_ADVANCED_SEARCH) .'">'.BOX_SEARCH_ADVANCED_SEARCH.'</a>
*/
  new infoBoxC($info_box_contents);
?>
</td></tr>
<!-- categories_eof //-->
<tr><td class="sep"></td></tr>