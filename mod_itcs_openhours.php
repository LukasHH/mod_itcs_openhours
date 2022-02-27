<?php
/**
 * mod_itcs_openhours - CSS3 based Module by it-conserv.de
 * CSS Style is a free resource from http://littlesnippets.net/
 * ------------------------------------------------------------------------
 * @package     mod_itcs_openhours
 * @author      it-conserv.de
 * @copyright   2022 it-conserv.de
 * @license     GNU/GPLv3 <http://www.gnu.org/licenses/gpl-3.0.de.html>
 * @link        https://it-conserv.de
 * ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die;

JLoader::registerNamespace('ITCS\\Module\\ItcsOpenHours\\Site', __DIR__ , false, false, 'psr4');

use Joomla\CMS\Helper\ModuleHelper;
use \Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use \Joomla\CMS\Date\Date;
use Joomla\CMS\Language\Text;
use ITCS\Module\ItcsOpenHours\Site\ItcsOpenHoursHelper;

$uniqid			= $module->id;
$icon			= $params->get('icon');
$color			= $params->get('color', 1);
$open_text		= $params->get('open_text');
$close_text		= $params->get('close_text');
$open_header	= $params->get('open_header');
$close_time		= $params->get('close_time');
$week_start		= $params->get('week_start');

//************************
// joomla time
$jdate 		= new Date('now',new DateTimeZone(Factory::getConfig()->get('offset'))); // A.M. time, in GMT timezone
$akt_time 	= $jdate->format('d.m.Y e H:i P',true);
$tz_show 	= $params->get('tz_show');

// Timezone
$tz			= (empty($params->get('mytimezone'))) ? Factory::getConfig()->get('offset'):$params->get('mytimezone');
$timezone	= Factory::getUser()->getTimezone();
$jdate 		= new Date('now', new DateTimeZone($tz)); // A.M. time, in GMT timezone

$new_time 	= $jdate->format('d.m.Y e H:i P',true);
$jetzt		= $jdate->format('d.m.Y H:i',true);

// Ausgabe
$zus = '<div class="alert alert-info"><strong>Joomla time</strong><br />'.$akt_time.'</div>'; 								//--> aktuelle Datum/Zeit mit Zeitzone
$zus .= '<div class="alert alert-warning"><strong>Selected time zone</strong><br />'.$params->get('mytimezone').'</div>'; 	//--> gewählte Zeitzone
$zus .= '<div class="alert alert-success"><strong>Time in this module</strong><br />'.$new_time.'</div>';					//--> neue Datum/Zeit mit Zeitzone

// Modal Button
$button  = '
	<button 
		class="btn btn-primary btn-sm"
		data-bs-toggle="modal" 
		data-bs-target="#ohmod'.$uniqid.'"
		data-bs-title="'.Text::_('OH_TIMES').'"
		data-bs-action="showTimesModal"
		onclick="return false;"
	>
	<span class="icon-clock" aria-hidden="true"></span> '. Text::_('OH_TIMES_BUTTON') .' 
	</button>
';

$button .= HTMLHelper::_(
	'bootstrap.renderModal',
	'ohmod'.$uniqid,
	array(
		'modal-dialog-scrollable' => true,
		'title'  => Text::_('OH_TIMES'),
		'footer' => '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">'.Text::_('JCLOSE').'</button>'
	),
		'<div id="modal-body">'.$zus.'</div>'
);

//************************

$open_desc ='<p class="dopen">'.$open_text.'</p>';
$close_desc ='<p class="dclose">'.$close_text.'</p>';

$desc = 0;
$desc_open_desc='';

/* Weekday Times */
for ($i = 1; $i < 8; $i++){
	$open_days[] = array(
		$params->get('weekdays')->{'weekday'.$i},
		$params->get('weekdays')->{'weekday'.$i.'_active'},
		$params->get('weekdays')->{'weekday'.$i.'_times'}->{'weekday'.$i.'_from'},
		$params->get('weekdays')->{'weekday'.$i.'_times'}->{'weekday'.$i.'_to'},
	);
}

$weekdays  = ItcsOpenHoursHelper::weekdays($open_days, $week_start, $tz);

// Load CSS/JS
$document 			= Factory::getDocument();
$document->addStyleSheet(URI::base(true) . '/modules/mod_itcs_openhours/assets/css/ionicons.min.css' );
$document->addStylesheet(URI::base(true) . '/modules/mod_itcs_openhours/assets/css/mod_itcs_openhours_style.css');

require ModuleHelper::getLayoutPath('mod_itcs_openhours', $params->get('layout', 'default'));