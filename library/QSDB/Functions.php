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
 * @file		functions.php
 * @author		Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright	2006-2007 Telemotive AG, Germany, Munich
 * @license		http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 */

// {{{ QSDB_Functions

/**
 * global Functions
 *
 * This Class helps to manage global Functions for the Classes 'tm_dl', 'tebay',
 * 'tm_minijoboffers' and 'tm_qsdb'.
 * A lot of Information and Functions are using Stored Procedures and Triggers from
 * MySQL 5.x.
 * All Functions inside this Class are static.
 *
 * @category	misc
 * @package		TYPO3
 * @subpackage	tm_classes
 * @file		functions.php
 * @author		Thomas Mueller <thomas.mueller@telemotive.de> TMu
 * @copyright	2006-2007 Telemotive AG, Germany, Munich
 * @license		http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @version		0.0.14
 * @changes
 * 20071112		TMu	- new Function getTCA
 */
class QSDB_Functions
{
	// {{{ properties
	
	/**
     * holds the javascript object
	 * used in Function renderWizard only
     *
     * @var			object
	 * @access		private
	 * @static
     */
	private static $jsObj = null;
	
	/**
     * type of jsObj (true = tceforms; false = doc)
	 * used in Function renderWizard only
     *
     * @var			boolean
	 * @access		private
	 * @static
     */
	private static $jsObjType = true;
	
	/**
     * contains extension configuration
	 * used in Function renderWizard only
     *
     * @var			array
	 * @access		private
	 * @static
     */
	private static $extConfig = array();
	
	/**
     * TYPO3 4.1 detection flag
	 * used in Function renderWizard only
     *
     * @var			boolean
	 * @access		private
	 * @static
     */
	private static $typo41 = false;
	
	// }}} properties
	// {{{ getProdId
	
	/**
	 * Function		getProdId
	 *
	 * searches a Product-ID for a Product with given Serial-Number and
	 * Article-Number
	 * uses a Stored Procedure
	 *
	 * @param	integer	$serNr:			the Serial Number
	 * @param	integer	$artNr:			the Article Number
	 * @param	boolean	$show_message:	(optional) a Flag
	 *									if TRUE, Error messages are displayed
	 * @return	integer the Product ID
	 *
	 * @access	public
	 * @static
	 */
	public static function getProdId($serNr, $artNr, $show_message = true)
	{
		$show_message	= (boolean) $show_message;
		$serNr			= self::extractNumber($serNr);
		$artNr			= self::extractNumber($artNr);
		
		$query	= "SELECT QSDB.getProdId($serNr, $artNr) AS ProdID";
		
		$result	= $GLOBALS['dbObj']->sql_query($query);
		//$anz	= $GLOBALS['dbObj']->sql_num_rows($result);
		$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
		
		$prod_id = (int) $res['ProdID'];
		
		if ($prod_id < 0) {
			//$prod_id holds error code
			
			if ($show_message) {
				//show error message here
				//-> do not give back error code
				echo "<p>".self::get_error($prod_id).'</p>';
				return 0;
			} else {
				//do not show error message here
				//-> give back error code
				return $prod_id;
			}
		}
		
		return (int) self::extractNumber($prod_id);
	}
	
	// }}} getProdId
	// {{{ getSerArtNr
	
	/**
	 * Function		getSerArtNr
	 *
	 * searches a Serial-Number and Article-Number for a given Product-ID
	 *
	 * @param	integer	$prod_id:		the Product ID
	 * @param	boolean	$show_message:	(optional) a Flag
	 *									if TRUE, Error messages are displayed
	 * @return	array
	 *
	 * @access	public
	 * @static
	 */
	public static function getSerArtNr($prod_id, $show_message = true)
	{
		$prod_id		= self::extractNumber( $prod_id );
		$show_message	= (boolean) $show_message;
		
		//$query		= "SELECT QSDB.testProdId($prod_id) AS ProdID";
		/*
		$query		= "SELECT QSDB.getSerArtNr($prod_id) AS SerArtNr";
		
		$result		= $GLOBALS['dbObj']->sql_query($query);
		$res		= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
		
		//var_dump( $res['SerArtNr'] );
		
		if ((int)$res['SerArtNr'] < 0) {
			if ($show_message) {
				echo('<p>'.self::get_error((int) $res['SerArtNr']).'</p>');
			}
			return false;
		}
		
		$info		= explode(',', (int)$res['SerArtNr']);
		$info2		= array();
		
		for ($i = 0; $i < 3; $i++) {
			$info2[$i]	= self::extractNumber($info[$i]);
		}
		$info2[3]	= (string) $info[3];
		*/
		
		$query		= "SELECT p.id_art FROM products AS p WHERE p.prod_id=$prod_id";
		$result		= $GLOBALS['dbObj']->sql_query($query);
		$res		= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
		
		if ( (int) $res['id_art'] == 0 ) {
			$query	= "SELECT p.serial_nr, a.art_nr, a.art_index, a.art_name FROM products AS p, art AS a WHERE a.art_nr=p.art_nr AND a.art_index=p.art_index AND p.prod_id=$prod_id";
		} else {
			$query	= "SELECT p.serial_nr, a.art_nr, a.art_index, a.art_name FROM products AS p, art AS a WHERE a.id_art=p.id_art AND p.prod_id=$prod_id";
		}
		
		$result		= $GLOBALS['dbObj']->sql_query($query);
		$res		= $GLOBALS['dbObj']->sql_fetch_assoc2($result, true);
		
		$serNr		= self::extractNumber( $res['serial_nr'] );
		$artNr		= self::extractNumber( $res['art_nr'] );
		$artIndex	= self::extractNumber( $res['art_index'] );
		$artName	= (string) $res['art_name'];
		
		if ( is_null( $artIndex ) ) {
			$artIndex	= 0;
		}
		
		if ( is_null( $artName ) ) {
			$artName	= '';
		}
		
		$query		= "SELECT a.art_name FROM QSDB.art AS a WHERE a.art_nr=$artNr and a.art_index=$artIndex ORDER BY a.art_nr, a.art_name LIMIT 0,1";
		
		$result		= $GLOBALS['dbObj']->sql_query($query);
		$anz		= $GLOBALS['dbObj']->sql_num_rows($result);
		if ($anz == 0) {
			$artName = '';
		} else {
			$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, true);
			$artName= (string) $res['art_name'];
		}
		
		return array( $serNr, $artNr, $artIndex, $artName );
		//return $info2;
	}
	
	// }}} getSerArtNr
	// {{{ checkVar
	
	/**
	 * Function		checkVar
	 *
	 * trims a given value and checks, if the string is not empty
	 *
	 * @param	string	$userVar:		the value, that should be checked
	 * @return	boolean					TRUE, if the String is not empty
	 *
	 * @access	public
	 * @static
	 */
	public static function checkVar($userVar)
	{
		$userVar	= trim( (string) $userVar );
		
		if ( strlen( $userVar ) == 0 ) {
			echo "<p>Eine erforderliche Eingabe ist nicht korrekt.</p>";
			return false;
		}
		return true;
	}
	
	// }}} checkVar
	// {{{ checkVarNum
	
	/**
	 * Function		checkVarNum
	 *
	 * checks, if a Value is numeric
	 *
	 * @param	integer	$userVar:		the value, that should be checked
	 * @return	boolean					TRUE, if the Value is numeric
	 *
	 * @access	public
	 * @static
	 */
	public static function checkVarNum($userVar)
	{
		$userVar	= self::extractNumber($userVar);
		
		if (!is_numeric($userVar)) {
			echo "<p>Eine erforderliche Eingabe ist nicht korrekt. '$userVar' muss numerisch sein.</p>";
			return false;
		}
		return true;
		
	}
	
	// }}} checkVarNum
	// {{{ deleteTest
	
	/**
	 * Function		deleteTest
	 *
	 * deletes an Test from the QSDB Database and all related Records
	 *
	 * @param	integer	$testId:		the Test ID
	 * @param	boolean	$comment:		(optional) a Flag
	 *									if TRUE, Comments are displayed
	 * @return	void
	 *
	 * @access	public
	 * @static
	 */
	public static function deleteTest($testId, $comment = false)
	{
		$testId	= self::extractNumber( $testId );
		$comment= (boolean) $comment;
		
		//delete test-result connections
		$query	= "DELETE FROM QSDB.testresult_analyse WHERE test_id=$testId";
		$result	= $GLOBALS['dbObj']->sql_query($query);
		if ( $comment ) {
			echo mysql_error() . "<br />";
		}
		
		//delete test-details
		$query	= "DELETE FROM QSDB.test_details WHERE test_id=$testId";
		$result	= $GLOBALS['dbObj']->sql_query($query);
		if ( $comment ) {
			echo mysql_error() . "<br />";
		}
		
		//delete test
		$query	= "DELETE FROM QSDB.test WHERE test_id=$testId";
		$result	= $GLOBALS['dbObj']->sql_query($query);
		if ( $comment ) {
			echo mysql_error() . "<br />";
		}
		
		if ( $comment ) {
			echo "Test $testId gel&ouml;scht...<br />";
		}
	}
	
	// }}} deleteTest
	// {{{ deleteProduct
	
	/**
	 * Function		deleteProduct
	 *
	 * deletes an Product from the QSDB Database and all related Records
	 *
	 * @param	integer	$testId:		the Product ID
	 * @param	boolean	$comment:		(optional) a Flag
	 *									if TRUE, Comments are displayed
	 * @return	void
	 *
	 * @access	public
	 * @static
	 */
	public static function deleteProduct($prodId, $comment = false)
	{
		$prodId		= self::extractNumber( $prodId );
		$comment	= (boolean) $comment;
		
		if ($prodId > 0) {
			$userdata	= self::getSerArtNr($prodId);
			
			$msg	= $userdata[1].': SerNr '.$userdata[0].': ';
			
			$query	= "DELETE FROM QSDB.device_history WHERE prod_id=$prodId";
			$result	= $GLOBALS['dbObj']->sql_query($query);
			if ($comment) {
				echo $msg.'Historyeintr&auml;ge gel&ouml;scht...<br />';
			}
			
			$query	= "DELETE FROM QSDB.zusbau_prod WHERE zusbau_prod_id=$prodId OR piece_prod_id=$prodId";
			$result	= $GLOBALS['dbObj']->sql_query($query);
			if ($comment) {
				echo $msg.'Zusbaueintr&auml;ge gel&ouml;scht...<br />';
			}
			
			$query	= "DELETE FROM QSDB.tbl_ret WHERE uid_defekt=$prodId OR uid_austausch=$prodId";
			$result	= $GLOBALS['dbObj']->sql_query($query);
			if ($comment) {
				echo $msg.'Returneintr&auml;ge gel&ouml;scht...<br />';
			}
			
			$query	= "SELECT te.test_id FROM QSDB.test AS te WHERE te.prod_id=$prodId";
			$result	= $GLOBALS['dbObj']->sql_query($query);
			$anz	= $GLOBALS['dbObj']->sql_num_rows($result);
			
			if ($comment) {
				echo $msg.'l&ouml;sche Tests...<br />';
			}
			
			for ($i = 0; $i < $anz; $i++) { //delete all tests
				$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
				$testId	= self::extractNumber( $res['test_id'] );
				
				if ($testId > 0) {
					if ($comment) {
						echo $msg;
					}
					
					self::deleteTest($testId, $comment);
				}
			}
			
			//delete product itself
			$query	= "DELETE FROM QSDB.products WHERE prod_id=$prodId";
			$result	= $GLOBALS['dbObj']->sql_query($query);
			
			if ($comment) {
				if ((int) $userdata[0] > 0 && (int) $userdata[1] > 0) {
					echo $msg.'Produkt gel&ouml;scht...<br />';
				}
			}
		}
	}
	
	// }}} deleteProduct
	// {{{ deleteArticle
	
	/**
	 * Function		deleteArticle
	 *
	 * deletes an Article from the QSDB Database and all related Records
	 *
	 * @param	integer	$testId:		the Article Number
	 * @param	boolean	$comment:		(optional) a Flag
	 *									if TRUE, Comments are displayed
	 * @return	void
	 *
	 * @access	public
	 * @static
	 */
	public static function deleteArticle($artNr, $comment = false)
	{
		$artNr		= self::extractNumber( $artNr );
		$comment	= (boolean) $comment;
		
		//get ID for Article
		$query2		= "SELECT a.id_art, a.art_index FROM QSDB.art AS a WHERE a.art_nr=$artNr ORDER BY a.art_nr, a.art_index DESC";
		$result2	= $GLOBALS['dbObj']->sql_query($query2);
		$anz2		= $GLOBALS['dbObj']->sql_num_rows($result2);
		
		for ($j = 0; $j < $anz2; $j++) {
			$res		= $GLOBALS['dbObj']->sql_fetch_assoc2($result2, false);
			
			$artId		= self::extractNumber($res['id_art']);
			$artIndex	= self::extractNumber($res['art_index']);
			
			$msg	= $artNr . ' (Index ' . $artIndex . '): ';
			
			if ($artId > 0) {// ID is valid
				//delete Error tree for Article
				$query	= "DELETE FROM QSDB.errors WHERE id_art=$artId";
				$result	= $GLOBALS['dbObj']->sql_query($query);
				if ($comment) {
					echo $msg.'Fehlerb&auml;ume gel&ouml;scht...<br />';
				}
				
				//delete Piece list for Article
				$query	= "DELETE FROM QSDB.zusbau WHERE uid_zusbau=$artId OR uid_piece=$artId";
				$result	= $GLOBALS['dbObj']->sql_query($query);
				if ($comment) {
					echo $msg.'Artikelzusbaueintr&auml;ge gel&ouml;scht...<br />';
				}
				
				//delete Tester Relations for Article
				$query	= "DELETE FROM QSDB.tester_articles WHERE id_art=$artId";
				$result	= $GLOBALS['dbObj']->sql_query($query);
				if ($comment) {
					echo $msg.'Artikel-Tester-Relationen gel&ouml;scht...<br />';
				}
				
				//delete Products for Article
				$query	= "select p.prod_id from QSDB.products AS p WHERE p.id_art=$artId";
				$result	= $GLOBALS['dbObj']->sql_query($query);
				$anz	= $GLOBALS['dbObj']->sql_num_rows($result);
				
				if ($comment) {
					echo $msg.'l&ouml;sche Produkte...<br />';
				}
				for ($i = 0; $i < $anz; $i++) {//delete all products
					$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
					$prodId	= self::extractNumber( $res['prod_id'] );
					
					if ($prodId > 0) {
						
						self::deleteProduct($prodId, $comment);
					}
				}
				//delete article itself
				$query	= "DELETE FROM QSDB.art WHERE id_art=$artId";
				$result	= $GLOBALS['dbObj']->sql_query($query);
				
				if ($comment) {
					echo $msg.'Artikel gel&ouml;scht...<br />';
				}
			} else { // ID holds Error code
				echo 'Es ist ein Fehler aufgetreten: ' . self::get_error($artId);
			}
		}
	}
	
	// }}} deleteArticle
	// {{{ extractNumber
	
	/**
	 * Function		extractNumber
	 *
	 * extracts a Number from a String
	 * if is there more than one Number group, the last group will be extracted
	 * 
	 * NOTE: only Numbers will be extracted, not Chars like '-' or '.'
	 *
	 * @param	string	$NrRaw:			the value, that should be checked
	 * @return	integer					the extracted Number
	 *
	 * @access	public
	 * @static
	 */
	public static function extractNumber($NrRaw)
	{
		//get last number in string which is the serial number
		$numbers = array();

		preg_match_all('([0-9]+)', (string) $NrRaw, $numbers);

		if (count($numbers[0]) > 0) {
			$userVar	= (int) $numbers[0][count($numbers[0]) - 1];
			$userVar	= trim((string)$userVar);
		} else {
			$userVar	= 0;
		}
		return (int) $userVar;
	}
	
	// }}} extractNumber
	// {{{ get_menu_items
	
	/**
	 * Function		get_menu_items
	 *
	 * searches sub menu items for an given menu ID
	 *
	 * @param	integer	$parent_id:		the menu ID
	 * @return	mixed					the found menu items
	 *
	 * @access	public
	 * @static
	 */
	public static function get_menu_items($parent_id)
	{
		$parent_id	= (int) $parent_id;
		$menu_items = $GLOBALS['TSFE']->sys_page->getMenu($parent_id);
		
		return $menu_items;
	}
	
	// }}} get_menu_items
	// {{{ menu_exists
	
	/**
	 * Function		menu_exists
	 *
	 * tests if a menu item exists for a given ID
	 *
	 * @param	integer	$menu_id:		the menu ID that should exist
	 * @return	boolean					TRUE, if the menu item exists
	 *
	 * @access	public
	 * @static
	 */
	public static function menu_exists($menu_id)
	{
		$menu_id	= (int) $menu_id;
		$query		= "SELECT COUNT(*) AS anz FROM pages WHERE uid=$menu_id";
		
		$res		= $GLOBALS['TYPO3_DB']->sql_query($query);
		$menu_str	= $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
		
		return (boolean) $menu_str['anz'];
	}
	
	// }}} menu_exists
	// {{{ get_menu
	
	/**
	 * Function		get_menu
	 *
	 * searches a menu item for an given menu ID
	 *
	 * @param	integer	$parent_id:		the menu ID
	 * @return	array					the found menu item
	 *
	 * @access	public
	 * @static
	 */
	public static function get_menu($menu_id)
	{
		$menu_id	= (int) $menu_id;
		$query		= "SELECT * FROM pages WHERE uid=$menu_id LIMIT 0,1";
		
		$res		= $GLOBALS['TYPO3_DB']->sql_query($query);
		$menu_str	= $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
		
		return $menu_str;
	}
	
	// }}} get_menu
	// {{{ get_parent_menu
	
	/**
	 * Function		get_parent_menu
	 *
	 * searches the parent menu item for an given menu ID
	 *
	 * @param	integer	$menu_id:		the menu ID
	 * @return	integer					the found parent menu item ID or
	 *									0, if not found
	 *
	 * @access	public
	 * @static
	 */
	public static function get_parent_menu($menu_id)
	{
		$menu_id	= (int) $menu_id;
		$query		= "SELECT pid FROM pages WHERE uid=$menu_id LIMIT 0,1";
		
		$res		= $GLOBALS['TYPO3_DB']->sql_query($query);
		$menu_str	= $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
		
		return (int) $menu_str['pid'];
	}
	
	// }}} get_parent_menu
	// {{{ get_user_id
	
	/**
	 * Function		get_user_id
	 *
	 * returns the User ID of the actual user
	 *
	 * @return	integer					the User ID
	 *
	 * @access	public
	 * @static
	 */
	public static function get_user_id()
	{
		$user_id	= (int) $GLOBALS['TSFE']->fe_user->user['uid'];
		return $user_id;
	}
	
	// }}} get_user_id
	// {{{ get_user_groups
	
	/**
	 * Function		get_user_groups
	 *
	 * searches the User groups for an User
	 *
	 * @param	integer	$user_id:		the user ID
	 * @return	string					the User groups as comma separated list
	 *
	 * @access	public
	 * @static
	 */
	public static function get_user_groups($user_id)
	{
		$user_id	= (int) $user_id;
		$query		= "SELECT usergroup FROM fe_users WHERE uid=$user_id LIMIT 0,1";
		
		$res		= $GLOBALS['TYPO3_DB']->sql_query($query);
		$group_str	= $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
		
		return (string) $group_str['usergroup'];
	}
	
	// }}} get_user_groups
	// {{{ get_group_menu
	
	/**
	 * Function		get_group_menu
	 *
	 * tests if an user group has rights to an menu item
	 *
	 * @param	integer	$group_id:		the ID of the user group
	 * @param	integer	$menu_id:		(optional) the menu ID
	 * @return	boolean					TRUE, if the user group has rights
	 *
	 * @access	public
	 * @static
	 */
	public static function get_group_menu($group_id, $menu_id=20)
	{
		$menu_id	= (int) $menu_id;
		$group_id	= (int) $group_id;
		
		//Menüpunkte für Gruppe abfragen
		$query		= "SELECT QSDB.get_group_menu($menu_id, $group_id) AS Menu";
		
		$result		= $GLOBALS['dbObj']->sql_query($query);
		$row		= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
		//$anz		= $GLOBALS['dbObj']->sql_num_rows($result);
		$anz		= (int) $row['Menu'];
		
		if ($anz == 0) {
			return false;
		} else {
			return true;
		}
	}
	
	// }}} get_group_menu
	// {{{ set_group_menu
	
	/**
	 * Function		set_group_menu
	 *
	 * set rights for an user group to an menu entry
	 *
	 * @param	integer	$group_id:		the ID of the user group
	 * @param	integer	$menu_id:		(optional) the menu ID
	 * @param	integer	$verboten:		(optional) 1, of its forbidden to see the menu to the group
	 * @return	bollean					TRUE, if the right is set
	 *
	 * @access	public
	 * @static
	 */
	public static function set_group_menu($group_id, $menu_id=20, $verboten=0)
	{
		$menu_id	= (int) $menu_id;
		$group_id	= (int) $group_id;
		$verboten	= (int) $verboten;
		$cruser_id	= (int) self::get_user_id();
		$pid  		= (int) $GLOBALS['TSFE']->id;
		
		//Menüpunkte für Gruppe abfragen
		$query		= "SELECT QSDB.set_group_menu($menu_id, $group_id, $verboten, $cruser_id, $pid)";
		
		$result		= $GLOBALS['dbObj']->sql_query($query);	
		
		if (!$result) {
			return false;
		} else {
			return true;
		}
	}
	
	// }}} set_group_menu
	// {{{ get_user_menu
	
	/**
	 * Function		get_user_menu
	 *
	 * tests if the user has the right to see an menu entry
	 *
	 * @param	integer	$user_id:		the user ID
	 * @param	integer	$menu_parent_id:(optional) the root ID to start searching
	 * @param	boolean	$ignore_hidden:	(optional) if TRUE, the hidden items we be ignoed
	 * @return	boolean					TRUE, if the user has rights
	 *
	 * @access	public
	 * @static
	 */
	public static function get_user_menu($user_id, $menu_id = 20, $ignore_hidden = false)
	{
		$menu_id	= (int) $menu_id;
		$user_id	= (int) $user_id;
		$anz = 0;
		
		//User-Gruppen abfragen
		$user_groups = self::get_user_groups( $user_id );
		$menu_item = self::get_menu( $menu_id );
		
		if ((boolean) $ignore_hidden ) {
			$menu_hidden = (((int) $menu_item['hidden'] == 1) ? true : false);
		} else {
			$menu_hidden = (((int) $menu_item['nav_hide'] == 1 || (int) $menu_item['hidden'] == 1) ? true : false);
		}
		
		if ( !$menu_hidden ) {
			$menu_groups_set = (((int)$menu_item['fe_group'] > 0 ) ? true : false);
			
			if ( $menu_groups_set ) {
				$menu_groups = explode(',', $menu_item['fe_group']);
				$group_found = false;
				
				foreach ($menu_groups as $menu_group) {
					foreach (explode(',', $user_groups) as $user_group) {
						if ((int) $user_group == (int) $menu_group ) {
							$anz = 1;
							$group_found = true;
							break;
						}
					}
					
					if ( $group_found ) {
						break;
					}
				}
			} else {
				//Menüpunkte für User abfragen, da nicht in Typo3 verwaltet
				/*
				$query	= "SELECT mr.menu_id FROM QSDB.menu_rechte AS mr WHERE mr.gruppen_id IN ($user_groups) and mr.menu_id=$menu_id and mr.verboten=0 ORDER BY mr.menu_id";

				$result	= $GLOBALS['dbObj']->sql_query($query);
				$anz	= $GLOBALS['dbObj']->sql_num_rows($result);
				*/
				$anz	= 0;
			}
		}
		
		return (boolean) $anz;
	}
	
	// }}} get_user_menu
	// {{{ create_user_menu
	
	/**
	 * Function		create_user_menu
	 *
	 * creates the menu structure
	 *
	 * @param	integer	$menu_parent_id:(optional) the root ID to start creating the menu
	 * @param	boolean	$allowed_add:	(optional) if TRUE, an Home and a Portal link will added
	 * @return	array					the menu structure the the user
	 *
	 * @access		public
	 * @static
	 */
	public static function create_user_menu($menu_parent_id = 20, $allowed_add = true, $level = 1)
	{
		$menu_parent_id	= (int)		$menu_parent_id;
		$level			= (int)		$level;
		$allowed_add	= (boolean) $allowed_add;
		
		//User-ID abfragen
		$user_id		= self::get_user_id();
		
		//$level_intern	= $level;
		$menu_id		= $menu_parent_id;
		$step			= 0;
		
		$root_id		= $menu_parent_id;
		$parent_id		= $menu_parent_id;
		
		while ($level > ($step + 1)) {
			$root_id	= self::get_parent_menu($menu_id);
			
			if ($step == 0) {
				$parent_id	= $root_id;
			}
			
			$menu_id	= $root_id;
			$step++;
		}
		
		//Menüpunkte für gesuchtes Menü abfragen
		$user_menu1		= self::create_user_menu_sub($menu_parent_id, $allowed_add, $level, $root_id);
		$user_menu		= $user_menu1;
		
		if ($level > 1 || $menu_parent_id != $root_id) {
			if ( $parent_id != 20 && $parent_id != 629 ) {
				$user_menu2 = self::create_user_menu_sub($parent_id, $allowed_add, $level, $root_id);
				
				$user_menu = array_merge($user_menu1, $user_menu2);
			}
		}
		
		return $user_menu;
	}
	
	// }}} create_user_menu
	// {{{ create_user_menu_sub
	
	/**
	 * Function		create_user_menu_sub
	 *
	 * creates the menu structure
	 *
	 * @param	integer	$menu_parent_id:(optional) the root ID to start creating the menu
	 * @param	boolean	$allowed_add:	(optional) if TRUE, an Home and a Portal link will added
	 * @return	array					the menu structure the the user
	 *
	 * @access	public
	 * @static
	 */
	public static function create_user_menu_sub($menu_parent_id = 20, $allowed_add = true, $level = 1, $menu_root_id = 20)
	{
		$menu_parent_id	= (int)		$menu_parent_id;
		$level			= (int)		$level;
		$menu_root_id	= (int)		$menu_root_id;
		$allowed_add	= (boolean)	$allowed_add;
		
		//User-ID abfragen
		$user_id		= (int) self::get_user_id();
		
		//Menüpunkte für gesuchtes Menü abfragen
		$menu_items		= self::create_menu_overview($menu_parent_id, '', 0, $allowed_add);//get_menu_items($menu_parent_id);
		$user_menu		= array();
		
		foreach ($menu_items as $menu_item) {
			if ( isset( $menu_item['uid'] ) ) {
				$parent_id	= (int) $menu_item['pid'];
				$item_id	= (int) $menu_item['uid'];
				
				//ist Menüpunkt für aktuelles Menü vorgesehen?
				$user_m_bol = (boolean) self::get_user_menu((int) $user_id, (int) $item_id);
				
				if ( $parent_id == $menu_parent_id && $user_m_bol ) {
					//ist Menüpunkt nicht ausgeblendet?
					if (!$menu_item['nav_hide'] && !$menu_item['hidden']) {
						$group_found = true;
						
						//sind dem Menüpunkt Gruppen direkt zugeordnet?
						if ($menu_item['fe_group'] != '' && $menu_item['fe_group'] != '0') {
							$groups			= explode(',', $menu_item['fe_group']);
							
							//User-Gruppen abfragen
							$user_groups	= self::get_user_groups($user_id);
							$user_group		= explode(',', $user_groups);
							
							foreach ($groups as $group) {
								if ($group > 0) {
									//Steuerformatierungen des Menüs ausschliessen
									$group_found = false;
									if (in_array($group, $user_group)) {
										//Menüpunkt ist für User-Gruppe des Nutzers vorgesehen
										$group_found = true;
										break;
									}
								}
							}
						}
						
						if (($group_found) && (self::get_parent_menu($parent_id) == $menu_root_id || $parent_id==$menu_root_id || $item_id==$menu_root_id)) {
							//Menü-Array erstellen
							$lnk_txt = "index.php?id=$item_id";
							
							if ( $menu_item['no_cache'] ) {
								$lnk_txt .= '&no_cache=1';
							}
							
							$menu_title = $menu_item['title'];
							//$menu_title = self::ersetze($menu_item['title'], 'utf8');
							//$menu_title = self::ersetze($menu_title, 'um');
							//$menu_title = self::ersetze($menu_title, '&amp;');
							
							$user_menu[]= array(
								'title'				=> $menu_title,
								'_OVERRIDE_HREF'	=> $lnk_txt
							);
						}
					}
				}
			}
		}
		
		return $user_menu;
	}
	
	// }}} create_user_menu_sub
	// {{{ getMenuId
	
	/**
	 * Function		getMenuId
	 *
	 * returns the ID for an Link
	 *
	 * @param	integer	$id:			(optional) the ID of the menu item to link to
	 * @param	string	$name:			(optional) the name of the menu item to link to
	 * @return	integer					the ID of the Link
	 *
	 * @access	public
	 * @static
	 */
	public static function getMenuId($id = 0, $name = '')
	{
		$id			= (int)		$id;
		$name		= (string)	$name;
		
		$id_query	= (($id > 0) ? "pa.uid=$id " : (($name != '') ? "pa.tx_tmqsdb_tm_qsdb_target='$name'" : ''));
		
		if (($id > 0 || $name != '') && $id_query != '') {
		    //id oder name müssen gesetzt sein
		    $query	=	'SELECT pa.uid FROM typo4_0.pages AS pa WHERE ';
		    $query	.=	(($id > 0) ? "pa.uid=$id " : (($name != '') ? "pa.tx_tmqsdb_tm_qsdb_target='$name'" : ""));
		    $query	.=	' ORDER BY pa.crdate DESC,pa.uid LIMIT 0,1';
			
			//var_dump( $query );
			$result	= $GLOBALS['dbObj']->sql_query($query);
			//var_dump(mysql_error());
		    $anz	= $GLOBALS['dbObj']->sql_num_rows($result);
		    //var_dump( $anz );
			
			$user_id		= self::get_user_id();			//ID des Users
			$user_groups	= self::get_user_groups($user_id);
			
			while ($row	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false)) {
				$item_id		= (int) $row['uid'];		//ID des Menüeintrages
				$user_m_bol		= self::get_user_menu((int) $user_id, (int) $item_id, true);//feststellen, ob User Rechte hat
				
				//var_dump((int) $user_m_bol);
				
				if ($user_m_bol) {
					//User hat Rechte, also Link erstellen
					
					$id = $item_id;
					break;
				}
			}
		}
		
		return $id;
	}
	
	// }}} getMenuId
	// {{{ create_link
	
	/**
	 * Function		create_link
	 *
	 * creates an link
	 *
	 * @param	string	$what:			(optional) 'link' or 'form'
	 * @param	integer	$id:			(optional) the ID of the menu item to link to
	 * @param	string	$name:			(optional) the name of the menu item to link to
	 * @param	string	$add_text:		(optional) the link text, if the item is found
	 * @param	string	$insert:		(optional) the link text, if the item is not found
	 * @param	string	$title:			(optional) the title tag within a link
	 * @return							the complete HTML-Link
	 *
	 * @access	public
	 * @static
	 */
	public static function create_link($what = 'form', $id = 0, $name = '', $add_text = '', $insert = '', $title = '')
	{
		$text = '';
		
		$what		= (string)	$what;
		$id			= (int)		$id;
		$name		= (string)	$name;
		$add_text	= (string)	$add_text;
		$insert		= (string)	$insert;
		$title		= (string)	$title;
		
		if ($what == 'link') {
			$i_text = '#';
		} else {
			$i_text = '';
		}
		
		if ($title == '') {
			$ins_title = '';
		} else {
			$ins_title = ' title="'.$title.'"';
		}
		
		if ($id > 0 || $name != '') {
		    //id oder name müssen gesetzt sein
			
			$user_id		= self::get_user_id();			//ID des Users
			$user_groups	= self::get_user_groups($user_id);
			
			/*
		    $query	=	'SELECT pa.uid FROM typo4_0.pages AS pa WHERE ';
		    $query	.=	(($id > 0) ? "pa.uid=$id " : (($name != '') ? "pa.tx_tmqsdb_tm_qsdb_target='$name'" : "1"));
		    $query	.=	' ORDER BY pa.crdate DESC,pa.uid LIMIT 0,1';
			
			$result	= $GLOBALS['dbObj']->sql_query($query);
			//var_dump(mysql_error());
		    $anz	= $GLOBALS['dbObj']->sql_num_rows($result);
		    //var_dump( $anz );
			
			while ($row	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false)) {
				$item_id		= (int) $row['uid'];		//ID des Menüeintrages
				$user_m_bol		= self::get_user_menu((int) $user_id, (int) $item_id, true);//feststellen, ob User Rechte hat
				
				//var_dump((int) $user_m_bol);
				
				if ($user_m_bol) {
					//User hat Rechte, also Link erstellen
					
					$query2		= "SELECT QSDB.create_MenuLink($item_id, '$name', '$what', '$user_groups', '$add_text', '$insert', '$title') AS Link";
					$result2	= $GLOBALS['dbObj']->sql_query($query2);
					//var_dump(mysql_error());
					$row2   	= $GLOBALS['dbObj']->sql_fetch_assoc2($result2, false);
					$text   	= (string) $row2['Link'];
				}
			}
			*/
			
			$item_id = self::getMenuId($id, $name);
			
			if ($item_id > 0) {
				$query2		= "SELECT QSDB.create_MenuLink($item_id, '$name', '$what', '$user_groups', '$add_text', '$insert', '$title') AS Link";
				$result2	= $GLOBALS['dbObj']->sql_query($query2);
				//var_dump(mysql_error());
				$row2   	= $GLOBALS['dbObj']->sql_fetch_assoc2($result2, false);
				$text   	= (string) $row2['Link'];
			}
		}
		
		if ($text == '') {
			if ($what == 'link' && $i_text != '#') {
				$text = "<a href=\"$i_text\"$ins_title>$insert</a>";
			}
		  
			if ($what == 'form') {
				$text = $i_text;
			}
		}
		
		return $text;
	}
	
	// }}} create_link
	// {{{ create_menu_overview
	
	/**
	 * Function		create_menu_overview
	 *
	 * creates a list of all menus related to the QSDB
	 *
	 * @param	integer	$start_id:		the menu ID to start search
	 * @param	integer	$expand_id:		(optional) an menu ID to expand
	 * @param	integer	$level:			(optional) an level, for recursive calls
	 * @param	boolean	$allowed_add:	(optional) if TRUE, an Home and a Portal link will added
	 * @param	boolean	$show_hidden:	(optional) if TRUE, the menu items, which are hidden
	 *									in menu, are displayed
	 * @return	array					all menus from the QSDB
	 *
	 * @access	public
	 * @static
	 */
	public static function create_menu_overview($start_id, $expand_id = '', $level = 0, $allowed_add = true, $show_hidden = false)
	{
		$menu_items	= array();
		$menu		= array();
		
		$level		= (int) $level + 1;
		
		if ($level <= 1) {
			array_push($menu, array('max_level' => $level));
		}
		
		if ((string) $expand_id != 'all') {
			if ( (string) $expand_id != '') {
				$expand = explode(',', $expand_id);
			} else {
				$expand = array();
			}
			
			if ( !isset($expand[0]) ) {
				$expand = array();
				$expand[0] = 0;
			}
		}
		
		$menu_items	= self::get_menu_items((int) $start_id);
		$anz		= count($menu_items);
		
		if ($anz > 0) {
			$i=0;
			
			foreach ($menu_items as $menu_item) {
				$parent_id		= (int) $menu_item['pid'];
				$item_id		= (int) $menu_item['uid'];
				
				if ((string) $expand_id != 'all') {
					$expanded	= ($item_id == (int) $expand[0]) ? 1 : 0;
				} else {
					$dummy		= self::get_menu_items((int) $item_id);
					$expanded	= (count($dummy) > 0 ? 1 : 0);
				}
				
				$menu_hidden	= ( (int) $menu_item['nav_hide'] == 1 || (int) $menu_item['hidden'] == 1 || (int) $menu_item['fe_group'] > 0 )? true: false;
				
				array_push( $menu, array(
						'uid'			=>	$item_id,
						'title'			=>	(string)	$menu_item['title'],
						'pid'			=>	(int)		$menu_item['pid'],
						'nav_hide'		=>	(int)		$menu_item['nav_hide'],
						'hidden'		=>	(int)		$menu_item['hidden'],
						'fe_group'		=>	(string)	$menu_item['fe_group'],
						'no_cache'		=>	(int)		$menu_item['no_cache'],
						'parent'		=>	$parent_id,
						'level'			=>	$level,
						'expanded'		=>	$expanded,
						'exist_hidden'	=>	$menu_hidden
					)
				);
				$i++;
				
				if ($item_id == (int) $expand[0] || $expand_id == 'all') {
					$dummy	= array();
					
					if ((string) $expand_id != 'all') {
						$array2	= array_splice($expand, 0, 1); 
						
						$dummy	= self::create_menu_overview($item_id, implode(',', $expand), $level, false, $show_hidden);
					} else {
						$dummy	= self::create_menu_overview($item_id, 'all', $level, false, $show_hidden);
					}
					
					if ( count( $dummy ) ) {
						foreach ( $dummy as $menu_item ) {
							$menu_hidden	= ( (int) $menu_item['nav_hide'] == 1 || (int) $menu_item['hidden'] == 1 || (int) $menu_item['fe_group'] > 0 )? true: false;
							
							array_push( $menu, array(
								'uid'			=>	(int)		$menu_item['uid'],
								'title'			=>	(string)	$menu_item['title'],
								'pid'			=>	(int)		$menu_item['pid'],
								'nav_hide'		=>	(int)		$menu_item['nav_hide'],
								'hidden'		=>	(int)		$menu_item['hidden'],
								'fe_group'		=>	(string)	$menu_item['fe_group'],
								'no_cache'		=>	(int)		$menu_item['no_cache'],
								'parent'		=>	(int)		$menu_item['parent'],
								'level'			=>	(int)		$menu_item['level'],
								'expanded'		=>	(int)		$menu_item['expanded'],
								'exist_hidden'	=>	$menu_hidden
								)
							);
						}
					}
					
					$anz = count($menu_items);
				}
			}
		}
		
		if ((string) $expand_id != 'all') {
			$expanded	= ( $item_id == (int) $expand[0] ) ? 1 : 0;
		} else {
			$dummy		= self::get_menu_items((int) $item_id);
			$expanded	= ( count( $dummy ) ) ? 1 : 0;
		}
		
		if ( $allowed_add ) {
			//Link zum TM-Portal hinzufügen
			$menu_item		= self::get_menu(281);
			$menu_hidden	= ( (int) $menu_item['nav_hide'] == 1 || (int) $menu_item['hidden'] == 1 || (int) $menu_item['fe_group'] > 0 )? true: false;
			
			array_push( $menu, array(
					'uid'			=>	(int)		$menu_item['uid'],
					'title'			=>	(string)	$menu_item['title'],
					'pid'			=>	$start_id,
					'nav_hide'		=>	(int)		$menu_item['nav_hide'],
					'hidden'		=>	(int)		$menu_item['hidden'],
					'fe_group'		=>	(string)	$menu_item['fe_group'],
					'no_cache'		=>	(int)		$menu_item['no_cache'],
					'parent'		=>	(int)		$start_id,
					'level'			=>	(int)		$level,
					'expanded'		=>	$expanded,
					'exist_hidden'	=>	$menu_hidden
				)
			);
			
			//Home-Link hinzufügen
			$menu_item		= self::get_menu(282);
			$menu_hidden	= ( (int) $menu_item['nav_hide'] == 1 || (int) $menu_item['hidden'] == 1 || (int) $menu_item['fe_group'] > 0 )? true: false;
			
			array_push( $menu, array(
					'uid'			=>	(int)		$menu_item['uid'],
					'title'			=>	(string)	$menu_item['title'],
					'pid'			=>	$start_id,
					'nav_hide'		=>	(int)		$menu_item['nav_hide'],
					'hidden'		=>	(int)		$menu_item['hidden'],
					'fe_group'		=>	(string)	$menu_item['fe_group'],
					'no_cache'		=>	(int)		$menu_item['no_cache'],
					'parent'		=>	(int)		$start_id,
					'level'			=>	(int)		$level,
					'expanded'		=>	$expanded,
					'exist_hidden'	=>	$menu_hidden
				)
			);
		}
		
		if ($level <= 1) {
			$max_level = $level;
			
			foreach ($menu as $menu_item) {
				if (!isset($menu_item['max_level']) && isset($menu_item['level'])) {
					if ((int) $menu_item['level']>$max_level) {
						$max_level = (int) $menu_item['level'];
					}
					
					//echo $max_level;
				}
			}
			
			$menu[0]['max_level'] = $max_level;
		}

		return $menu;
	}
	
	// }}} create_menu_overview
	// {{{ overview_user_groups
	
	/**
	 * Function		overview_user_groups
	 *
	 * searches all user groups which are related to the QSDB
	 *
	 * @return	array					all QSDB user groups
	 *
	 * @access	public
	 * @static
	 */
	public static function overview_user_groups()
	{
		$query = 'SELECT uid, title, description, subgroup FROM fe_groups ORDER BY uid';

		$groups = array();
		
		$res = $GLOBALS['TYPO3_DB']->sql_query($query);
		
		while ($group_str = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			if (stristr((string) $group_str['title'], 'qsdb')) {
				$groups[] = $group_str;
			}
		}
		return $groups;
	}
	
	// }}} overview_user_groups
	// {{{ ersetze
	
	/**
	 * Function		ersetze
	 *
	 * replaces special chars with their HTML-code
	 *
	 * @param	string	$str:			the string which includes the special chars
	 * @param	string	$what:			(optional) the code what to replace
	 * @return	string					the string with replaced content
	 *
	 * @access	public
	 * @static
	 */
	public static function ersetze ($str, $what = '')
	{
		$str	= (string) $str;
		$what	= (string) $what;
		
		if ( $what == 'delbr' ) {
			$str = eregi_replace( '([ ]{2,})', ' ', $str );
			//$str = eregi_replace( '(\s)', '', $str );
			$str = str_replace( "\n",				'',			$str );
			$str = str_replace( "\t",				'',			$str );
			$str = str_replace( "\r",				'',			$str );
			$str = str_replace( "\f",				'',			$str );
			$str = str_replace( '<br>',				'',			$str );
			$str = str_replace( '<br/>',			'',			$str );
			$str = str_replace( '<br />',			'',			$str );
		} elseif ( $what == 'changebr' ) {
			$str = str_replace( '<br>',				"&#10;&#13;",		$str );
			$str = str_replace( '<br/>',			"&#10;&#13;",		$str );
			$str = str_replace( '<br />',			"&#10;&#13;",		$str );
		} elseif ( $what == '&amp;' ) {
			$str = str_replace( '&amp;',			'&',		$str );
		} elseif ( $what == 'utf8' ) {
			$str = utf8_decode( $str );
		} elseif ( $what == 'all' ) {
			$str = self::ersetze( $str, 'utf8' );
			$str = self::ersetze( $str, 'um1' );
			$str = self::ersetze( $str, 'um2' );
			$str = self::ersetze( $str, 'um3' );
			$str = self::ersetze( $str, 'br' );
		} elseif ( $what == 'um' ) {
			//$str = htmlentities( $str );
			//$str = self::ersetze($str, '&amp;');
			$str = self::ersetze( $str, 'um1' );
			$str = str_replace( '&lt;',				'<',		$str );
			$str = str_replace( '&gt;',				'>',		$str );
			$str = str_replace( '&quot;',			'"',		$str );
			$str = self::ersetze( $str, 'um2' );
			$str = self::ersetze( $str, 'um3' );
		} elseif ( $what == 'um1' ) {
			$str = htmlentities( $str );
			$str = self::ersetze( $str, '&amp;' );
		} elseif ( $what == 'um2' ) {
			$str = str_replace( '&amp;nbsp;', 		'&nbsp;',	$str );
			$str = str_replace( '&amp;#064;', 		'&#064;',	$str );
			$str = str_replace( '&amp;amp;',  		'&amp;',	$str );
			$str = str_replace( '&amp;frac14;', 	'&frac14;',	$str );
			$str = str_replace( '&amp;Atilde;',  	'&Atilde;',	$str );
			$str = str_replace( '&amp;uuml;',  		'&uuml;',	$str );
			$str = str_replace( '&amp;auml;',  		'&auml;',	$str );
			$str = str_replace( '&amp;ouml;',  		'&ouml;',	$str );
			$str = str_replace( '&K',  				'&amp;K',	$str );
			$str = str_replace( '&Atilde;&curren;',	'&auml;',	$str );
			$str = str_replace( '&Atilde;&frac14;',	'&uuml;',	$str );
			$str = str_replace( 'Ã¼',				'&uuml;',	$str );
			$str = str_replace( 'Ã¶',				'&ouml;',	$str );//&#195;&para;
			$str = str_replace( '&Atilde;&para;',	'&ouml;',	$str );
			$str = str_replace( '&Atilde;&shy;',	'i',		$str );//&#195;&shy;
			$str = str_replace( '&Atilde;€',		'A',		$str );//&#195;€
		} elseif ( $what == 'um3' ) {
			//HTML Chars
			$str = str_replace( '&lt;',				'&#60;',	$str );
			$str = str_replace( '&gt;',				'&#62;',	$str );
			$str = str_replace( '&amp;',			'&#38;',	$str );
			$str = str_replace( '&apos;',			'&#39;',	$str );
			$str = str_replace( '&quot;',			'&#34;',	$str );
			//Trade
			$str = str_replace( '@',				'&#64;',	$str );
			$str = str_replace( '&copy;',			'&#169;',	$str );
			$str = str_replace( '&reg;',			'&#174;',	$str );
			$str = str_replace( '&trade;',			'&#8482;',	$str );
			//
			$str = str_replace( '`',				'&#96;',	$str );
			$str = str_replace( '´',				'&#180;',	$str );
			$str = str_replace( '&acute;',			'&#180;',	$str );
			$str = str_replace( '~',				'&#126;',	$str );
			$str = str_replace( '&tilde;',			'&#732;',	$str );
			$str = str_replace( '^',				'&#94;',	$str );
			$str = str_replace( '&circ;',			'&#710;',	$str );
			$str = str_replace( '&uml;',			'&#168;',	$str );
			$str = str_replace( '&cedil;',			'&#184;',	$str );
			
			$str = str_replace( '&auml;',			'&#228;',	$str );
			$str = str_replace( '&ouml;',			'&#246;',	$str );
			$str = str_replace( '&uuml;',			'&#252;',	$str );
			$str = str_replace( '&Auml;',			'&#196;',	$str );
			$str = str_replace( '&Ouml;',			'&#214;',	$str );
			$str = str_replace( '&Uuml;',			'&#220;',	$str );
			
			$str = str_replace( '&Agrave;',			'&#192;',	$str );
			//$str = str_replace( 'À',				'&#192;',	$str );
			$str = str_replace( '&Aacute;',			'&#193;',	$str );
			//$str = str_replace( 'Á',				'&#193;',	$str );
			$str = str_replace( '&Acirc;',			'&#194;',	$str );
			//$str = str_replace( 'Â',				'&#194;',	$str );
			$str = str_replace( '&Atilde;',			'&#195;',	$str );
			//$str = str_replace( 'Â',				'&#195;',	$str );
			$str = str_replace( '&Aring;',			'&#197;',	$str );
			//$str = str_replace( 'Â',				'&#197;',	$str );
			$str = str_replace( '&Ccedil;',			'&#199;',	$str );
			//$str = str_replace( '&cedil;',			'&#184;',	$str );
			$str = str_replace( '&Egrave;',			'&#200;',	$str );
			//$str = str_replace( 'È',				'&#200;',	$str );
			$str = str_replace( '&Eacute;',			'&#201;',	$str );
			//$str = str_replace( 'É',				'&#201;',	$str );
			$str = str_replace( '&Ecirc;',			'&#202;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Euml;',			'&#203;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Igrave;',			'&#204;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Iacute;',			'&#205;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Icirc;',			'&#206;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Iuml;',			'&#207;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Ntilde;',			'&#209;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Ograve;',			'&#210;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Oacute;',			'&#211;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Ocirc;',			'&#212;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Otilde;',			'&#213;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Oslash;',			'&#216;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Scaron;',			'&#352;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Ugrave;',			'&#217;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Uacute;',			'&#218;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Ucirc;',			'&#219;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Yacute;',			'&#221;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&Yuml;',			'&#376;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			
			$str = str_replace( '&agrave;',			'&#224;',	$str );
			//$str = str_replace( 'À',				'&#192;',	$str );
			$str = str_replace( '&aacute;',			'&#225;',	$str );
			//$str = str_replace( 'Á',				'&#193;',	$str );
			$str = str_replace( '&acirc;',			'&#226;',	$str );
			//$str = str_replace( 'Â',				'&#194;',	$str );
			$str = str_replace( '&atilde;',			'&#227;',	$str );
			//$str = str_replace( 'Â',				'&#195;',	$str );
			$str = str_replace( '&aring;',			'&#229;',	$str );
			//$str = str_replace( 'Â',				'&#195;',	$str );
			$str = str_replace( '&ccedil;',			'&#231;',	$str );
			//$str = str_replace( '&cedil;',			'&#184;',	$str );
			$str = str_replace( '&egrave;',			'&#232;',	$str );
			//$str = str_replace( 'È',				'&#200;',	$str );
			$str = str_replace( '&eacute;',			'&#233;',	$str );
			//$str = str_replace( 'É',				'&#201;',	$str );
			$str = str_replace( '&ecirc;',			'&#234;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&euml;',			'&#235;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&igrave;',			'&#236;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&iacute;',			'&#237;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&icirc;',			'&#238;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&iuml;',			'&#239;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&ntilde;',			'&#241;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&ograve;',			'&#242;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&oacute;',			'&#243;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&ocirc;',			'&#244;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&otilde;',			'&#245;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&oslash;',			'&#248;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&scaron;',			'&#353;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&ugrave;',			'&#249;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&uacute;',			'&#250;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&ucirc;',			'&#251;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&yacute;',			'&#253;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&yuml;',			'&#255;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			
			$str = str_replace( '&AElig;',			'&#198;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&aelig;',			'&#230;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&szlig;',			'&#223;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&OElig;',			'&#338;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&oelig;',			'&#339;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			
			$str = str_replace( '&iexcl;',			'&#161;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&iquest;',			'&#191;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
			$str = str_replace( '&middot;',			'&#183;',	$str );
			//$str = str_replace( 'Ê',				'&#202;',	$str );
		} elseif ( $what == 'br' ) {
			$str = nl2br( $str );
		} elseif (is_object($GLOBALS['dbObj'])) {
			$query	= "SELECT QSDB.replace('$str', '$what') AS RET";
			//var_dump(mysql_error());
			
			$result	= $GLOBALS['dbObj']->sql_query($query);
			$row   	= $GLOBALS['dbObj']->sql_fetch_assoc($result);
			
			$str	= $row['RET'];
		}
		
		return $str;
	}
	
	// }}} ersetze
	// {{{ qsdb_log
	
	/**
	 * Function		qsdb_log
	 *
	 * logs the activity into the database
	 *
	 * @param	integer	$pid:			the page ID
	 * @param	integer	$user:			the user ID
	 * 
	 * @access	public
	 * @static
	 */
	public static function qsdb_log($pid, $user)
	{
		$agent			= addslashes( (string) $_SERVER['HTTP_USER_AGENT'] );
		$time			= time();
		$RequestIP		= addslashes( (string) $_SERVER['REMOTE_ADDR'] );

		$pid			= (int) $pid;
		$user			= (int) $user;
		
		$query 			= "SELECT QSDB.QSDB_LOG($pid, $user, '$agent', '$RequestIP') AS LogID";
		
		$result			= $GLOBALS['dbObj']->sql_query($query);
	}
	
	// }}} qsdb_log
	// {{{ trans_date
	
	/**
	 * Function		trans_date
	 *
	 * converts an date string in format 'DD.MM.YYYY'or'DD-MM-YYYY' to format 'YYYY-MM-DD' to store
	 * into the database
	 *
	 * @param	string	$date_in:		the origin date in format 'DD.MM.YYYY'
	 * @return	string					the converted date
	 *
	 * @access	public
	 * @static
	 */
	public static function trans_date($date_in)
	{
		if ( strpos( $date_in, '.' ) > 0 ) {
			$date_parts	= explode('.', (string) $date_in);
			
			$date_out	= $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
		} elseif ( strpos( $date_in, '-' ) == 2 ) {
			$date_parts	= explode('-', (string) $date_in);
			
			$date_out	= $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
		} else {
			$date_out	= (string) $date_in;
		}
		
		return (string) $date_out;
	}
	
	// }}} trans_date
	// {{{ strrrchr
	
	/**
	 * Function		strrrchr
	 *
	 * @param	string	$parent:		?
	 * @param	string	$needle:		?
	 * @param	string	$lay:			?
	 * @return	string					?
	 *
	 * @access	public
	 * @static
	 */
	public static function strrrchr($string, $needle, $lay)
	{
		$string	= (string)	$string;
		$needle	= (string)	$needle;
		$lay	= (int)		$lay;
		
		$array	= array(1);
		$i		= 0;
		$tok	= (boolean) strtok($string, $needle);
		
		if ($tok === false) {
			return $string;
		}
		
		while ($tok !== false && $i < $lay) {
			//echo "Wort=$tok<br />";
			$array[$i]	= $tok;
			$tok		= (boolean) strtok($needle);
			$i++;
		}

		return (string) implode('.', $array);
	}
	
	// }}} strrrchr
	// {{{ get_version
	
	/**
	 * Function		get_version
	 *
	 * returns the version for a class
	 *
	 * @param	string	$class:			(optional) the Class (Extension) which version should displayed
	 * @return							the version of the class (Extension)
	 *
	 * @access	public
	 * @static
	 */
	public static function get_version($class = '')
	{
		$class	= (string) $class;
		
		if ($class == '') {
			return '0.9.3.4';//QSDB
		} else {
			$_EXTKEY	= $class;
			require_once t3lib_extmgm::extPath($class, 'ext_emconf.php');
			
			$version	= (string) $EM_CONF[$_EXTKEY]['version'];
			$state		= (string) $EM_CONF[$_EXTKEY]['state'];
			
			//$version	= $version . ' (' . $state . ')';
			
			return $version;
		}
	}
	
	// }}} get_version
	// {{{ get_error
	
	/**
	 * Function		get_error
	 *
	 * returns a Message for an Errorcode
	 *
	 * @param	integer	$code:			the Error Code
	 * @return	string					The error Message
	 *
	 * @access	public
	 * @static
	 */
	public static function get_error($code)
	{
		$code		= (int) $code;
		
		$query		= "SELECT QSDB.get_error($code) AS err_msg";
		$result		= $GLOBALS['dbObj']->sql_query($query);
		$row   		= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
		
		//var_dump($code);
		//var_dump($row['err_msg']);
		
		$err_msg	= QSDB_functions::ersetze($row['err_msg'], 'all');
		return $err_msg;
		
		/*
		if ($code > 0) {
			return "dies ist keine Fehlercode!";
		}
		
		switch ($code) {
			case 0:
				return "kein regul&auml;rer Wert";
			case -51://renamed because of confict with tester software
				return "Artikelnummer oder Seriennummer ist NULL";
			case -2:
				return "kein Name für neuen Artikel";
			case -3:
				return "Artikelnummer für neuen Artikel ist 0";
			case -4:
				return "ID des Root-Testers ist 0";
			case -5:
				return "kein Name für Root-Tester";
			case -6:
				return "Root-Tester nicht vorhanden";
			case -7:
				return "kein Name für Tester";
			case -8:
				return "Artikelnummer oder Seriennummer ist negativ";
			case -9:
				return "Produkt existiert nicht";
			case -10:
				return "Tester existiert nicht";
			case -11:
				return "FehlerCode existiert nicht";
			case -12:
				return "Detail-ID ist 0 oder negativ";
			case -13:
				return "Artikelnummer existiert nicht";
			case -14:
				return "Artikel-ID existiert nicht";
			case -15:
				return "Detail existiert nicht";
			case -16:
				return "Tester existiert mit anderer Root";
			case -17:
				return "Error existiert nicht";
			case -18:
				return "Produkt existiert mehrfach";
			case -19:
				return "ArtRoot existiert nicht";
			case -20:
				return "kein Name für Root-Artikel";
			case -21:
				return "ID des Root-Artikels ist 0";
			case -22:
				return "Tester existiert mehrfach";
			case -23:
				return "Root-Tester existiert mehrfach";
			case -24:
				return "Artikel existiert mehrfach";
			case -25:
				return "Root-Artikel existiert mehrfach";
			case -26:
				return "Test existiert nicht";
			case -27:
				return "Test existiert mehrfach";
			case -28:
				return "Austausch nicht vorhanden";
			case -29:
				return "Menü existiert nicht";
			case -30:
				return "Ort existiert nicht";
			case -31:
				return "Person existiert nicht";
			case -32:
				return "Verwendung existiert nicht";
			case -33:
				return "ErrorCode existiert mehrfach";
			case -34:
				return "keine Fehlerbeschreibung";
			case -35:
				return "Seriennummer ist 0";
			case -36:
				return "Seriennummer ist bereits vergeben";
			case -37:
				return "Seriennummer au&szlig;erhalb des gültigen Bereiches";
			case -38:
				return "kein Name f&uuml;r die Firma angegeben";
			case -39:
				return "der Name f&uuml;r die Firma ist mehrfach vorhanden";
			case -40:
				return "kein Name f&uuml;r den Pr&uuml;fplatz angegeben";
			case -41:
				return "der Name f&uuml;r den Pr&uuml;fplatz ist mehrfach vorhanden";
			case -42:
				return "kein Name f&uuml;r das Feature angegeben";
			case -43:
				return "der Name f&uuml;r das Feature ist mehrfach vorhanden";
			case -44:
				return "kein Name f&uuml;r die Software angegeben";
			case -45:
				return "der Name f&uuml;r die Software ist mehrfach vorhanden";
			case -46:
				return "kein Name f&uuml;r den Ger&auml;tetyp angegeben";
			case -47:
				return "der Name f&uuml;r den Ger&auml;tetyp ist mehrfach vorhanden";
			case -48:
				return "TM Inventarnummer ist nicht g&uuml;ltig";
			case -49:
				return "angeforderte Seite existiert nicht";
			case -50:
				return "keine Rechte auf der angefordereten Seite";
			default:
				return "bisher unbekannter Fehler";
		}
		*/
	}
	
	// }}} get_error
	// {{{ import_license_files
	
	/**
	 * Function		import_license_files
	 *
	 * reads an inifile
	 *
	 * @param	string	$path:			(optional) the path of an directory 
	 *									where the license files are
	 * @param	string	$value:			(optional) the content of a single file
	 * @param	string	$user:			(optional) the user who created a single file
	 * @param	string	$date_file:		(optional) the date when a single file was 
	 *									created
	 * @return	string
	 * 
	 * @access	public
	 * @static
	 */
	public static function import_license_files($path = null, $value = null, $user = '', $date_file = '')
	{
		if (($path === null || $path == '') && ($value === null || $value == '')) {
			return;
		}
		
		if (class_exists('t3lib_extmgm')) {
			require_once t3lib_extmgm::extPath('tm_classes', 'classes/Class_pfiletree/PFileTree.inc.php');
			require_once t3lib_extmgm::extPath('tm_classes', 'classes/connection.php');
		} else {
			require_once '/srv/www/htdocs/4/typo3conf/ext/tm_classes/classes/Class_pfiletree/PFileTree.inc.php';
			require_once '/srv/www/htdocs/4/typo3conf/ext/tm_classes/classes/connection.php';
		}
		
		$host		= 'localhost';
		$db_user	= 'licensedb';
		$db_pass	= 'licensedb';
		$db_name	= 'licensedb';
		
		$txt		= '';
		
		$GLOBALS['dbObj'] = new qsdbDB($db_name, $db_user, $db_pass, $host);
		
		if ($path !== null && $path != '' && (is_dir($path) || is_file($path))) {
			//create Filetree Object
			$f		= new PFileTree($path);
			
			//create file list in directory
			$list	= $f->ListFiles($path, false, false);
			
			foreach ($list as $file_name => $file_props) {
				$file_name = (string) $file_name;
				$txt	.= 'File name: ' . $file_name . "\n";
				
				$noExt	= array('php', 'txt', 'sh', 'exe', 'com');
				
				if ((isset($file_props['ext']) && !in_array($file_props['ext'], $noExt)) || (!isset($file_props['ext']))) {
					//get path of file
					$file_path = (string) $file_props['fullpath'];
					$txt	.= '    Path:    ' . $file_path . "\n";
					
					//get user, who created file
					//get file date
					$dummy	= explode('-', $file_name);
					
					if (count($dummy) >= 4) {
						$user		= $dummy[count($dummy) - 1];
						$date_file	= $dummy[1] . '-' . $dummy[2] . '-' . $dummy[3] . ' ' . $dummy[4];
					} else {
						$user		= '';
						$date_file	= '';
					}
					
					//parse file as ini-file
					$ini_array	= self::parse_ini($file_path);
					
					//write file into database
					$file_size	= (isset($file_props['size'])	? (int)		$file_props['size']	: 0);
					$file_cr	= (isset($file_props['mdate'])	? (string)	$file_props['mdate']: null);
					$file_ch	= (isset($file_props['adate'])	? (string)	$file_props['adate']: null);
					$file_mime	= 'text/plain';
					
					if ($file_size > 0) {
						$datei	= fopen($file_path, 'rb');
						$data	= fread($datei, $file_size);
						$data	= addslashes($data);
						fclose($datei);
					} else {
						$data	= '';
					}
					
					$txt	.= self::import_license_array($ini_array, $data, $file_name, $file_mime, $file_size, $file_cr, $file_ch, $user, $date_file);
				}
			}
		} elseif ($value !== null && $value != '') {
			//var_dump($value);
			
			$ini_array	= self::parse_ini_text($value);
			
			//var_dump($ini_array);
			
			//write file into database
			$file_size	= strlen($value);
			$file_cr	= null;
			$file_ch	= null;
			$file_mime	= 'text/plain';
			$file_name	= 'license.tml-' . $date_file . '-' . $user;
			
			$txt	.= self::import_license_array($ini_array, $value, $file_name, $file_mime, $file_size, $file_cr, $file_ch, $user, $date_file);
		}
		
		return $txt;
	}
	
	// }}} import_license_files
	// {{{ import_license_array
	
	/**
	 * Function		confirm_link
	 *
	 * creates an listView for all Skills
	 *
	 * @param	array	$ini_array:		(optional) the parsed content of the INI-file
	 * @param	string	$data:			(optional) the unparsed content of the INI-file 
	 * @return	string
	 *
	 * @access	public
	 * @static
	 */
	public static function import_license_array($ini_array = array(), $data = '', $file_name = '', $file_mime = '', $file_size = 0, $file_cr = 0, $file_ch = 0, $user = '', $date_file = '')
	{
		if (count($ini_array) == 0) {
			return;
		}
		
		$txt	= '';
		
		//get information about the Board
		$board_nrs	= (isset($ini_array['Devices']['MB'])		?(string)	$ini_array['Devices']['MB']			:0);
		$board_prod	= (isset($ini_array['General']['Product'])	?(string)	$ini_array['General']['Product']	:'');
		$board_comm	= (isset($ini_array['General']['Comments'])	?(string)	$ini_array['General']['Comments']	:'');
		
		foreach (explode(' ', $board_nrs) as $board_nr) {
			$board_nr	= (int) $board_nr;
			
			if ($board_nr > 0) {
				$txt	.= '    Board:   ' . $board_nr . "\n";
				
				//search inside QSDB for Board
				$query	= "SELECT p.prod_id FROM QSDB.products AS p, QSDB.art AS a WHERE p.serial_nr=$board_nr AND p.id_art=a.id_art AND QSDB.isPiece_by_ArtNr(a.art_nr)=1 AND a.id_art_root=2";//Mainboards only
				$result	= $GLOBALS['dbObj']->sql_query($query);
				//var_dump(mysql_error());
				$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
				
				$prod_id = (int) $res['prod_id'];
				$txt	.= '    Product: ' . $prod_id . "\n";
				
				//import Boards
				$query	= "SELECT COUNT(*) AS anz FROM boards WHERE board_sn=$board_nr AND board_product='$board_prod' AND board_comments='$board_comm' AND board_qsdb_uid='$prod_id'";
				$result	= $GLOBALS['dbObj']->sql_query($query);
				$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
				
				$anz	= (int) $res['anz'];
				
				if ($anz == 0) {
					$query		= "INSERT INTO boards (board_sn,board_product,board_comments,board_qsdb_uid) VALUES ($board_nr,'$board_prod','$board_comm', '$prod_id')";
					$result		= $GLOBALS['dbObj']->sql_query($query);
					$query		= 'SELECT LAST_INSERT_ID() AS uid';
					$result		= $GLOBALS['dbObj']->sql_query($query);
					$res		= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
					
					$board_id	= (int) $res['uid'];
				} else {
					$query		= 'SELECT uid_board  FROM boards WHERE board_sn=' . $board_nr . ' LIMIT 0,1';
					$result		= $GLOBALS['dbObj']->sql_query($query);
					$res		= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
					
					$board_id	= (int) $res['uid_board'];
				}
				
				$query	= "INSERT INTO files (uid_board, file_name, file_mime, file_size, file_created, file_changes, file) VALUES ($board_id, '$file_name', '$file_mime', $file_size, '$file_cr', '$file_ch', '$data')";
				$result	= $GLOBALS['dbObj']->sql_query($query);
				
				//import User
				$qi_number = QSDB_functions::extractNumber($user);
				if ($qi_number > 0) {
					$qi_number = 'qi' . (string) (10000 + $qi_number);
				} else {
					$qi_number = '';
				}
				$txt	.= '    User:    ' . $user . "\n";
				$txt	.= '    qi num.: ' . $qi_number . "\n";
				
				$query	= "SELECT COUNT(*) AS anz FROM users WHERE user_name='$user'";
				$result	= $GLOBALS['dbObj']->sql_query($query);
				$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
				
				$anz	= (int) $res['anz'];
				
				if ($anz == 0) {
					$query	= "INSERT INTO users (user_name, qi_number) VALUES ('$user', '$qi_number')";
					$result	= $GLOBALS['dbObj']->sql_query($query);
					
					$query	= 'SELECT LAST_INSERT_ID() AS uid';
					$result	= $GLOBALS['dbObj']->sql_query($query);
					$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
					
					$user_id	= (int) $res['uid'];
				} else {
					$query	= "SELECT uid_user FROM users WHERE user_name='$user' LIMIT 0,1";
					$result	= $GLOBALS['dbObj']->sql_query($query);
					$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
					
					$user_id	= (int) $res['uid_user'];
				}
				
				//import Features
				if (isset($ini_array['Features'])) {
					$txt	.= '    Features:'."\n";
					
					foreach ($ini_array['Features'] as $feature_name => $feature_exists) {
						$feature_name = (string) $feature_name;
						$feature_exists = (boolean) $feature_exists;
						
						if ($feature_exists === true) {
							//Feature is set
							$query	= "SELECT COUNT(*) AS anz FROM features WHERE feature_name='$feature_name'";
							$result	= $GLOBALS['dbObj']->sql_query($query);
							$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
							
							$anz	= (int) $res['anz'];
							
							if ($anz == 0) {
								$query	= "INSERT INTO features (feature_name) VALUES ('$feature_name')";
								$result	= $GLOBALS['dbObj']->sql_query($query);
								
								$query	= 'SELECT LAST_INSERT_ID() AS uid';
								$result	= $GLOBALS['dbObj']->sql_query($query);
								$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
								
								$feature_id	= (int) $res['uid'];
							} else {
								$query	= "SELECT uid_feature  FROM features WHERE feature_name='$feature_name' LIMIT 0,1";
								$result	= $GLOBALS['dbObj']->sql_query($query);
								$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
								
								$feature_id	= (int) $res['uid_feature'];
							}
							
							$txt	.= '             '.$feature_name."\n";
							
							if ($board_id > 0 && $feature_id > 0 && $user_id > 0) {
								//Feature is set AND Board exists
								
								$query	= "SELECT COUNT(*) AS anz FROM board_features WHERE uid_board=$board_id AND uid_feature=$feature_id AND uid_user=$user_id";
								$result	= $GLOBALS['dbObj']->sql_query($query);
								$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
								
								$anz	= (int) $res['anz'];
								if ($anz == 0) {
									$query	= "INSERT INTO board_features (uid_board, uid_feature, uid_user, date_file, duplicate) VALUES ($board_id, $feature_id, $user_id, '$date_file', 'no')";
									
									$result	= $GLOBALS['dbObj']->sql_query($query);
									
									$query	= 'SELECT LAST_INSERT_ID() AS uid';
									$result	= $GLOBALS['dbObj']->sql_query($query);
									$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
									
									$rel_id	= (int) $res['uid'];
								} else {
									$query	= "INSERT INTO board_features (uid_board, uid_feature, uid_user, date_file, duplicate, comment) VALUES ($board_id, $feature_id, $user_id, '$date_file', 'yes', 'duplicate')";
									
									$result	= $GLOBALS['dbObj']->sql_query($query);
									
									$query	= 'SELECT LAST_INSERT_ID() AS uid';
									$result	= $GLOBALS['dbObj']->sql_query($query);
									$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
									
									$rel_id	= (int) $res['uid'];
								}
							}
						}
					}
				}
			}
		}
		
		return $txt;
	}
	
	// }}} import_license_array
	// {{{ import_file
	
	/**
	 * Function		import_file
	 *
	 * creates an listView for all Skills
	 *
	 * @param	string	$filepath:		the path to the file
	 * @param	string	$filemime:		the mime type of the file
	 * @param	string	$filetable:		(optional) the Name of the Database table to import the file
	 * 
	 * @access	public
	 * @static
	 */
	public static function import_file($filepath, $filemime, $filetable = 'files')
	{
		$filepath	= (string) $filepath;
		
		if ($filepath == '') {
			return false;
		}
		
		require_once (t3lib_extmgm::extPath('tm_classes', 'classes/Class_pfiletree/PFileTree.inc.php'));
		
		$file_id	= array();
		$cruser_id	= (int)		$GLOBALS['TSFE']->fe_user->user['uid'];
		$pid		= (int)		$GLOBALS['TSFE']->id;
		$time		= (int)		time();
		$filetable	= (string)	$filetable;
		$file_mime	= (string)	$filemime;
		
		if ($filetable == '') {
			$filetable = 'files';
		}
		
		//create Filetree Object
		$f			= new PFileTree();
		
		//create file list in directory
		$list		= $f->ListFiles($filepath, false, false);
		
		//var_dump($filetable);
		
		foreach ($list as $file_name => $file_props) {
			$file_name = (string) $file_name;
			
			if ((isset($file_props['ext']) && (string) $file_props['ext'] != 'php') || (!isset($file_props['ext']))) {
				//get path of file
				$file_path		= (string) $file_props['fullpath'];
				$file_basename	= (string) $file_props['basename'];
				$ext			= (string) $file_props['ext'];
				
				//get file properties
				$file_size	= (isset($file_props['size']) ? (int) $file_props['size'] : 0);
				$file_cr	= (isset($file_props['mdate']) ? (string) $file_props['mdate'] : null); //creation date of file
				$file_ch	= (isset($file_props['adate']) ? (string) $file_props['adate'] : null); //date of last modification
				
				if ($file_size > 0) {
					//file has content
					//read file into content var
					$datei	= fopen($file_path, 'rb');
					$data	= fread($datei, $file_size);
					$data	= addslashes($data);
					fclose($datei);
				} else {
					//file has no content
					//clear content var
					$data	= '';
				}
				
				//var_dump($data);
				
				$query		= 'SELECT COUNT(*) AS anz FROM '.$filetable.' WHERE file_name=\''.$file_basename.'\' AND file_mime=\''.$file_mime.'\' AND file_size='.$file_size;
				$result		= $GLOBALS['dbObj']->sql_query($query);
				
				//var_dump(mysql_error());
				
				$res		= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
				$anz		= (int) $res['anz'];
				
				//var_dump($anz);
				
				//write file into database
				if ($anz == 0) {
					$query	= 'INSERT INTO '.$filetable.' (file_name, file_mime, file_size, file, crdate, cruser_id, pid, lcdate, lcuser_id, source, md5_checksum) '
							. 'VALUES (\''.$file_basename.'\', \''.$file_mime.'\', '.$file_size.', \''.$data.'\', \''.$time.'\', '.$cruser_id.', '.$pid.', \''.$time.'\', '.$cruser_id.', \''.$file_path.'\', \''.md5($data).'\')';
					//var_dump($query);
					$result		= $GLOBALS['dbObj']->sql_query($query);
					//var_dump(mysql_error());
					$query		= 'SELECT LAST_INSERT_ID() AS uid';
					$result		= $GLOBALS['dbObj']->sql_query($query);
					$res		= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
					
					$file_id[]	= (int) $res['uid'];
				} else {
					$query	= 'SELECT uid FROM '.$filetable.' WHERE file_name=\''.$file_basename.'\' AND file_mime=\''.$file_mime.'\' AND file_size='.$file_size.' AND file=\''.$data.'\'';
					$result	= $GLOBALS['dbObj']->sql_query($query);
					$res	= $GLOBALS['dbObj']->sql_fetch_assoc2($result, false);
					
					$file_id[]	= (int) $res['uid'];
				}
				
				
			}
		}
		
		$file_id = implode(',', $file_id);
		
		return $file_id;
	}
	
	// }}} import_file
	// {{{ confirm_link
	
	/**
	 * Function		confirm_link
	 *
	 * creates an listView for all Skills
	 *
	 * @param	string	$str:			The Parent Class
	 * @param	string	$url:			(optional) an Url to jump to after 
	 * @param	boolean	$l:				(optional) The Parent Class
	 * @return	string					The content that should be displayed on the website
	 *
	 * @access	public
	 * @static
	 */
	public static function confirm_link($str, $url = '', $l = true)
	{
		$l		= (boolean) $l;
		$str	= (string) $str;
		$url	= (string) $url;
		
		$link	= '';
		
		if ( $url != '' ) {
			$url	= addslashes(htmlentities((string) $url));
			
			$link = 'javascript:confirm_delete(\''.$url.'\');';
			
			if ($l) {
				$link = '<a href="'.$link.'">'.$str.'</a>';
			} else {
				$link = $link . 'return false;';
			}
		}
		return $link;
	}
	
	// }}} confirm_link
	// {{{ confirm_form
	
	/**
	 * Function		confirm_form
	 *
	 * creates an listView for all Skills
	 *
	 * @return	string					The content that should be displayed on the website
	 *
	 * @access	public
	 * @static
	 */
	public static function confirm_form()
	{
		$link = 'javascript:confirm_delete();return false;';
		
		return $link;
	}
	
	// }}} confirm_form
	// {{{ create_confirm_link
	
	/**
	 * Function		create_confirm_link
	 *
	 * creates an listView for all Skills
	 *
	 * @return	string					The content that should be displayed on the website
	 *
	 * @access	public
	 * @static
	 */
	public static function create_confirm_link()
	{
		$confirm = '
		<script type="text/javascript">
			function confirm_delete( url ){
				var check = confirm(\'Wollen Sie diesen Datensatz wirklich löschen ?\');
				if ( check == true ){
					document.URL = url;
				}
				return false;
			}
		</script>';
		return $confirm;
	}
	
	// }}} create_confirm_link
	// {{{ create_confirm_form
	
	/**
	 * Function		create_confirm_form
	 *
	 * creates an listView for all Skills
	 *
	 * @param	string	$form_name:		the Name of an Form
	 * @return	string					The content that should be displayed on the website
	 *
	 * @access	public
	 * @static
	 */
	public static function create_confirm_form($form_name)
	{
		// add delete confirmation script in first row
		$confirm = '
		<script type="text/javascript">
			function confirm_delete(){
				var check = confirm(\'Wollen Sie diesen Datensatz wirklich löschen ?\');
				if ( check == true ){
					document.forms.'.(string) $form_name.'.submit();
				}
				return false;
			}
		</script>';
		return $confirm;
	}
	
	// }}} create_confirm_form
	// {{{ excel_column
	
	/**
	 * Function		excel_column
	 *
	 * creates an listView for all Skills
	 *
	 * @param	integer	$col_number:	the Column Number
	 * @return	string					The content that should be displayed on the website
	 *
	 * @access	public
	 * @static
	 */
	public static function excel_column($col_number)
	{
		$xls_columns	= array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P',
		'Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ',
		'AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
		'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ',
		'BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
		'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ',
		'CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
		'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ',
		'DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
		'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ',
		'EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ',
		'FA','FB','FC','FD','FE','FF','FG','FH','FI','FJ',
		'FK','FL','FM','FN','FO','FP','FQ','FR','FS','FT','FU','FV','FW','FX','FY','FZ',
		'GA','GB','GC','GD','GE','GF','GG','GH','GI','GJ',
		'GK','GL','GM','GN','GO','GP','GQ','GR','GS','GT','GU','GV','GW','GX','GY','GZ',
		'HA','HB','HC','HD','HE','HF','HG','HH','HI','HJ',
		'HK','HL','HM','HN','HO','HP','HQ','HR','HS','HT','HU','HV','HW','HX','HY','HZ',
		'IA','IB','IC','ID','IE','IF','IG','IH','II','IJ',
		'IK','IL','IM','IN','IO','IP','IQ','IR','IS','IT','IU','IV','IW','IX','IY','IZ',
		'KA','KB','KC','KD','KE','KF','KG','KH','KI','KJ',
		'KK','KL','KM','KN','KO','KP','KQ','KR','KS','KT','KU','KV','KW','KX','KY','KZ',
		'LA','LB','LC','LD','LE','LF','LG','LH','LI','LJ',
		'LK','LL','LM','LN','LO','LP','LQ','LR','LS','LT','LU','LV','LW','LX','LY','LZ',
		'MA','MB','MC','MD','ME','MF','MG','MH','MI','MJ',
		'MK','ML','MM','MN','MO','MP','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ',
		'NA','NB','NC','ND','NE','NF','NG','NH','NI','NJ',
		'NK','NL','NM','NN','NO','NP','NQ','NR','NS','NT','NU','NV','NW','NX','NY','NZ');
		
		return $xls_columns[(int) $col_number];
	}
	
	// }}} excel_column
	// {{{ picture_path
	
	/**
	 * Function		picture_path
	 *
	 * creates an listView for all Skills
	 *
	 * @param	string	$rel_pic_path:	relative path to the Root path of the extension
	 * @param	string	$ext_name:		(optional) the Name of an Extension
	 * @return	string					The content that should be displayed on the website
	 *
	 * @access	public
	 * @static
	 */
	public static function picture_path($rel_pic_path, $ext_name = 'tm_classes')
	{
		$rel_pic_path	= (string) $rel_pic_path;
		$ext_name		= (string) $ext_name;
		
		if ( $ext_name == '' || $rel_pic_path == '' ) {
			return '';
		}
		
		$abs_path	= t3lib_extmgm::extPath($ext_name, $rel_pic_path);
		
		$r			= explode('/', $_SERVER['PHP_SELF']);
		
		$dummy		= array_pop($r);
		$rel_path	= implode('/', $r);
		$abs_root	= $_SERVER['DOCUMENT_ROOT'] . $rel_path . '/';
		//var_dump($abs_root);
		$rel_path	= str_replace( $abs_root, '', $abs_path );
		
		return $rel_path;
	}
	
	// }}} picture_path
	// {{{ convert_to_utf8
	
	/**
	 * Function		convert_to_utf8
	 *
	 * creates an listView for all Skills
	 *
	 * @param	string	$DBName:		the Name of the Database to convert
	 *
	 * @access	public
	 * @static
	 */
	public static function convert_to_utf8($DBName)
	{
		$DBName	= (string) $DBName;
		
		$query	= 'SHOW TABLES FROM ' . $DBName;
		
		$res2	= $GLOBALS['TYPO3_DB']->sql_query($query);
		$anz2	= $GLOBALS['TYPO3_DB']->sql_num_rows($res2);
		for($j = 0; $j < $anz2; $j++ ) {
			$row2		= $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res2);
			$table_name	= $row2["Tables_in_$DBName"];
			
			$query		= "ALTER TABLE $table_name TYPE = INNODB";
			$res5		= $GLOBALS['TYPO3_DB']->sql_query($query);
			$query		= "ALTER TABLE $table_name DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
			$res6		= $GLOBALS['TYPO3_DB']->sql_query($query);
			
			$query		= "SHOW FULL COLUMNS FROM $table_name FROM $DBName";
			$res3		= $GLOBALS['TYPO3_DB']->sql_query($query);
			
			$anz3		= $GLOBALS['TYPO3_DB']->sql_num_rows($res3);
			
			for($k = 0; $k < $anz3; $k++ ) {
				$row3		= $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res3);
				$charset	= (string) $row3['Collation'];


				if ($charset != '') {
					$field		= (string) $row3['Field'];
					$type		= (string) $row3['Type'];

					$query		= "ALTER TABLE $table_name CHANGE `$field` `$field` $type CHARACTER SET utf8 COLLATE utf8_general_ci";
					$res4		= $GLOBALS['TYPO3_DB']->sql_query($query);
				}
			}
		}
	}
	
	// }}} convert_to_utf8
	// {{{ getTCA

	/**
	 * Function		getTCA
	 *
	 * Returns a Text from local language array using Arrays defined in TCA
	 *
	 * @param	object	$parent:		the Parent Class
	 * @param	string	$what:			name of the table field
	 * @param	integer	$id:			ID of the Item
	 * @param	string	$table:			name of the table
	 * @return	string					The Text based on TCA Information
	 *
	 * @since	version	0.0.11
	 * @access	public
	 * @static
	 */
	public static function getTCA($parent, $what, $id, $table)
	{
		$id		= (int)		$id;
		$what	= (string)	$what;
		$table	= (string)	$table;
		
		t3lib_div::loadTCA($table);
		$TCA	= $GLOBALS['TCA'][$table]['columns'][$what];
		
		return (string) self::getLLFromString($TCA['config']['items'][$id][0], $parent->LLkey);
	}

	// }}} getTCA
	// {{{ getFieldHeader
	
	/**
	 * Function     getFieldHeader
	 *
	 * Returns the label for a fieldname from local language array
	 *
	 * @param	pointer	$parent			the parent Class.
	 * @param	string	$item_key:		name of the table field
	 * @param	string	$table:			(optional) name of the table
	 * @param	string	$use_short:		(optional) TRUE, if an shortname should be 
	 *									used, Default: FALSE
	 * @return	string					The content that should be displayed on the website
	 *
	 * @since	version	0.0.13
	 * @static
	 * @access	public
	 */
	static public function getFieldHeader($parent, $item_key, $table = '', $use_short = false)
	{
		$item_key	= (string)	$item_key;
		$table		= (string)	$table;
		$use_short	= (boolean)	$use_short;
		$label		= '['.$item_key.']';
		
		$labelName	= 'listFieldHeader_'.$item_key . (($use_short === true) ? '_short' : '');
		
		if ( $table != '' && $table !== null ) {
			t3lib_div::loadTCA( $table );
			$TCA = $GLOBALS['TCA'][$table]['columns'][$item_key];
			
			if ( isset( $TCA['label'] ) ) {
				$labelName	= $TCA['label'] . (($use_short === true) ? '_short' : '');
				
				$label	= (string) self::getLLFromString( $labelName, $parent->LLkey );
				
				if ($use_short === true && $label == '') {
					$label	= self::getLLFromString( $TCA['label'], $parent->LLkey );;
				}
				
				$label .= ':';
				$label	= str_replace ('\n', '<br />', $label );
				$label	= str_replace ('::', '', $label );
				$label	= str_replace (':', '', $label );
			} else {
				$label	= $parent->pi_getLL( $labelName, $label );
			}
		} else {
			$label	= $parent->pi_getLL( $labelName, $label );
		}
		
		return (string) $label;
	}
	
	// }}} getFieldHeader
	// {{{ getFieldHelpText
	
	/**
	 * Function     getFieldHelpText
	 *
	 * Returns a help text for a fieldname from local language array
	 *
	 * @param	pointer	$parent			the parent Class.
	 * @param	string	$item_key:		name of the table field
	 * @param	string	$table:			(optional) name of the table
	 * @return	string					The content that should be displayed on the website
	 *
	 * @since	version	0.0.13
	 * @static
	 * @access	public
	 */
	static public function getFieldHelpText($parent, $item_key, $table = '')
	{
		$item_key	= (string) $item_key;
		$table		= (string) $table;
		$label		= '['.$item_key.']';
		
		$help		= (string) $parent->pi_getLL( 'listFieldHelpText_' . $item_key, $label );
		
		return $help;
	}
	
	// }}} getFieldHelpText
	// {{{ getFieldHeader_sortLink
	
	/**
	 * Function     getFieldHeader_sortLink
	 *
	 * Returns a sorting link for a column header
	 *
	 * @param	pointer	$parent			the parent Class.
	 * @param	string	$item_key:		name of the table field
	 * @param	string	$table:			(optional) name of the table
	 * @param	string	$use_short:		(optional) TRUE, if an shortname should be 
	 *									used, Default: FALSE
	 * @return	string					The fieldlabel wrapped in link that contains sorting vars
	 *
	 * @since	version	0.0.13
	 * @static
	 * @access	public
	 */
	static public function getFieldHeader_sortLink($parent, $item_key, $table = '', $use_short = false)
	{
		$item_key	= (string)	$item_key;
		$table		= (string)	$table;
		$use_short	= (boolean)	$use_short;
		
		return (string) $parent->pi_linkTP_keepPIvars(self::getFieldHeader($parent, $item_key, $table, $use_short), array('sort' => $item_key.':'.($parent->internal['descFlag']?0:1)), 0);
	}
	
	// }}} getFieldHeader_sortLink
	// {{{ FormName
	
	/**
	 * Function     FormName
	 *
	 * Returns a sorting link for a column header
	 *
	 * @param	string	$name:			Name and ID of the HTML-Element
	 * @return	string					the HTML-Code
	 *
	 * @since	version	0.0.14
	 * @static
	 * @access	public
	 */
	static public function FormName($name)
	{
		$name	= (string) $name;
		
		return ' name="' . $name . '" id="' . $name . '" ';
	}
	
	// }}} FormName
	// {{{ format_cash
	
	/**
	 * Function     format_cash
	 *
	 * tranformes an string that contains a cash value from database ready format "xxxx.xx" to display format "x.xxx,xx"
	 *
	 * @param	string	$value:			the content string
	 * @return	string					the formated content
	 *
	 * @static
	 * @access	public
	 */
	static public function format_cash($value)
	{
		$vals		= array();
		$sub_vals	= array();
		$vals		= explode( '.', $value );
		
		for ( $pos = strlen( $vals[0] ) - 3; $pos >= 0; $pos = $pos - 3 ) {
			$sub_vals[] = substr( $vals[0], $pos, 3 );
		}
		
		$sub_vals = array_reverse( $sub_vals );
		if ( $pos < 0 ) {
			$pos = $pos + 3;
		}
		
		$vals[0] = substr( $vals[0], 0, $pos );
		
		foreach ( $sub_vals as $cash ) {
			$vals[0] .= '.' . $cash;
		}
		
		$value = implode( ',', $vals );
		
		if ( substr( $value, 0, 1 ) == '.' ) {
			$value	= substr( $value, 1 );
		}
		
		return $value;
	}
	
	// }}} format_cash
	// {{{ renderWizard
	
	/**
	 * Function renderWizard
	 *
	 * renders date/datetime fields
	 * if Extension date2cal is not installed, an blank string will be returned
	 *
	 * @param	pointer	$parent			the parent Class.
	 * @param	array	$params			TCA informations about date/datetime field
	 * @param	object	$pObj			(optional) TCE forms object (not needed)
	 * @return	string					
	 *
	 * @author	Stefan	Galinski <stefan.galinski@frm2.tum.de>
	 * @see		Extension date2cal
	 *
	 * @static
	 * @access	public
	 */
	static public function renderWizard($parent, $params, $pObj = null)
	{
		$DateCalPath = t3lib_extmgm::extPath( 'date2cal', 'class.jscalendar.php' );
		
		if ( !is_file( $DateCalPath ) ) {
			return '';
		}
		
		require_once $DateCalPath;
		
		// set path regarding the typo3_mode
		$backPath	= $GLOBALS['BACK_PATH'];
		if (TYPO3_MODE == 'BE') {
			$backPath  .= '../';
		} elseif (TYPO3_MODE == 'FE') {
			$count		= 1;
			$backPath	= str_replace ( '../', '', $backPath, $count );
		}
		
		// get and prepare extension configuration
		self::$extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['date2cal']);
		self::$extConfig['firstDay'] = self::$extConfig['firstDay'] ? 1 : 0;
		
		self::$extConfig['calendarImg'] = t3lib_div::getFileAbsFileName(self::$extConfig['calendarImg']);
		
		if (!is_file(self::$extConfig['calendarImg'])) {
			self::$extConfig['calendarImg'] =
				t3lib_div::getFileAbsFileName('EXT:date2cal/res/calendar.png');
		}
		
		self::$extConfig['calendarImg'] = $backPath . str_replace(PATH_site, '',
			self::$extConfig['calendarImg']);
		
		if (!is_file(self::$extConfig['helpImg'])) {
			self::$extConfig['helpImg'] =
				t3lib_div::getFileAbsFileName('EXT:date2cal/res/helpIcon.gif');
		}
		
		self::$extConfig['helpImg'] = $backPath . str_replace(PATH_site, '',
			self::$extConfig['helpImg']);
		
		if (t3lib_div::int_from_ver(TYPO3_version) >= 4001000 && self::$extConfig['natLangParser']) {
			self::$typo41 = true;
		}
		
		if (TYPO3_MODE == 'BE') {
			// enabling of secondary options
			$groupOrUserProps = t3lib_BEfunc::getModTSconfig('', 'tx_date2cal');
			
			if ($groupOrUserProps['properties']['secOptionsAlwaysOn']) {
				$GLOBALS['BE_USER']->pushModuleData('xMOD_alt_doc.php', array('showPalettes' => 1));
			}
		}
		
		// get correct object
		$script = substr(PATH_thisScript, strrpos(PATH_thisScript, '/') + 1);
		
		if (t3lib_div::int_from_ver(TYPO3_version) >= 4000000 || $script == 'db_layout.php') {
			self::$jsObj		= &$GLOBALS['SOBE']->doc; // common for typo3 4.x and quick edit
			self::$jsObjType	= false;
		} elseif (is_object($GLOBALS['SOBE']->tceforms)) {
			self::$jsObj = &$GLOBALS['SOBE']->tceforms; // common for typo3 3.x
		} else {
			self::$jsObj = &$pObj; // palette (doesnt work with php4)
		}
		
		// add id attributes
		$checkboxId	= 'data_' . $params['table'] . '_' . $params['uid'] . '_' . $params['field'] . '_cb';
		$inputId	= $params['itemName'];
		
		$params['item'] = str_replace('<input type="checkbox"', '<input type="checkbox" ' .
			'id="' . $checkboxId . '"', $params['item']);
		$params['item'] = str_replace('<input type="text"', '<input type="text" ' .
			'id="' . $inputId . '"', $params['item']);
		
		// format definition
		$jsDate = 'typo3';
		//$jsDate = '%d-%m-%Y';
		
		if ($GLOBALS['TYPO3_CONF_VARS']['SYS']['USdateFormat']) {
			$jsDate = 'typo3US';
		}
		
		$format	= $jsDate;
		
		$relPath	= self::picture_path('res/helpPage.html', 'date2cal');
		
		// build "jscalendar with datetime_toolbocks ext" options
		$options = array(
			'inputField'	=> '\'' . $inputId . '\'',
			'checkboxField'	=> '\'' . $checkboxId . '\'',
			'ifFormat'		=> '\'' . $jsDate . '\'',
			'button'		=> '\'' . $inputId . '_trigger\'',
			'helpPage'		=> '\'' . $relPath . '\'',
			'format'		=> '\'' . $format . '\'',
			'firstDay'		=> self::$extConfig['firstDay']
		);
		
		if(t3lib_div::inList($params['wConf']['evalValue'], 'datetime')) {
			$options['showsTime']	= true;
			$options['time24']		= true;
		}
		
		// prefered language
		$lang = '';
		
		if (TYPO3_MODE == 'BE') {
			$groupOrUserProps = t3lib_BEfunc::getModTSconfig(self::$pageinfo['uid'], 'tx_date2cal');
			if (!empty($groupOrUserProps['properties']['prefLang'])) {
				$lang = $groupOrUserProps['properties']['prefLang'];
			}
		}
		
		if (TYPO3_MODE == 'FE') {
			$GLOBALS['LANG']	= new tslib_fe($GLOBALS['TYPO3_CONF_VARS'], t3lib_div::_GP('id'), t3lib_div::_GP('type'));
		}
		//var_dump($GLOBALS['LANG']);
		
		// init jscalendar class
		$jscalendar = new jscalendar($options, self::$extConfig['calendarCSS'], $lang, 'de', self::$typo41);
		
		// image title labels
		if (TYPO3_MODE == 'BE') {
			$calImgTitle	= $GLOBALS['LANG']->sL('LLL:EXT:date2cal/locallang.xml:calendar_wizard');
			$helpImgTitle	= $GLOBALS['LANG']->sL('LLL:EXT:date2cal/locallang.xml:help');
		} else {
			$calImgTitle	= self::getLLFromString('LLL:EXT:date2cal/locallang.xml:calendar_wizard', $parent->LLkey);
			$helpImgTitle	= self::getLLFromString('LLL:EXT:date2cal/locallang.xml:help', $parent->LLkey);
		}
		
		// generate calendar code
		$params['item'] .= '<img class="calendarImg" src="' . self::$extConfig['calendarImg'] . '" ' .
			'id="' . $inputId . '_trigger" style="cursor: pointer;" ' .
			'title="' . $calImgTitle . '" alt="' . $calImgTitle . '" />' . "\n";
		
		if (self::$typo41) {
			$params['item'] .= '<img class="helpImg" src="' . self::$extConfig['helpImg'] . '" ' .
				'id="' . $inputId . '_help" style="cursor: pointer;" ' .
				'title="' . $helpImgTitle . '" alt="' . $helpImgTitle . '" />' . "\n";
		}
		
		$params['item'] .= $jscalendar->getItemJS();	
		
		// initialisation code of jscalendar
		$jsCode = $jscalendar->getJS();
		if ( empty($jsCode) ) {
			return $params['item'];
		}
		
		if (TYPO3_MODE == 'FE') {
			return $jsCode . $params['item'];
		} /*elseif (!$this->jsObjType) {
			$this->jsObj->JScode .= $jsCode;
			
			return $this->jsObj->JScode;
		} else {
			$this->jsObj->additionalCode_pre['date2cal'] = $jsCode;
			
			return 
		}
		*/
	}
	
	// }}} renderWizard
	// {{{ getLLFromString
	
	/**
	 * Function getLLFromString
	 *
	 * searches an Text inside an Laguage Array
	 *
	 * @param	string	$string			Text which includes the File name and the Key name
	 * @param	string	$LLkey			(optional) the Language Key
	 * @return	string					
	 *
	 * @static
	 * @access	public
	 */
	static public function getLLFromString($string, $LLkey = 'default')
	{
		$string_x	= explode( ':', $string );
		//var_dump($string_x);
		$LLkey		= (string) $LLkey;
		//var_dump($LLkey);
		$pathToFile	= (string) $string_x[1] . ':' . (string) $string_x[2];
		$ll_key		= (string) $string_x[3];
		
		//Read file
		$LOCAL_LANG	= t3lib_div::readLLfile( $pathToFile, $LLkey );
		//var_dump($LOCAL_LANG);
		$txt		= self::getLLL( $ll_key, $LOCAL_LANG, $LLkey );
		
		return $txt;
	}

	// }}} getLLFromString
	// {{{ getLLL
	
	/**
	 * Function getLLL
	 *
	 * searches an Text inside an Laguage Array
	 *
	 * @param	string	$index			the Index for the Language Text
	 * @param	array	$LOCAL_LANG		the Language array which stores all Information
	 * @param	string	$LLkey			(optional) the Language Key
	 * @return	string					
	 *
	 * @static
	 * @access	public
	 */
	static public function getLLL($index, $LOCAL_LANG, $LLkey = 'default')
	{
		$index	= (string) $index;
		//var_dump($LOCAL_LANG);
		if ( $index == '' || !is_array( $LOCAL_LANG ) ) {
			return '';
		}
		
		$LLkey	= (string) $LLkey;
		
		$LLL	= $LOCAL_LANG[$LLkey][$index];
		
		if ( $LLkey != 'default' ) {
			$LLL_dummy	= $LOCAL_LANG['default'][$index];
			
			if ( $LLL === null && $LLL_dummy !== null && $LLL_dummy != '' ) {
				$LLL	= $LLL_dummy;
			}
		}
		
		return (string) $LLL;
	}

	// }}} getLLL
	// {{{ parse_ini
	
	/**
	 * Function		parse_ini
	 *
	 * reads an inifile
	 *
	 * @param	string	$filepath:		the path of an directory there the license files are
	 * 
	 * @access	public
	 * @static
	 * @author	goulven.ch AT gmail DOT com
	 * @see		http://de3.php.net/manual/de/function.parse-ini-file.php#78815
	 */
	public static function parse_ini($filepath)
	{
	    $ini = file($filepath);
		
	    if ($ini === false || count($ini) == 0) {
			return array();
		}
		
	    return self::parse_ini_array($ini);
	}
	
	// }}} parse_ini
	// {{{ parse_ini_text
	
	/**
	 * Function		parse_ini_text
	 *
	 * reads an inifile
	 *
	 * @param	string	$initext:		the content like from an ini-file
	 * 
	 * @access	public
	 * @static
	 */
	public static function parse_ini_text($initext)
	{
	    if (!is_string($initext)) {
			return array();
		}
		
		$ini = explode("\n", $initext);
		
		if (!is_array($ini) || count($ini) == 0) {
			return array();
		}
		
	    return self::parse_ini_array($ini);
	}
	
	// }}} parse_ini_text
	// {{{ parse_ini_array
	
	/**
	 * Function		parse_ini_array
	 *
	 * parses an array with content from an ini-file
	 *
	 * @param	array	$ini:			the path of an directory there the license files are
	 * 
	 * @access	public
	 * @static
	 * @author	goulven.ch AT gmail DOT com
	 * @see		http://de3.php.net/manual/de/function.parse-ini-file.php#78815
	 */
	public static function parse_ini_array($ini)
	{
	    if (!is_array($ini) || count($ini) == 0) {
			return array();
		}
		
	    $sections	= array();
	    $values		= array();
	    $globals	= array();
		$result		= array();
	    $i = 0;
		
	    foreach ($ini as $line) {
	        $line = trim($line);
			
	        // skip Comments
	        if ($line == '' || $line{0} == ';' ) {
				continue;
			}
			
	        // Sections
	        if ($line{0} == '[') {
	            $sections[] = substr($line, 1, -1);
	            $i++;
	            continue;
	        }
			
	        // Key-value pair
	        $pair = explode('=', $line, 2);
			
	        $key	= trim($pair[0]);
			if (isset($pair[1])) {
				$value	= trim($pair[1]);
			} else {
				$value	= '';
			}
	        if ($i == 0) {
	            // Array values
	            if (substr($line, -1, 2) == '[]') {
	                $globals[ $key ][] = $value;
	            } else {
	                $globals[ $key ] = $value;
	            }
	        } else {
	            // Array values
	            if (substr($line, -1, 2) == '[]') {
	                $values[ $i - 1 ][ $key ][] = $value;
	            } else {
	                $values[ $i - 1 ][ $key ] = $value;
	            }
	        }
	    }
		
	    for ($j = 0; $j < $i; $j++) {
	        $result[ $sections[ $j ] ] = $values[ $j ];
	    }
		
	    return array_merge($result, $globals);
	}
	
	// }}} parse_ini_array
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