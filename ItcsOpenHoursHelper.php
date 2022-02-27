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

namespace ITCS\Module\ItcsOpenHours\Site;

// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Date\Date;
use Joomla\CMS\Uri\Uri;

//mod_itcs_openhours - mod_itcs_openhours
class ItcsOpenHoursHelper
{
	/**
	 * Check the normally Weekdays
	 * 
	 * @open_days	multiples Array with the standard times
	 * @week_start	(int) Start of the week (1=Monday, 0=Sunday)
	 * @tz			actual timezone
	 * 
	 */
	public static function weekdays($open_days, $week_start, $tz)
	{

		$now = new Date();
		$now->setTimezone(new \DateTimeZone($tz));

		$wtag 		= ($week_start == 1) ? $now->format("N", true) : $now->format("w", true); //actual weekday 1 = Mo-Su (1-7) and 0 = Su-Sa (0-6)
		$de			= $week_start;
		
		for ($i = 0; $i < 7; $i++){
			$open ="";
			$status = ($open_days[$i][1] == 1 ? 'open' : 'close');

			// Ermittlung des ersten bis letzten Tag der Woche, ausgehend vom aktuellen Tag
			$intv = ($wtag-$de-$i)*-1; 			// Ermittlung des Interval -2Tage oder +1Tag von heute
			$newDate = new \DateTime('now', new \DateTimeZone($tz));
			date_add($newDate, date_interval_create_from_date_string($intv.' days'));			

			// Check actual Day
			if ($wtag == $i + $de){

				// create datetimes
				$t1 = new \DateTime( (empty($open_days[$i][2])) ? '1970-01-01 00:00' : $open_days[$i][2], new \DateTimeZone($tz));
				$t2 = new \DateTime( (empty($open_days[$i][3])) ? '1970-01-01 00:00' : $open_days[$i][3], new \DateTimeZone($tz));

				// add 1 day when to time to the next day
				($t2 < $t1) ? $t2->add( new \DateInterval('P1D') ) : '';

				// check times
				if($now >= $t1 AND $now <= $t2 AND $open_days[$i][1] == 1){
					$open ='dopen';
				}
				else{
					$open ='dclose';
				}				
			}

			$weekdays[$i]['name'] = $open_days[$i][0];
			$weekdays[$i]['day'] = $newDate->format('d.m.Y H:i - l');
			$weekdays[$i]['intv'] = $intv;
			$weekdays[$i]['special_times'] = 0;
			$weekdays[$i]['class'] = $open;
			$weekdays[$i]['status'] = $status;
			$weekdays[$i]['time1_from'] = ($status == 'open') ? $open_days[$i][2] : '';
			$weekdays[$i]['time1_to'] = ($status == 'open') ? $open_days[$i][3] : '';
		
		}

		return $weekdays;
	}

}