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

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use \Joomla\CMS\Date\Date;
 
class JFormFieldServertime extends FormField
{

 protected $type = 'servertime';
 
  protected function getLabel()
 {
	return parent::getLabel();
 }
 
 
 protected function getInput()
 {
 	$class1 = 'label label-info';
	$class2 = 'label label-success';
	$style	='padding:5px 10px; font-size: 13px;';
	
	$moduleParamsMyTimezone = $this->form->getValue('mytimezone', 'params');
	$tz		= (empty($moduleParamsMyTimezone))?Factory::getConfig()->get('offset'):$moduleParamsMyTimezone;
	$jdate 		= new Date('now',new DateTimeZone($tz)); // A.M. time, in GMT timezone
	
	return  '<span class="'.$class1.'" style="'.$style.'">'.$jdate->format("d.m.Y",true).'</span>
			<span class="'.$class2.'" style="'.$style.'">'.$jdate->format("H:i",true).'</span>
			<span style="'.$style.'">'.$jdate->format("e P",true).'</span>';
 }
 
}