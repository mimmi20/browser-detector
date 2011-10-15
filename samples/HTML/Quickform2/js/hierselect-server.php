<?php
/**
 * Usage example for HTML_QuickForm2 package: AJAX-backed hierselect element, AJAX server
 *
 * $Id: hierselect-server.php 303930 2010-10-02 06:35:36Z avb $
 */

require_once 'HTML/AJAX/Server.php';
require_once '../support/hierselect-loader.php';

$server = new HTML_AJAX_Server();
$server->registerClass(new OptionLoader(), 'OptionLoader', array('getOptionsAjax'));
$server->handleRequest();
?>