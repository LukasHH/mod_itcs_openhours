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

// No direct access to this file
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;

/**
 * Script file of the Itcs OpenHours module for migration to the new version
 * https://docs.joomla.org/J4.x:Creating_a_Simple_Module#Creating_script.php
 */
class mod_Itcs_OpenhoursInstallerScript
{
	
    /**
     * Function called before extension installation/update/removal procedure commences
     *
     * @param   string            $type    The type of change (install, update or discover_install, not uninstall)
     * @param   InstallerAdapter  $parent  The class calling this method
     *
     * @return  boolean  True on success
     */
    function preflight($type, $parent)
	{	
		$db = Factory::getDbo();
		$msg = ''; // Message

		$query = $db->getQuery(true);
		$query->select($db->quoteName('manifest_cache'));
		$query->from($db->quoteName('#__extensions'));
		$query->where($db->quoteName('element') . ' = ' . $db->quote('mod_itcs_openhours'));
		$db->setQuery($query);
	
		if($result = $db->loadResult()){
			$res = json_decode($result);
			
			//Check installed version
			if (version_compare($res->version, '2.0', '<')){
				
				//Request used modules
				$query = $db->getQuery(true);
				$query->select($db->quoteName(array('id','params')));
				$query->from($db->quoteName('#__modules'));
				$query->where($db->quoteName('module') . ' = ' . $db->quote('mod_itcs_openhours'));
			
				$db->setQuery($query);
				$row = $db->loadAssocList();

				// Update Parameters
				if($row = $db->loadAssocList()){

					foreach($row AS $i){		

						$p = json_decode($i['params']);
						$new_p = new stdClass();
				
						$new_p->icon = $p->icon;
						$new_p->color = $p->color;
						$new_p->open_header = $p->open_header;
						$new_p->close_time = $p->close_time;
						$new_p->open_text = $p->open_text;
						$new_p->close_text = $p->close_text;
						$new_p->week_start = $p->week_start;
						$new_p->mytimezone = $p->mytimezone;
						$new_p->tz_show = $p->tz_show;
				
						$new_p->weekdays = new stdClass();
						$new_p->weekdays->weekday1 = $p->day1;
						$new_p->weekdays->weekday1_active = $p->day1_active;
						$new_p->weekdays->weekday1_times = new stdClass();
						$new_p->weekdays->weekday1_times->weekday1_from = $p->day1_from;
						$new_p->weekdays->weekday1_times->weekday1_to = $p->day1_to;
				
						$new_p->weekdays->weekday2 = $p->day2;
						$new_p->weekdays->weekday2_active = $p->day2_active;
						$new_p->weekdays->weekday2_times = new stdClass();
						$new_p->weekdays->weekday2_times->weekday2_from = $p->day2_from;
						$new_p->weekdays->weekday2_times->weekday2_to = $p->day2_to;
				
						$new_p->weekdays->weekday3 = $p->day3;
						$new_p->weekdays->weekday3_active = $p->day3_active;
						$new_p->weekdays->weekday3_times = new stdClass();
						$new_p->weekdays->weekday3_times->weekday3_from = $p->day3_from;
						$new_p->weekdays->weekday3_times->weekday3_to = $p->day3_to;
				
						$new_p->weekdays->weekday4 = $p->day4;
						$new_p->weekdays->weekday4_active = $p->day4_active;
						$new_p->weekdays->weekday4_times = new stdClass();
						$new_p->weekdays->weekday4_times->weekday4_from = $p->day4_from;
						$new_p->weekdays->weekday4_times->weekday4_to = $p->day4_to;
				
						$new_p->weekdays->weekday5 = $p->day5;
						$new_p->weekdays->weekday5_active = $p->day5_active;
						$new_p->weekdays->weekday5_times = new stdClass();
						$new_p->weekdays->weekday5_times->weekday5_from = $p->day5_from;
						$new_p->weekdays->weekday5_times->weekday5_to = $p->day5_to;
				
						$new_p->weekdays->weekday6 = $p->day6;
						$new_p->weekdays->weekday6_active = $p->day6_active;
						$new_p->weekdays->weekday6_times = new stdClass();
						$new_p->weekdays->weekday6_times->weekday6_from = $p->day6_from;
						$new_p->weekdays->weekday6_times->weekday6_to = $p->day6_to;
				
						$new_p->weekdays->weekday7 = $p->day7;
						$new_p->weekdays->weekday7_active = $p->day7_active;
						$new_p->weekdays->weekday7_times = new stdClass();
						$new_p->weekdays->weekday7_times->weekday7_from = $p->day7_from;
						$new_p->weekdays->weekday7_times->weekday7_to = $p->day7_to;
				
						$new_p->layout = $p->layout;
						$new_p->moduleclass_sfx = $p->moduleclass_sfx;
						$new_p->cache = $p->cache;
						$new_p->cache_time = $p->cache_time;
						$new_p->cachemode = $p->cachemode;
						$new_p->style = $p->style;
						$new_p->module_tag = $p->module_tag;
						$new_p->bootstrap_size = $p->bootstrap_size;
						$new_p->header_tag = $p->header_tag;
						$new_p->header_class = $p->header_class;
						
						// Update the params for new version
						$object = new stdClass();
						$object->id = $i['id'];
						$object->params = json_encode($new_p);
						$result = Factory::getDbo()->updateObject('#__modules', $object, 'id');

						$msg .= '<br><i class="icon icon-ok"></i>Parameters for Modul with ID: '.$i['id'].' was updated';
					}
				}

				// Delete old language files
				if(File::exists(JPATH_ROOT.'/language/de-DE/de-DE.mod_itcs_openhours.ini')){			
					if(File::delete(JPATH_ROOT.'/language/de-DE/de-DE.mod_itcs_openhours.ini')){
						$msg .= '<br><i class="icon icon-ok"></i>Old de-DE language file deleted';
					}
				}
			
				if(File::exists(JPATH_ROOT.'/language/en-GB/en-GB.mod_itcs_openhours.ini')){			
					if(File::delete(JPATH_ROOT.'/language/en-GB/en-GB.mod_itcs_openhours.ini')){
						$msg .= '<br><i class="icon icon-ok"></i>Old en-GB language file deleted';
					}					
				}

				if(File::exists(JPATH_ROOT.'/modules/mod_itcs_openhours/assets/css/raleway-v12-latin.css')){			
					if(File::delete(JPATH_ROOT.'/modules/mod_itcs_openhours/assets/css/raleway-v12-latin.css')){
						$msg .= '<br><i class="icon icon-ok"></i>Font CSS file deleted';
					}					
				}
				
				if(Folder::exists(JPATH_ROOT.'/modules/mod_itcs_openhours/assets/fonts/raleway-v12-latin')){			
					if(Folder::delete(JPATH_ROOT.'/modules/mod_itcs_openhours/assets/fonts/raleway-v12-latin')){
						$msg .= '<br><i class="icon icon-ok"></i>Font files deleted';
					}					
				}
			}
		}

		// Output Message
		if(!empty($msg)){
			echo '<div class="alert alert-info span6 offset3">';
			echo '<p><strong>'.$type.'</strong></p>';
			echo '<p>The module with parameters were migrated from '.$res->version.' to the new version.</p>';
			echo '<p>'.$msg.'</p>';
			echo '</div>';
		}
		
		return true;
	}

}