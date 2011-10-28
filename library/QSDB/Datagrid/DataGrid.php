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
 * @file		AjaxDataGrid.class.php
 * @created		Dec 28, 2006
 * @version		1.1
 * @author		Hugo Weijes    <fx122@yahoo.com>
 * @author		Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright	2007 Telemotive AG, Germany, Munich
 * @license		http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since		Version 1.1
 * @see			http://www.phpclasses.org/browse/package/3610.html
 */

// {{{ GLOBALS

/**
 * Global Variables:
 * $DataGrid_InstanceCount counts instances of this class (to generate unique $JsClass names)
 * $DataGrid_JsIncluded set to true after the Js includes have been output to the page
 */

// }}}
// {{{ DataGrid

/**
 * DataGrid Functions
 *
 * An AJAX enabled datagrid with pagewise scrolling, column sorting, and in-place
 * editing of data cells with textbox, textarea, select, and checkbox controls. 
 *
 * @category	misc
 * @package		TYPO3
 * @subpackage	tm_classes
 * @file		AjaxDataGrid.class.php
 * @author		Hugo Weijes    <fx122@yahoo.com>
 * @author		Thomas Mueller <thomas.mueller@telemotive.de> TMu
 * @copyright	2007 Telemotive AG, Germany, Munich
 * @license		http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since		Version 1.1
 *
 * @changes
 * 20071110		TMu	- the functions 'ersetze' and 'format_cash' are deleted
 *					  in this Class
 *					- function 'erstze' is used from Class 'QSDB_functions'
 *					- function 'format_cash' is used from Class 'QSDB_functions'
 * 20071111		TMu	- new public Variable $class->dbKey
 *					  for Using with Select Fields to connect to the Database
 */

class QSDB_DataGrid
{
	// {{{ properties
	
	/**
     * one based position of start data page
     *
     * @var			integer
	 * @access		public
     */
	public $pos;
	
	/**
     * total number of records in all data (not just current page)
     *
     * @var			integer
	 * @access		public
     */
	public $poscnt;
	
	/**
     * paging size
     *
     * @var			integer
	 * @access		public
     */
	public $pospage;
	
	/**
     * the Class Attribute for the Use inside the Javascript
	 * javascript class (variable) name and html id prefix
     *
     * @var			string
	 * @access		public
     */
	public $JsClass = 'te';
	
	/**
     * all Data to display
     *
     * The datapage contains a multidimensional array that consists of the data for the table.
	 *	It should be in the following format:
	 *		In the primary array, each element should have a key equal to the row id and the value is
	 *		a sub array that contains column data.
	 *		
	 *		The column data subarray should have key values that are the column values from the db and the values
	 *		are the data to be displayed.
	 *		
	 *	An example would be:
	 *		[1] => array(
	 *				[Name]		=> 'Some Guy'
	 *				[Address]	=> '123 Some Street'
	 *				[Phone]		=> '123-123-1234'
	 *			)
	 *		[2] => array(
	 *				[Name]		=> 'Some Girl'
	 *				[Address]	=> '321 Some Drive'
	 *				[Phone]		=> '987-987-9876'
	 *			}
	 *		etc.
     *
     * @var			array
	 * @access		public
     */
	public $data = array();
	
	/**
     * all Values for the X-Axis
     *
     * @var			string
	 * @access		public
     */
	public $RequestFile = '';
	
	/**
     * the Path to this File
     *
     * @var			string
	 * @access		public
     */
	public $relpath = '';
	
	/**
     * if TRUE, it is possible to update the Data in the Table
     *
     * @var			boolean
	 * @access		public
     */
	public $option_db_allow_update = false;
	
	/**
     * the Link to add a new Data Row
     *
     * @var			string
	 * @access		private
     */
	private $add_link = '';
	
	/**
     * all Columns for the Table
     *
     * @var			array
	 * @access		private
     */
	private $columns = array();
	
	/**
     * all Attributes for the Table
     *
     * @var			array
	 * @access		public
     */
	public $tattrib = array();
	
	/**
     * all Attributes for Even-Rows
     *
     * @var			array
	 * @access		public
     */
	public $oddattrib = array();
	
	/**
     * the HTML-Code for Odd-Rows
     *
     * @var			string
	 * @access		private
     */
	private $odd = '<tr>';
	
	/**
     * all Attributes for Even-Rows
     *
     * @var			array
	 * @access		public
     */
	public $evenattrib = array();
	
	/**
     * the HTML-Code for Even-Rows
     *
     * @var			string
	 * @access		private
     */
	private $even = '<tr>';
	
	/**
     * all Attributes for the Table Header
     *
     * @var			array
	 * @access		public
     */
	public $headerattrib = array();
	
	/**
     * the Array Key to Access the Database for the Select Fields
	 * the Database Handler must be a Instance of Class tslib_pibase and must created before using
     *
     * @var			string
	 * @access		public
     */
	public $dbKey		= 'TYPO3_DB';
	
	// }}}
	// {{{ __construct
	
	/**
	 * Function DataGrid
	 * 
	 * This is the Constructor in this Class
	 *
	 * @param	array		$data:		the Width of the Chart
	 * @param	string		$RequestFile:the Height of the Chart
	 * 
	 * @access	public
	 */
	public function __construct($data = '', $RequestFile = '')
	{
	    global $DataGrid_InstanceCount;
		
	    $DataGrid_InstanceCount++;
	    $this->JsClass	.= $DataGrid_InstanceCount;
		
	    if ( $data ) {
			$this->data	= $data;
		}
		
	    if ( $RequestFile ) {
			$this->RequestFile	= (string) $RequestFile;
		} else {
			$this->RequestFile	= (string) $_SERVER['PHP_SELF'];
		}
	}
	
	// }}}
	// {{{ HtmlId
	
	/**
	 * Function HtmlId
	 * 
	 * generates an ID for the HTML-Element from Row and Column
	 *
	 * @param	mixed		$rowid:		Name or ID of the Table row
	 * @param	mixed		$colid:		Name or ID of the Table column
	 * @return	string		the HTML-ID
	 * 
	 * @access	public
	 */
	private function HtmlId($rowid, $colid)
	{
		return (string) $this->JsClass . '.' . (string) $rowid . '.' . (string) $colid;
	}
	
	// }}}
	// {{{ AddColumnReadonly
	
	/**
	 * Function AddColumnReadonly
	 * 
	 * adds a Readonly Text Column
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * 
	 * @access	public
	 */
	public function AddColumnReadonly($colname, $coltitle)
	{
		$this->columns[]	= array(
			'colname'	=>	(string) $colname,
			'coltitle'	=>	(string) $coltitle,
			'coltype'	=>	'readonly'
		);
	}
    
	// }}}
	// {{{ AddColumnReadonlyNumber
	
	/**
	 * Function AddColumnReadonlyNumber
	 * 
	 * adds a Readonly Number Column
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * 
	 * @access	public
	 */
	public function AddColumnReadonlyNumber($colname, $coltitle)
	{
		$this->columns[]	= array(
			'colname'	=>	(string) $colname,
			'coltitle'	=>	(string) $coltitle,
			'coltype'	=>	'readonlynumber'
		);
	}
    
	// }}}
	// {{{ AddColumnHidden
	
	/**
	 * Function AddColumnHidden
	 * 
	 * adds a hidden Column
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * 
	 * @access	public
	 */
	public function AddColumnHidden($colname = '', $coltitle = '')
	{
		$this->columns[]	= array(
			'colname'	=>	(string) $colname,
			'coltitle'	=>	(string) $coltitle,
			'coltype'	=>	'hidden'
		);
	}
    
	// }}}
	// {{{ AddColumnText
	
	/**
	 * Function AddColumnText
	 * 
	 * adds a Text Column
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * 
	 * @access	public
	 */
	public function AddColumnText($colname, $coltitle)
	{
		$this->columns[]	= array(
			'colname'	=>	(string) $colname,
			'coltitle'	=>	(string) $coltitle,
			'coltype'	=>	'text'
		);
	}
    
	// }}}
	// {{{ AddColumnNumber
	
	/**
	 * Function AddColumnNumber
	 * 
	 * adds a Number Column
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * 
	 * @access	public
	 */
	public function AddColumnNumber($colname, $coltitle)
	{
		$this->columns[]	= array(
			'colname'	=>	(string) $colname,
			'coltitle'	=>	(string) $coltitle,
			'coltype'	=>	'number'
		);
	}
    
	// }}}
	// {{{ AddColumnCheckbox
	
	/**
	 * Function AddColumnCheckbox
	 * 
	 * adds a Column to display Checkboxes
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * 
	 * @access	public
	 */
	public function AddColumnCheckbox($colname, $coltitle)
	{
		$this->columns[]	= array(
			'colname'	=>	(string) $colname,
			'coltitle'	=>	(string) $coltitle,
			'coltype'	=>	'checkbox'
		);
	}
    
	// }}}
	// {{{ AddColumnSelect
	
	/**
	 * Function AddColumnSelect
	 * 
	 * adds a Column to display a Select List froma Value list
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * @param	array		$selectvalues:	the values for the Select list
	 * 
	 * @access	public
	 */
	public function AddColumnSelect($colname, $coltitle, $selectvalues)
	{
		if ( isset( $GLOBALS[$this->dbKey] ) ) {
			if ( !is_array( $selectvalues ) ) {
				$selectvalues	= $this->db_array( $selectvalues );
			}
			
			$this->columns[]	= array(
				'colname'	=>	(string) $colname,
				'coltitle'	=>	(string) $coltitle,
				'coltype'	=>	'select',
				'selectvalues'	=>	$selectvalues
			);
		}
	}
    
	// }}}
	// {{{ AddColumnSelectkey
	
	/**
	 * Function AddColumnSelectkey
	 * 
	 * adds a Column to display a Select List from a Key list
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * @param	array		$selectvalues:	the Key values for the Select list
	 * 
	 * @access	public
	 */
	public function AddColumnSelectkey($colname, $coltitle, $selectvalues)
	{
		if ( isset( $GLOBALS[$this->dbKey] ) ) {
			if ( !is_array( $selectvalues ) ) {
				$selectvalues	= $this->db_assoc( $selectvalues );
			}
			
			$this->columns[]	= array(
				'colname'	=>	(string) $colname,
				'coltitle'	=>	(string) $coltitle,
				'coltype'	=>	'selectkey',
				'selectvalues'	=>	$selectvalues
			);
		}
	}
    
	// }}}
	// {{{ AddColumnTextarea
	
	/**
	 * Function AddColumnTextarea
	 * 
	 * adds a Column to display a Textarea
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * @param	integer		$width:		the Width for the Textarea
	 * @param	integer		$height:	the Height for the Textarea
	 * 
	 * @access	public
	 */
	public function AddColumnTextarea($colname, $coltitle, $width, $height)
	{
		$this->columns[]	= array(
			'colname'	=>	(string) $colname,
			'coltitle'	=>	(string) $coltitle,
			'coltype'	=>	'textarea',
			'style'		=>	'width:' . (int) $width . 'px; height:' . (int) $height . 'px;'
		);
	}
	
	// }}}
	// {{{ AddColumnLink
	
	/**
	 * Function AddColumnLink
	 * 
	 * adds a Column to display Links
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * @param	string		$target:	the Target Property for the Link
	 * 
	 * @access	public
	 */
	public function AddColumnLink($colname, $coltitle = '', $target = '')
	{
		$this->columns[]	= array(
			'colname'	=>	(string) $colname,
			'coltitle'	=>	(string) $coltitle,
			'coltype'	=>	'link',
			'target'	=>	(string) $target
		);
	}
	
	// }}}
	// {{{ AddColumnPicture
	
	/**
	 * Function AddColumnPicture
	 * 
	 * adds a Column to display Pictures
	 * for YES/NO Fields only
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * @param	boolean		$invert:	if TRUE, the Pictures will be inverted
	 * @param	string		$OKmessage:	Message for the Title Property, if OK
	 * @param	string		$NOKmessage:Message for the Title Property, if NOK
	 * 
	 * @access	public
	 */
	public function AddColumnPicture($colname, $coltitle = '', $invert = false, $OKmessage = 'OK', $NOKmessage = 'NOK')
	{
		$this->columns[]	= array(
			'colname'	=>	(string) $colname,
			'coltitle'	=>	(string) $coltitle,
			'coltype'	=>	'picture',
			'invert'	=>	(boolean) $invert,
			'OKMessage'	=>	(string) $OKmessage,
			'NOKMessage'=>	(string) $NOKmessage
		);
	}
	
	// }}}
	// {{{ AddColumnDate
	
	/**
	 * Function AddColumnDate
	 * 
	 * adds a Column to display Date Values
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * 
	 * @access	public
	 */
	public function AddColumnDate($colname, $coltitle = '')
	{
		$this->columns[]	= array(
			'colname'	=>	(string) $colname,
			'coltitle'	=>	(string) $coltitle,
			'coltype'	=>	'date'
		);
	}
	
	// }}}
	// {{{ AddColumnCash
	
	/**
	 * Function AddColumnCash
	 * 
	 * adds a Column to display Cash Values
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * 
	 * @access	public
	 */
	public function AddColumnCash($colname, $coltitle = '')
	{
		$this->columns[]	= array(
			'colname'	=>	(string) $colname,
			'coltitle'	=>	(string) $coltitle,
			'coltype'	=>	'cash'
		);
	}
	
	// }}}
	// {{{ AddColumnOther
	
	/**
	 * Function AddColumnOther
	 * 
	 * adds a Column for other Information
	 *
	 * @param	string		$colname:	the Name for the Column
	 * @param	string		$coltitle:	the Title for the Column
	 * @param	string		$table:		the Data Table, which stores the Data to display
	 * @param	pointer		$obj:		a Parent Object
	 * 
	 * @access	public
	 */
	public function AddColumnOther($colname, $coltitle = '', $table = '', $obj = null)
	{
		$this->columns[]	= array(
			'colname'	=>	(string) $colname,
			'coltitle'	=>	(string) $coltitle,
			'coltype'	=>	'other',
			'table'		=>	(string) $table,
			'obj'		=>	$obj
		);
	}
	
	// }}}
	// {{{ db_array
	
	/**
	 * Function db_array
	 * 
	 * fetches data from the Database and stores them into an Array
	 *
	 * @param	string		$sql:		the SQL-Query to fetch the Data
	 * @return	array		the Data Array
	 * 
	 * @access	private
	 */
	private function db_array($sql)
	{
	    $arr	= array();
		
		if ( $GLOBALS[$this->dbKey] ) {
		    $result	= $GLOBALS[$this->dbKey]->sql_query( (string) $sql );
		    
			while ( $row = $GLOBALS[$this->dbKey]->sql_fetch_row( $result ) ) {
				$arr[]	= $row[0];
			}
		}
		
	    return $arr;
	}
	
	// }}}
	// {{{ db_assoc
	
	/**
	 * Function db_assoc
	 * 
	 * fetches data from the Database and stores them into an Array
	 *
	 * @param	string		$sql:		the SQL-Query to fetch the Data
	 * @return	array		the Data Array
	 * 
	 * @access	public
	 */
	private function db_assoc($sql)
	{
		$arr	= array();
		if ( $GLOBALS[$this->dbKey] ) {
		    $result	= $GLOBALS[$this->dbKey]->sql_query( (string) $sql );
		    
			while ( $row = $GLOBALS[$this->dbKey]->sql_fetch_assoc( $result ) ) {
				$arr[$row[0]]	= $row[1];
			}
		}
		
		return $arr;
	}
	
  	// }}}
	// {{{ SetEvenRowAttribs
	
	/**
	 * Function SetEvenRowAttribs
	 * 
	 * sets the Row Attributes for Even-Rows
	 *
	 * @param	array		$attrib:	an assoziated array for Attribute/Value pairs
	 * 
	 * @access	public
	 */
	public function SetEvenRowAttribs(array $attrib)
	{
		if ( is_array( $attrib ) ) { 
			$this->evenattrib = $attrib;
			$this->evenTR();
		}
	}
	
	// }}}
	// {{{ SetOddRowAttribs
	
	/**
	 * Function SetOddRowAttribs
	 * 
	 * sets the Row Attributes for Odd-Rows
	 *
	 * @param	array		$attrib:	an assoziated array for Attribute/Value pairs
	 * 
	 * @access	public
	 */
	public function SetOddRowAttribs(array $attrib)
	{
		if ( is_array( $attrib ) ) { 
			$this->oddattrib = $attrib;
			$this->oddTR();
		}
	}
	
	// }}}
	// {{{ SetTableAttribs
	
	/**
	 * Function SetTableAttribs
	 * 
	 * sets the Table Attributes
	 *
	 * @param	array		$attrib:	an assoziated array for Attribute/Value pairs
	 * 
	 * @access	public
	 */
	public function SetTableAttribs(array $attrib)
	{
		if ( is_array( $attrib ) ) { 
			$this->tattrib = $attrib;
		}
	}
	
	// }}}
	// {{{ SetHeaderAttribs
	
	/**
	 * Function SetHeaderAttribs
	 * 
	 * sets the Attributes for the Table Header
	 *
	 * @param	array		$attrib:	an assoziated array for Attribute/Value pairs
	 * 
	 * @access	public
	 */
	public function SetHeaderAttribs(array $attrib)
	{
		if ( is_array( $attrib ) ) { 
			$this->headerattrib = $attrib;
		}
	}
	
	// }}}
	// {{{ oddTR
	
	/**
	 * Function oddTR
	 * 
	 * creates the Start-Tag for Odd-Rows
	 *
	 * @access	private
	 */
	private function oddTR()
	{
		$html = '<tr';
		
		foreach ( $this->oddattrib as $key => $value ) {
			$html .= " $key=\"$value\"";
		}
		
		$html .= '>';
		$this->odd = $html;
	}
	
	// }}}
	// {{{ evenTR
	
	/**
	 * Function evenTR
	 * 
	 * creates the Start-Tag for Even-Rows
	 * 
	 * @access	private
	 */
	private function evenTR()
	{
		$html = '<tr';
		
		foreach ( $this->evenattrib as $key => $value ) {
			$html .= " $key=\"$value\"";
		}
		
		$html .= '>';
		$this->even = $html;
	}
	
	// }}}
	// {{{ GenerateTable
	
	/**
	 * Function GenerateTable
	 * 
	 * returns <span> tag with table
	 *
	 * @param	string		$classes:	the CSS-Class for the Table, Rows, Cells ...
	 * @return	string		the HTML-Code for the complete Table
	 * 
	 * @access	public
	 */
	public function GenerateTable($classes = 'qsdb')
	{
		$JsClass	= $this->JsClass;
		
		//generate table first, this creates $column (if not predefined). $column is referenced by GenerateJS)
		$s			= $this->GenerateTableSpan( $classes );
		
		//include JS
		return $this->GenerateJS() . "<span class=\"$classes\" id=\"$JsClass-span\">\n$s</span>\n";
	}
	
	// }}}
	// {{{ GenerateTableSpan
	
	/**
	 * Function GenerateTableSpan
	 * 
	 * returns content of the table <span> tag (this part is reloaded on scrolling the table)
	 *
	 * @param	string		$classes:	the CSS-Class for the Table, Rows, Cells ...
	 * @return	string		the HTML-Code for the complete Table
	 * 
	 * @access	private
	 */
	private function GenerateTableSpan($classes = 'qsdb')
	{
		$JsClass	= $this->JsClass;
		
		$table		= '';
		
		//build the table opener
		$table .= "\t<form class=\"$classes\" action=\"\" method=\"post\">\n";
		$table .= "\t\t<fieldset class=\"$classes\">\n";
		$table .= "\t\t\t<legend class=\"$classes\"></legend>\n";
		$table .= "\t\t\t<table id=\"$JsClass.table\" class=\"$classes\">\n";
		
		$dummy  = $this->GenerateTableBody( $classes );
		
		//nav
		$nav =	"\t\t\t\t<tr class=\"nav\">\n";
		$colcnt = 0;
		foreach ( $this->columns as $col ) {
			if ( $col['coltype'] != 'hidden' ) {
				$colcnt++;
			}
		}
		
		$nav .= "\t\t\t\t\t<td class=\"nav\" colspan=\"$colcnt\">\n";
		$nav .= $this->GenerateNav($classes);
		$nav .= "</td>\n\t\t\t\t</tr>\n";
		
		$table .= $dummy.$nav."\t\t\t</table>\n\t\t</fieldset>\n\t</form>";
		
		return $table;
	}
	
	// }}}
	// {{{ GenerateNav
	
	/**
	 * Function GenerateNav
	 * 
	 * generates the table navigation and busy indicator
	 *
	 * @param	string		$classes:	the CSS-Class for the Table, Rows, Cells ...
	 * @return	string		the HTML-Code for the complete Table
	 * 
	 * @access	private
	 */
	private function GenerateNav($classes = 'qsdb')
	{
		$JsClass	= $this->JsClass;
		
		$pos		= $this->pos; //current position 1-based
		if ( $pos < 1 ) {
			$pos	= 1;
		}
		
		$posto		= $pos + count( $this->data ) - 1;	//last pos in current page
		$pospage	= $this->pospage;					//page length
		$posprev	= $pos - $pospage;					//start pos of prev page
		if ( $posprev < 1 ) {
			$posprev = 1;
		}
		$posnext	= $pos + $pospage;					//start pos of next page
		$poscnt		= $this->poscnt;					//total number of records
		$poslast	= floor( ( $poscnt - 1 ) / $pospage ) * $pospage + 1; //start pos of last page
		if ( $posnext > $poslast ) {
			$posnext = $poslast;
		}
		
		$table .= "\t\t\t\t\t<span class=\"nav-editlinks $classes\">\n";
		if( $this->add_link != '' ){
			$table .= "\t\t\t\t\t\t" . $this->add_link . "\n";
		}
		$table .= "\t\t\t\t\t</span>\n";
		
		//build table navigator
		$table .= "\t\t\t\t\t<span class=\"nav $classes\">\n";
		$table .= "\t\t\t\t\t\t<span class=\"nav-links $classes\">\n";
		
		//only if number of record is greater then number of records on one page
		if ( $poscnt > $pospage ) {
			$table .= "\t\t\t\t\t\t\t" . ($pos > 1 ? "<a onclick=\"dg_move($JsClass,1)\">|&lt;</a>" : '|&lt;' ) . "\n";
			$table .= "\t\t\t\t\t\t\t" . ($pos > 1 ? "<a onclick=\"dg_move($JsClass,$posprev)\">&lt;&lt;</a>" : '&lt;&lt;' ) . "\n";
			$table .= "\t\t\t\t\t\t\t" . ($pos < $poslast ? "<a onclick=\"dg_move($JsClass,$posnext)\">&gt;&gt;</a>" : '&gt;&gt;' ) . "\n";
			$table .= "\t\t\t\t\t\t\t" . ($pos < $poslast ? "<a onclick=\"dg_move($JsClass,$poslast)\">&gt;|</a>" : '&gt;|' ) . "\n";
		}
		$table .= "\t\t\t\t\t\t</span>\n";
		$table .= "\t\t\t\t\t\t<span id=\"$JsClass.navtext\" class=\"nav-text $classes\">zeige Datens&auml;tze $pos bis $posto von $poscnt</span>\n";
		$table .= "\t\t\t\t\t\t<span id=\"$JsClass.navbusy\" class=\"nav-busy $classes\"></span>\n";
		$table .= "\t\t\t\t\t</span>\n";
		$table .= "\t\t\t\t\t<br />\n";
		
		return $table;
	}
	
	// }}}
	// {{{ GenerateTableBody
	
	/**
	 * Function GenerateTableBody
	 * 
	 * generates the table header and data rows
	 *
	 * @param	string		$classes:	the CSS-Class for the Table, Rows, Cells ...
	 * @return	string		the HTML-Code for Table Header and Data Rows
	 * 
	 * @access	private
	 */
	private function GenerateTableBody($classes='qsdb')
	{
		$colcnt		= 0;
		$JsClass	= $this->JsClass;
		//rowid is first column
		
		//get column count from this->columns
		
		$colcnt = count( $this->columns );
		if ( $colcnt == 0 ) {
			//else get column count from first datarow and build columns headers
			foreach ( current( $this->data ) as $k => $v ) {
				if ( count( $this->columns ) == 0 ) {
					$this->AddColumnReadonly( $k, $k );
				} else {
					$this->AddColumnText( $k, $k );
				}
			}
			$colcnt = count( $this->columns );
		}
		
		//build the header section
		$c = 0;
		$s = "\t\t\t\t<tr";
		if ( !empty( $this->headerattrib ) ) {
			foreach ( $this->headerattrib as $k => $v ) {
				$s .= " $k=\"$v\"";
			}
		}
		$s .= ">\n";
		
		foreach ( $this->columns as $k => $v ) {
			if ( $v['coltype'] != 'hidden' && $v['coltype'] != 'link' ) {
				$dummy1 = addslashes($v['colname']);
				$dummy2 = addslashes($v['coltitle']);
				
				$self = '?' . $_SERVER['QUERY_STRING'];
				
				$s .= "\t\t\t\t\t<th class=\"$classes\" onclick=\"dg_onHeadClick($this->JsClass,'$dummy1')\">$dummy2</th>\n";
			}
			
			$c++;
		}
		
 		while ( $c < $colcnt ) {
 			$s .= "\t\t\t\t\t<th>&nbsp;</th>\n";
 			$c++;
 		}
		$s .= "\t\t\t\t\t</tr>\n";
		
		//build the data portion of the table
		$r = 0;
		foreach ( $this->data as $k => $rowdat ) {
			$s .= "\t\t\t\t<tr";
			
			//apply odd/even row style
			if ( $r % 2 == 0 ) {
				foreach ( $this->evenattrib as $key => $value ) {
					if ( $key == 'class' && isset( $rowdat['locked'] ) && $rowdat['locked'] == 1 ) {
						$value .= ' locked';
					}
					
					$s .= " $key=\"$value\"";
				}
			} else {
				foreach ( $this->oddattrib as $key => $value ) {
					if ( $key == 'class' && isset( $rowdat['locked'] ) && $rowdat['locked'] == 1 ) {
						$value .= ' locked';
					}
					
					$s .= " $key=\"$value\"";
				}
			}
			$s .= ">\n";
			
			//add missing columns
			while ( count( $rowdat ) < $colcnt ) {
				$rowdat[] = '';
			}
			
			//get rowid from first column
			reset( $rowdat );
			$rowid = current( $rowdat );
			
			$c	= 0;
			$d	= 0;
			
			foreach ( $rowdat as $kk => $coldat ) {
				$s0	= '';
				
				//exit if more columns than defined
				if ( $c >= $colcnt ) {
					break;
				}
				
				$HtmlId	= $this->HtmlId( $r, $c );
				$col	= &$this->columns[$c];
				$colid	= $col['colname'];
				
				$action1	= ( $this->option_db_allow_update ? " onDblClick=\"dg_checkChange($JsClass,'$rowid','$colid','$HtmlId')\"" : '' );
				$action2	= ( $this->option_db_allow_update ? " onDblClick=\"dg_editCell($JsClass,'$rowid','$colid','$HtmlId')\"" : '' );
				
				switch ( $col['coltype'] ) {
					case 'hidden':
						break;
					case 'checkbox':
						$s0 .= "\t\t\t\t\t<td class=\"$classes text\"><input class=\"$classes\" type=\"checkbox\" id=\"$HtmlId\"$action1" . ($coldat?'checked':'') . '>';
						break;
					case 'selectkey':
						$s0 .= "\t\t\t\t\t<td class=\"$classes number\" id=\"$HtmlId\"$action2><input type=\"hidden\" id=\"$HtmlId.h\" value=\"".htmlspecialchars($coldat, ENT_QUOTES)."\">";
						$txt=$col['selectvalues'][$coldat];
						if ( $txt ) {
							$s0 .= htmlspecialchars($txt, ENT_QUOTES);
						} else {
							$s0 .= 'KEY: ' . htmlspecialchars($coldat, ENT_QUOTES); //XXX
						}
						break;
					case 'readonly':
					case 'readonlynumber':
						$addclass = ( $col['coltype'] == 'readonlynumber' ? 'number' : 'text' );
						$s0 .= "\t\t\t\t\t<td class=\"$classes $addclass\" id=\"$HtmlId\">";
						if ( $coldat !== '' ) {
							$s0 .= htmlspecialchars($coldat, ENT_QUOTES);
						} else {
							$s0 .= '&nbsp;';
						}
						break;
					case 'link':
						$title = $col['coltitle'];
						$s0 .= "\t\t\t\t\t<td class=\"$classes number\" id=\"$HtmlId\" title=\"$title\">";
						if ($coldat !== '' && $col['colname'] != 'lnu' ){
							$s0 .= $coldat;
						} elseif ( $col['target'] != '' && ( ( $col['colname'] != 'lnu' && ( !isset( $rowdat['locked'] ) || $rowdat['locked'] != 1 ) ) || ( $col['colname'] == 'lnu' && isset( $rowdat['locked'] ) && $rowdat['locked'] == 1 ) ) ){
							$s_target = urldecode( $col['target'] );
							
							while ( true ) {
								$s_pos1		= strpos( $s_target, '{' );
								
								if ( $s_pos1 ) {
									$s_pos2		= strpos( $s_target, '}', $s_pos1 );
									
									if ( $s_pos1 ) {
										$s_var		= substr( $s_target, $s_pos1 + 1, $s_pos2 - $s_pos1 - 1 );
										$s_search	= substr( $s_target, $s_pos1,     $s_pos2 - $s_pos1 + 1 );
										
										$s_target	= str_replace( $s_search, $rowdat[$s_var], $s_target );
									} else {
										break;
									}
								} else {
									break;
								}
							}
							
							$s0 .= $s_target;
						} else {
						  $s0 .= '&nbsp;';
						}
						
						break;
					case 'picture':
						$title = $col['coltitle'];
						$s0 .= "\t\t\t\t\t<td class=\"$classes number\" id=\"$HtmlId\" title=\"$title\">";
						
						$coldat			= (int) $coldat;
						$coldat_orig	= $coldat;
						
						if ( $coldat != 1 ) {
							$coldat = 0;
						} else {
							$coldat = 1;
						}
						
						if( $col['invert'] == true )
							$coldat = 1 - $coldat;
							
						if ( $coldat == 1 ) {
							if ( $col['OKMessage'] != 'NULL' ) {
								$s0 .= "<img class=\"$classes-icon\" src=\"".(QSDB_functions::picture_path('graphics/ok.png', 'tm_classes'))."\" alt=\"$col[OKMessage] ($coldat_orig)\" title=\"$title $col[OKMessage]\" />";
							}
						} else {
							if ( $col['NOKMessage'] != 'NULL' ) {
								$s0 .= "<img class=\"$classes-icon\" src=\"".(QSDB_functions::picture_path('graphics/nok.png', 'tm_classes'))."\" alt=\"$col[NOKMessage] ($coldat_orig)\" title=\"$title $col[NOKMessage]\" />";
							}
						}
						break;
					case 'date':
						if ( (int) $coldat > 0 ) {
							$date = date( 'd.m.Y', (int) $coldat );
						} else {
							$date = $coldat;
						}
						
						$s0 .= "\t\t\t\t\t<td class=\"$classes number\" id=\"$HtmlId\"$action2>";
						if ( $coldat !== '' ) {
							$s0 .= $date;
						} else {
							$s0 .= '&nbsp;';
						}
						break;
					case 'cash':
						$cash = QSDB_functions::format_cash( $coldat );
						
						$s0 .= "\t\t\t\t\t<td class=\"$classes number\" id=\"$HtmlId\"$action2>";
						if ( $coldat !== '' ) {
							$s0 .= $cash;
						} else {
							$s0 .= '&nbsp;';
						}
						break;
					case 'text':
					case 'number':
						$addclass = ( $col['coltype'] == 'number' ? 'number' : 'text' );
						$s0 .= "\t\t\t\t\t<td class=\"$classes $addclass\" id=\"$HtmlId\"$action2>";
						if ( $coldat !== '' ) {
							$s0 .= QSDB_functions::ersetze($coldat, 'all');
						} else {
							$s0 .= '&nbsp;';
						}
						break;
					case 'other':
						$title			= $col['coltitle'];
						$table			= $col['table'];
						
						$obj			= $col['obj'];
						
						$field_name		= $col['colname'];
						$row			= $rowdat;
						$printout		= true;
						$style_td		= '';
						
						$dummy			= $obj->getFieldContent( $field_name, $table, $row, 1, false, $printout, false, $style_td );
						
						$s0 .= "\t\t\t\t\t<td class=\"$classes\" id=\"$HtmlId\" title=\"$title\"$action2>";
						if ( $dummy !== '' ) {
							$s0 .= $dummy;
						} else {
							$s0 .= '&nbsp;';
						}
						break;
					default:
						$s0 .= "\t\t\t\t\t<td class=\"$classes\" id=\"$HtmlId\"$action2>";
						if ( $coldat !== '' )
						  $s0 .= htmlspecialchars($coldat, ENT_QUOTES);
						else
						  $s0 .= '&nbsp;';
				}
				
				if ( $s0 != '' ) {
					$s .= $s0 . "</td>\n";
					$d++;
				}
				
				if ( $col['coltype'] != 'hidden' ) {
					//$d++;
				}
				
				$c++;
			}
			$s .= "\t\t\t\t</tr>\n";
			$r++;
		}
		
		//var_dump( $colcnt );
		//var_dump( $d );
		//var_dump( $c );
		
		//save column count
		$this->colcnt = $colcnt;//( $d ? $d : $colcnt );
		
		return $s;
	}
	
	// }}}
	// {{{ GenerateJS
	
	/**
	 * Function GenerateJS
	 * 
	 * generate the JavaScript for the table
	 *
	 * @param	integer		$this->img_width:	the Width of the Chart
	 * @param	integer		$this->img_height:the Height of the Chart
	 * @param	string		$titles:	the Title for the Chart
	 * 
	 * @access	public
	 */
	private function GenerateJS()
	{
		$JsClass	= $this->JsClass;
		
		$js			= '';
		
		//determine if we need the 'includes'
		global $DataGrid_JsIncluded;
		if ( !$DataGrid_JsIncluded ) {
			$js .= "<script type=\"text/javascript\" src=\"".$this->relpath."sack.js\"></script>\n";
			$js .= "<script type=\"text/javascript\" src=\"".$this->relpath."datagrid.js\"></script>\n";
			$DataGrid_JsIncluded	= 1;
		}
		
		$js .= "<script type=\"text/javascript\">\n";
		$js .= "\tvar $JsClass = new dataGrid('$JsClass','$this->RequestFile');\n";
		
		if ( is_array( $this->columns ) ) {
			foreach ( $this->columns as $k => $v ) {
				$js 	.= "\t$JsClass.m_columns['$v[colname]']={'coltype':'$v[coltype]','style':'$v[style]'};\n";
				$opt	= array();
				
				if ( is_array( $v['selectvalues'] ) ) {
					foreach ( $v['selectvalues'] as $kk => $vv ) {
						$opt[]	= "'" . htmlentities( $kk, ENT_QUOTES ) . "':'" . htmlentities( $vv, ENT_QUOTES ) . "'";
					}
				}
				
				if ($opt) {
					$js .= "$JsClass.m_columns['$v[colname]']['selectvalues']={" . join( $opt, ',' ) . "};\n";
				}
			}
		}
		$js .= "</script>\n";
		
		return $js;
	}
	
	// }}}
	// {{{ set_add_link
	
	/**
	 * Function set_add_link
	 * 
	 * sets a link to add new records
	 *
	 * @param	string		$link:		the Link to the Add Function
	 * 
	 * @access	public
	 */
	public function set_add_link($link)
	{
		$this->add_link = (string) $link;
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