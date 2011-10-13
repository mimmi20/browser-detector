<?php
/**
 * Check data source validity with W3C CSS validator service
 *
 * PHP version 5
 *
 * @category   HTML
 * @package    HTML_CSS
 * @subpackage Examples
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2007-2008 Laurent Laville
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/HTML_CSS
 * @since      File available since Release 1.5.0
 * @ignore
 */

require_once 'HTML/CSS3.php';

/**
 * Replace default internal error handler.
 *
 * Always print rather than dies if the error is an exception.
 *
 * @param int    $code  a numeric error code.
 *                      Valid are HTML_CSS_ERROR_* constants
 * @param string $level error level ('exception', 'error', 'warning', ...)
 *
 * @return  integer
 * @ignore
 */
function myErrorHandler($code, $level)
{
    return PEAR_ERROR_PRINT;  // always print all error messages
}


$print_dot_css = '
*{
margin: 4px; padding: 0px;
}

body{
font-family: Tahoma, Verdana, Helvetica, Arial, sans-serif;
text-align:centre;
background-color:#fff;
}
';

$styles = array(
    //geld.de

    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\advantageMap.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\enlarge.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\enlarge.nonav.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\enlarge.smallnav.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\kredite.antrag.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\mrmoney.antrag.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\mrmoney.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\print.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\standard.admedia.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\standard.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\standard.forms.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\standard.iehacks.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\standard.modules.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\standard.navigation.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Geld.de_SVN\css\superextend.css',
/**/
    //preisvergleich.de

    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\fixed.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\kredite_antrag.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\mrmoney.antrag.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\mrmoney.antrag.OLD.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\mrmoney.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\print.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\pvg.head.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\ssd.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\standard.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\standard_forms.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\standard_google.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\standard_modules.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\standard_navigation.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\standard_zusatz.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Preisvergleich.de_SVN\css\superextend.css',
/**/
    //versicherungen.de

    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\resources\css_Admedia.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\resources\css_Credits.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\resources\css_Extensions.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\resources\css_Makler.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\resources\css_Master.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\resources\css_MrMoney.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\resources\css_Navigation.css',
    
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\uploads\tf\css_Admedia.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\uploads\tf\css_Credits.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\uploads\tf\css_Extensions.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\uploads\tf\css_Makler.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\uploads\tf\css_Master.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\uploads\tf\css_MrMoney.css',
    'C:\Dokumente und Einstellungen\Holger.Mueller\workspace\Versicherungen.de_SVN\uploads\tf\css_Navigation.css'
/**/
);

$prefs   = array(
    'push_callback' => 'myErrorHandler',
);
$attribs = null;

ini_set('error_reporting', E_ALL /*| E_STRICT /**/);
ini_set('display_errors', 1);
/*
$css = new HTML_CSS3($attribs, $prefs);

ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 1);

$messages = array();
$valid    = $css->validate($styles, $messages);

ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 1);

if ($valid === false) {
    var_export($messages);
}
print "\n" . 'Still alive !';
*/
require_once 'HTML/Common3/Root/Html.php';
$page = new HTML_Common3_Root_Html();
$div  = $page->body->addElement('div');
$if   = $div->setValue('<!--[if IE 6]><span>Test</span><![endif]-->');
//var_dump($if);
$span = $if->addElement('span');
//var_dump($span);
echo $page->toHtml(0,false,true);
?>