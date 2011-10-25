<?php
/**
 * Usage example for HTML_QuickForm2_Controller: simple
 *
 * @version SVN: $Id$
 * @author  Alexey Borzov <avb@php.net>
 * @author  Bertrand Mansion <php@mamasam.com>
 * @ignore
 */

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Controller.php';

// Load some default action handlers
require_once 'HTML/QuickForm2/Controller/Action/Submit.php';
require_once 'HTML/QuickForm2/Controller/Action/Display.php';

// Start the session, form-page values will be kept there
session_start();

class SimplePage extends HTML_QuickForm2_Controller_Page
{
    protected function populateForm()
    {
        $form = $this->form;
        $fs = $form->addFieldset()->setLabel("Controller example 1: a simple form");

        $fs->addText("tstText", array('size'=>20, 'maxlength'=>50))
           ->setLabel("Please enter something:")
           ->addRule("required", "Pretty please!");

        $fs->addSubmit($this->getButtonName('submit'), array('value' => 'Send'));
        $this->setDefaultAction('submit', 'empty.gif')
             ->setAttribute('style', 'display:none');
    }
}

class ActionProcess implements HTML_QuickForm2_Controller_Action
{
    public function perform(HTML_QuickForm2_Controller_Page $page, $name)
    {
        echo "Submit successful!<br>\n<pre>\n";
        var_dump($page->getController()->getValue());
        echo "\n</pre>\n";
    }
}

class ActionDisplay extends HTML_QuickForm2_Controller_Action_Display
{
    protected function renderForm(HTML_QuickForm2 $form)
    {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <style type="text/css">
/* Set up custom font and form width */
body {
    margin-left: 10px;
    font-family: Arial,sans-serif;
    font-size: small;
}

.quickform {
    min-width: 500px;
    max-width: 600px;
    width: 560px;
}

/* Use default styles included with the package */

<?php
    if ('@data_dir@' != '@' . 'data_dir@') {
        $filename = '@data_dir@/HTML_QuickForm2/quickform.css';
    } else {
        $filename = dirname(dirname(dirname(__FILE__))) . '/data/quickform.css';
    }
    readfile($filename);
?>
    </style>
    <title>HTML_QuickForm2 simple controller example</title>
  </head>
  <body>
<?php
        echo $form;
?>
  </body>
</html>
<?php
    }
}

$page = new SimplePage(new HTML_QuickForm2('page1'));
$page->addHandler('process', new ActionProcess());
$page->addHandler('display', new ActionDisplay());

$controller = new HTML_QuickForm2_Controller('Simple');
$controller->addPage($page);
$controller->run();

?>