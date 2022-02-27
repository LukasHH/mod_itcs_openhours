<?php
/*
# Yes/No switcher, compatible with Joomla 3 and 4
# ------------------------------------------------
# Author    it-conserv.de
# Copyright (C) 2016 it-conserv.de All Rights Reserved.
# License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# CSS Style is a free resource from http://littlesnippets.net/ 
# Websites: it-conserv.de
*/

// no direct access
defined('_JEXEC') or die;


//use Joomla\CMS\Form\FormField;
use Joomla\CMS\Form\FormHelper;

// Load the base form field class
FormHelper::loadFieldClass('radio');

 
class JFormFieldSwitcher extends JFormFieldRadio
{

	public function __construct($form = null)
	{
		if (version_compare(JVERSION, '3.999.999', 'gt'))
		{
			// Joomla 4.0 and later.
			$this->layout = 'joomla.form.field.radio.switcher';
		}
		else
		{
			// Joomla 3.x. Yes, 3.10 does have the layout but I am playing it safe.
			$this->layout = 'joomla.form.field.radio';
		}

		parent::__construct($form);
	}
 
}