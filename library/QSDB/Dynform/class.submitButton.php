<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2006-2007 Thomas Mueller <thomas.mueller@telemotive.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Plugin 'Telemotive Classes' for the 'tm_classes' extension.
 *
 * PHP version 5
 *
 * @category	misc
 * @package		TYPO3
 * @subpackage	tm_classes
 * @file		class.submitButton.php
 * @created		Feb 16, 2007
 * @version		1.1
 * @author		Wagner O. Wutzke
 * @author		Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright	2006-2007 Telemotive AG, Germany, Munich
 * @license		http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @see			http://www.phpclasses.org/browse/package/3743.html
 */

require_once "class.formField.php";

// {{{ submitButton

/**
 * Input Field type:submit
 *
 * @category	misc
 * @package		TYPO3
 * @subpackage	tm_classes
 * @file		class.submitButton.php
 * @author		Wagner O. Wutzke
 * @author		Thomas Mueller <thomas.mueller@telemotive.de> TMu
 * @copyright	2006-2007 Telemotive AG, Germany, Munich
 * @license		http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since		Version 1.1
 * @changes
 * 20071118		TMu	- Code reformat
 *					- no direct Output from render function, returns string
 */
class submitButton extends formField
{
	// {{{ __construct
	
	/**
	 * Default constructor for this class
	 *
	 * @access	public
	 * @param	string	$name			default = "submit"
	 * @param	string	$caption		default = "Submit"
	 * @param	string	$datatype		default = "", has no effect
	 * @param	boolean	$mandatory		default = false, has no effect
	 * @param	boolean	$validate		default = false, has no effect
	 * @param	mixed	$defaultValue	default = "", has no effect
	 * @param	boolean	$editable		default = false, has no effect
	 */
	public function __construct
		($name			= "submit",
		$caption		= "Submit",
		$datatype		= "",
		$mandatory		= false,
		$validate		= false,
		$defaultValue	= "",
		$editable		= false) 
	{
		$this->name			= (string)	$name;
		$this->caption		= (string)	$caption;
		$this->datatype		= (string)	$datatype;
		$this->mandatory	= (boolean)	$mandatory;
		$this->validate		= (boolean)	$validate;
		$this->defaultValue	= (string)	$defaultValue;
		$this->editable		= (boolean)	$editable;
	}
	
	// }}}
	// {{{ validate
	
	/**
	 * returns if the validation was correct
	 *
	 * @access	public
	 * @return	boolean
	 */
	public function validate()
	{
		return true;
	}
	
	// }}}
	// {{{ render
	
	/**
	 * @access	public
	 * @return	string	HTML-Output
	 */
	public function render()
	{
		$output = '';
		
		$output .= "\n\t<div class=\"dynformSubmitButton\">";
		$output .= "<input name=\"" . $this->name . "\" type=\"submit\" value=\"$this->caption\">";
		$output .= "\n\t</div>";
		
		return $output;
	}
	
	// }}}
}

// }}}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>