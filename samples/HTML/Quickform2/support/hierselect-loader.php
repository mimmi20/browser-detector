<?php
/**
 * Usage example for HTML_QuickForm2 package: AJAX-backed hierselect element, option loader
 *
 * $Id$
 */

/**
 * Class that returns additional options for hierselect elements
 *
 * The arrays are hardcoded there, in real life usage it will probably access
 * some database.
 */
class OptionLoader
{
    protected $primaryOptions = array();

    protected $secondaryOptions = array();

    public function __construct()
    {
        $this->primaryOptions = array(
            1 => 'Database',
            2 => 'HTML',
            3 => 'HTTP',
            4 => 'Images',
            5 => 'Mail'
        );

        $this->secondaryOptions[1] = array (
          1 => 'DB',
          2 => 'DBA',
          3 => 'DBA_Relational',
          4 => 'DB_DataObject',
          5 => 'DB_DataObject_FormBuilder',
          6 => 'DB_NestedSet',
          7 => 'DB_NestedSet2',
          8 => 'DB_Pager',
          9 => 'DB_QueryTool',
          10 => 'DB_Sqlite_Tools',
          11 => 'DB_Table',
          12 => 'DB_ado',
          13 => 'DB_ldap',
          14 => 'DB_ldap2',
          15 => 'DB_odbtp',
          16 => 'Gtk_MDB_Designer',
          17 => 'MDB',
          18 => 'MDB2',
          19 => 'MDB2_Driver_fbsql',
          20 => 'MDB2_Driver_ibase',
          21 => 'MDB2_Driver_mssql',
          22 => 'MDB2_Driver_mysql',
          23 => 'MDB2_Driver_mysqli',
          24 => 'MDB2_Driver_oci8',
          25 => 'MDB2_Driver_pgsql',
          26 => 'MDB2_Driver_querysim',
          27 => 'MDB2_Driver_sqlite',
          28 => 'MDB2_Schema',
          29 => 'MDB2_TableBrowser',
          30 => 'MDB_QueryTool',
          31 => 'SQL_Parser',
        );

        $this->secondaryOptions[2] = array (
          1 => 'HTML_AJAX',
          2 => 'HTML_BBCodeParser',
          3 => 'HTML_CSS',
          4 => 'HTML_Common',
          5 => 'HTML_Common2',
          6 => 'HTML_Crypt',
          7 => 'HTML_Entities',
          8 => 'HTML_Form',
          9 => 'HTML_Javascript',
          10 => 'HTML_Menu',
          11 => 'HTML_Page',
          12 => 'HTML_Page2',
          13 => 'HTML_Progress',
          14 => 'HTML_Progress2',
          15 => 'HTML_QuickForm',
          16 => 'HTML_QuickForm2',
          17 => 'HTML_QuickForm_CAPTCHA',
          18 => 'HTML_QuickForm_Controller',
          19 => 'HTML_QuickForm_DHTMLRulesTableless',
          20 => 'HTML_QuickForm_ElementGrid',
          21 => 'HTML_QuickForm_Livesearch',
          22 => 'HTML_QuickForm_Renderer_Tableless',
          23 => 'HTML_QuickForm_Rule_Spelling',
          24 => 'HTML_QuickForm_SelectFilter',
          25 => 'HTML_QuickForm_advmultiselect',
          26 => 'HTML_QuickForm_altselect',
          27 => 'HTML_Safe',
          28 => 'HTML_Select',
          29 => 'HTML_Select_Common',
          30 => 'HTML_Table',
          31 => 'HTML_Table_Matrix',
          32 => 'HTML_TagCloud',
          33 => 'HTML_Template_Flexy',
          34 => 'HTML_Template_IT',
          35 => 'HTML_Template_PHPLIB',
          36 => 'HTML_Template_Sigma',
          37 => 'HTML_Template_Xipe',
          38 => 'HTML_TreeMenu',
          39 => 'Pager',
          40 => 'Pager_Sliding',
        );

        $this->secondaryOptions[3] = array (
          1 => 'HTTP',
          2 => 'HTTP_Client',
          3 => 'HTTP_Download',
          4 => 'HTTP_FloodControl',
          5 => 'HTTP_Header',
          6 => 'HTTP_Request',
          7 => 'HTTP_Request2',
          8 => 'HTTP_Server',
          9 => 'HTTP_Session',
          10 => 'HTTP_Session2',
          11 => 'HTTP_SessionServer',
          12 => 'HTTP_Upload',
          13 => 'HTTP_WebDAV_Client',
          14 => 'HTTP_WebDAV_Server',
        );

        $this->secondaryOptions[4] = array (
          1 => 'Image_3D',
          2 => 'Image_Barcode',
          3 => 'Image_Canvas',
          4 => 'Image_Color',
          5 => 'Image_Color2',
          6 => 'Image_GIS',
          7 => 'Image_Graph',
          8 => 'Image_GraphViz',
          9 => 'Image_IPTC',
          10 => 'Image_JpegMarkerReader',
          11 => 'Image_JpegXmpReader',
          12 => 'Image_MonoBMP',
          13 => 'Image_Puzzle',
          14 => 'Image_Remote',
          15 => 'Image_Text',
          16 => 'Image_Tools',
          17 => 'Image_Transform',
          18 => 'Image_WBMP',
          19 => 'Image_XBM',
        );

        $this->secondaryOptions[5] = array (
          1 => 'Mail',
          2 => 'Mail_IMAP',
          3 => 'Mail_IMAPv2',
          4 => 'Mail_Mbox',
          5 => 'Mail_Mime',
          6 => 'Mail_Queue',
          7 => 'Mail_mimeDecode',
          8 => 'Net_NNTP',
        );
    }

   /**
    * Server-side callback
    *
    * @param array $values Values for previous select elements in hierselect
    * @return array Associative array (option value => option text)
    */
    public function getOptions(array $values = array())
    {
        if (empty($values)) {
            return $this->primaryOptions;
        } elseif (1 == count($values) && !empty($this->secondaryOptions[$values[0]])) {
            return $this->secondaryOptions[$values[0]];
        } else {
            return array('' => ' ');
        }
    }

   /**
    * Client-side callback
    *
    * @param array $values Values for previous select elements in hierselect
    * @return array Returns array that serializes to JS object {values: [...], texts: [...]}
    */
    public function getOptionsAjax(array $values = array())
    {
        // This helps to notice the difference between sync and async calls
        sleep(1);
        $options = $this->getOptions($values);
        return array('values' => array_keys($options),
                     'texts'  => array_values($options));
    }
}
?>