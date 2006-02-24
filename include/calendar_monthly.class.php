<?php
// +-----------------------------------------------------------------------+
// | PhpWebGallery - a PHP based picture gallery                           |
// | Copyright (C) 2003-2006 PhpWebGallery Team - http://phpwebgallery.net |
// +-----------------------------------------------------------------------+
// | branch        : BSF (Best So Far)
// | file          : $RCSfile$
// | last update   : $Date: 2006-01-27 02:11:43 +0100 (ven, 27 jan 2006) $
// | last modifier : $Author: rvelices $
// | revision      : $Revision: 1014 $
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+

include_once(PHPWG_ROOT_PATH.'include/calendar_base.class.php');

define ('CYEAR',  0);
define ('CMONTH', 1);
define ('CDAY',   2);

/**
 * Monthly calendar style (composed of years/months and days)
 */
class Calendar extends CalendarBase
{

/**
 * Generate navigation bars for category page
 * @return boolean false to indicate that thumbnails
 * where not included here, true otherwise
 */
function generate_category_content($url_base, $view_type)
{
  global $lang, $conf;

  $this->url_base = $url_base;

  if ($view_type==CAL_VIEW_CALENDAR)
  {
    if ( count($this->date_components)==0 )
    {//case A: no year given - display all years+months
      if ($this->build_global_calendar())
        return true;
    }

    if ( count($this->date_components)==1 )
    {//case B: year given - display all days in given year
      if ($this->build_year_calendar())
      {
        if ( $conf['calendar_multi_bar'] )
          $this->build_nav_bar2(CYEAR, 'YEAR'); // years
        return true;
      }
    }

    if ( count($this->date_components)==2 )
    {//case C: year+month given - display a nice month calendar
      $this->build_month_calendar();
      if ( $conf['calendar_multi_bar'] )
      {
        $this->build_nav_bar2(CYEAR, 'YEAR'); // years
      }
      if (count($this->date_components)>=1 and
          ( $conf['calendar_multi_bar'] or count($this->date_components)==1 ) )
      {
        $this->build_nav_bar2(CMONTH, 'MONTH', $lang['month']); // month
      }
      return true;
    }
  }

  if ($view_type==CAL_VIEW_LIST or count($this->date_components)==3)
  {
    if ( $conf['calendar_multi_bar'] or count($this->date_components)==0 )
    {
      $this->build_nav_bar2(CYEAR, 'YEAR'); // years
    }
    if ( count($this->date_components)>=1 and
        ( $conf['calendar_multi_bar'] or count($this->date_components)==1 )
       )
    {
      $this->build_nav_bar2(CMONTH, 'MONTH', $lang['month']); // month
    }
    if ( count($this->date_components)>=2 )
    {
      $this->build_nav_bar2(CDAY, 'DAYOFMONTH' ); // days
    }
  }
  return false;
}


/**
 * Returns a sql where subquery for the date field
 * @param int max_levels return the where up to this level
 * (e.g. 2=only year and month)
 * @return string
 */
function get_date_where($max_levels=3)
{
  $date = $this->date_components;
  while (count($date)>$max_levels)
  {
    array_pop($date);
  }
  $res = '';
  if (isset($date[CYEAR]) and $date[CYEAR]!='any')
  {
    $b = $date[CYEAR] . '-';
    $e = $date[CYEAR] . '-';
    if (isset($date[CMONTH]) and $date[CMONTH]!='any')
    {
      $b .= $date[CMONTH] . '-';
      $e .= $date[CMONTH] . '-';
      if (isset($date[CDAY]) and $date[CDAY]!='any')
      {
        $b .= $date[CDAY];
        $e .= $date[CDAY];
      }
      else
      {
        $b .= '01';
        $e .= '31';
      }
    }
    else
    {
      $b .= '01-01';
      $e .= '12-31';
      if (isset($date[CMONTH]) and $date[CMONTH]!='any')
      {
        $res .= ' AND MONTH('.$this->date_field.')='.$date[CMONTH];
      }
      if (isset($date[2]) and $date[2]!='any')
      {
        $res .= ' AND DAYOFMONTH('.$this->date_field.')='.$date[CDAY];
      }
    }
    $res = " AND $this->date_field BETWEEN '$b' AND '$e 23:59:59'" . $res;
  }
  else
  {
    $res = ' AND '.$this->date_field.' IS NOT NULL';
    if (isset($date[CMONTH]) and $date[CMONTH]!='any')
    {
      $res .= ' AND MONTH('.$this->date_field.')='.$date[CMONTH];
    }
    if (isset($date[CDAY]) and $date[CDAY]!='any')
    {
      $res .= ' AND DAYOFMONTH('.$this->date_field.')='.$date[CDAY];
    }
  }
  return $res;
}


function get_display_name()
{
  global $conf, $lang;
  $res = '';
  $url = $this->url_base;
  if ( isset($this->date_components[CYEAR]) )
  {
    $res .= $conf['level_separator'];
    $url .= $this->date_components[CYEAR].'-';
    $res .= 
      '<a href="'.$url.'">'
      .$this->get_date_component_label($this->date_components[CYEAR])
      .'</a>';
  }
  if ( isset($this->date_components[CMONTH]) )
  {
    $res .= $conf['level_separator'];
    $url .= $this->date_components[CMONTH].'-';
    $res .= 
      '<a href="'.$url.'">'
      .$this->get_date_component_label(
                     $this->date_components[CMONTH], 
                     $lang['month']
                    )
      .'</a>';
  }
  if ( isset($this->date_components[CDAY]) )
  {
    $res .= $conf['level_separator'];
    $url .= $this->date_components[CDAY].'-';
    $res .= 
      '<a href="'.$url.'">'
      .$this->get_date_component_label($this->date_components[CDAY])
      .'</a>';
  }

  return $res;
}


//--------------------------------------------------------- private members ---
function build_nav_bar2($level, $sql_func, $labels=null)
{
  parent::build_nav_bar($level, $sql_func, '', $labels);
}

function build_global_calendar()
{
  assert( count($this->date_components) == 0 );
  $query='SELECT DISTINCT(DATE_FORMAT('.$this->date_field.',"%Y%m")) as period,
            COUNT(id) as count';
  $query.= $this->inner_sql;
  $query.= $this->get_date_where();
  $query.= '
  GROUP BY period';

  $result = pwg_query($query);
  while ($row = mysql_fetch_array($result))
  {
    $y = substr($row['period'], 0, 4);
    $m = (int)substr($row['period'], 4, 2);
    if ( ! isset($items[$y]) )
    {
      $items[$y] = array('nb_images'=>0, 'children'=>array() );
    }
    $items[$y]['children'][$m] = $row['count'];
    $items[$y]['nb_images'] += $row['count'];
  }
  //echo ('<pre>'. var_export($items, true) . '</pre>');
  if (count($items)==1)
  {// only one year exists so bail out to year view
    list($y) = array_keys($items);
    $this->date_components[CYEAR] = $y;
    return false;
  }

  global $lang, $template;
  foreach ( $items as $year=>$year_data)
  {
    $url_base = $this->url_base.$year;

    $nav_bar = '<span class="calCalHead"><a href="'.$url_base.'">'.$year.'</a>';
    $nav_bar .= ' ('.$year_data['nb_images'].')';
    $nav_bar .= '</span><br>';

    $url_base .= '-';
    $nav_bar .= $this->get_nav_bar_from_items( $url_base, 
            $year_data['children'], null, 'calCal', false, $lang['month'] );

    $template->assign_block_vars( 'calendar.calbar',
         array( 'BAR' => $nav_bar)
         );
  }
  return true;
}

function build_year_calendar()
{
  assert( count($this->date_components) == 1 );
  $query='SELECT DISTINCT(DATE_FORMAT('.$this->date_field.',"%m%d")) as period,
            COUNT(id) as count';
  $query.= $this->inner_sql;
  $query.= $this->get_date_where();
  $query.= '
  GROUP BY period';

  $result = pwg_query($query);
  while ($row = mysql_fetch_array($result))
  {
    $m = (int)substr($row['period'], 0, 2);
    $d = substr($row['period'], 2, 2);
    if ( ! isset($items[$m]) )
    {
      $items[$m] = array('nb_images'=>0, 'children'=>array() );
    }
    $items[$m]['children'][$d] = $row['count'];
    $items[$m]['nb_images'] += $row['count'];
  }
  //echo ('<pre>'. var_export($items, true) . '</pre>');
  if (count($items)==1)
  { // only one month exists so bail out to month view
    list($m) = array_keys($items);
    $this->date_components[CMONTH] = $m;
    if (count($items[$m]['children'])==1)
    { // or even to day view if everything occured in one day
      list($d) = array_keys($items[$m]['children']);
      $this->date_components[CDAY] = $d;
    }
    return false;
  }
  global $lang, $template;
  foreach ( $items as $month=>$month_data)
  {
    $url_base = $this->url_base.$this->date_components[CYEAR].'-'.$month;

    $nav_bar = '<span class="calCalHead"><a href="'.$url_base.'">';
    $nav_bar .= $lang['month'][$month].'</a>';
    $nav_bar .= ' ('.$month_data['nb_images'].')';
    $nav_bar .= '</span><br>';

    $url_base .= '-';
    $nav_bar .= $this->get_nav_bar_from_items( $url_base, 
                     $month_data['children'], null, 'calCal', false );

    $template->assign_block_vars( 'calendar.calbar',
         array( 'BAR' => $nav_bar)
         );
  }
  return true;

}

function build_month_calendar()
{
  $query='SELECT DISTINCT(DATE_FORMAT('.$this->date_field.',"%d")) as period,
            COUNT(id) as count';
  $query.= $this->inner_sql;
  $query.= $this->get_date_where($this->date_components);
  $query.= '
  GROUP BY period';

  $result = pwg_query($query);
  while ($row = mysql_fetch_array($result))
  {
    $d = $row['period'];
    $items[$d] = $row['count'];
  }

  global $lang, $template;

  $template->assign_block_vars('thumbnails', array());
  $template->assign_block_vars('thumbnails.line', array());
  foreach ( $items as $day=>$nb_images)
  {
    $url_base = $this->url_base.
          $this->date_components[CYEAR].'-'.
          $this->date_components[CMONTH].'-'.$day;
    $this->date_components[CDAY]=$day;
    $query = '
SELECT file,tn_ext,path, DAYOFWEEK('.$this->date_field.')-1 as dw';
    $query.= $this->inner_sql;
    $query.= $this->get_date_where();
    $query.= '
  ORDER BY RAND()
  LIMIT 0,1';
    unset ( $this->date_components[CDAY] );

    $row = mysql_fetch_array(pwg_query($query));

    $thumbnail_src = get_thumbnail_src($row['path'], @$row['tn_ext']);
    $thumbnail_title = $lang['day'][$row['dw']] . ' ' . $day;
    $name = $thumbnail_title .' ('.$nb_images.')';

    $template->assign_block_vars(
        'thumbnails.line.thumbnail',
        array(
          'IMAGE'=>$thumbnail_src,
          'IMAGE_ALT'=>$row['file'],
          'IMAGE_TITLE'=>$thumbnail_title,
          'U_IMG_LINK'=>$url_base
         )
        );
    $template->assign_block_vars(
        'thumbnails.line.thumbnail.category_name',
        array(
          'NAME' => $name
          )
        );
  }
  return true;
}

}
?>