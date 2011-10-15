<?php
/**
 * Usage example for HTML_QuickForm2_Controller: tabbed form
 *
 * @version SVN$
 * @author  Alexey Borzov <avb@php.net>
 * @author  Bertrand Mansion <php@mamasam.com>
 * @ignore
 */

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Controller.php';
require_once 'HTML/QuickForm2/Renderer.php';

// Load some default action handlers
require_once 'HTML/QuickForm2/Controller/Action/Submit.php';
require_once 'HTML/QuickForm2/Controller/Action/Jump.php';
require_once 'HTML/QuickForm2/Controller/Action/Direct.php';
require_once 'HTML/QuickForm2/Controller/Action/Display.php';

// Start the session, form-page values will be kept there
session_start();

abstract class TabbedPage extends HTML_QuickForm2_Controller_Page
{
    protected function addTabs()
    {
        $tabGroup = $this->form->addElement('group')->setSeparator('&nbsp;')
                               ->setId('tabs');
        foreach ($this->getController() as $pageId => $page) {
            $tabGroup->addElement('submit', $this->getButtonName($pageId),
                                  array('class' => 'flat', 'value' => ucfirst($pageId)) +
                                  ($page === $this? array('disabled' => 'disabled'): array()));
        }
    }

    protected function addGlobalSubmit()
    {
        $this->form->addElement('submit', $this->getButtonName('submit'),
                                array('value' => 'Big Red Button', 'class' => 'bigred'));
        $this->setDefaultAction('submit', 'empty.gif');
    }
}

class PageFoo extends TabbedPage
{
    protected function populateForm()
    {
        $this->addTabs();

        $fs = $this->form->addElement('fieldset')->setLabel('Foo page');

        $radioGroup = $fs->addElement('group')->setLabel('Do you want this feature?')
                         ->setSeparator('<br />');
        $radioGroup->addElement('radio', 'iradYesNoMaybe', array('value' => 'Y'), array('content' => 'Yes'));
        $radioGroup->addElement('radio', 'iradYesNoMaybe', array('value' => 'N'), array('content' => 'No'));
        $radioGroup->addElement('radio', 'iradYesNoMaybe', array('value' => 'M'), array('content' => 'Maybe'));

        $fs->addElement('text', 'tstText', array('size'=>20, 'maxlength'=>50))
           ->setLabel('Why do you want it?');

        $radioGroup->addRule('required', 'Check a radiobutton');

        $this->addGlobalSubmit();
    }
}

class PageBar extends TabbedPage
{
    protected function populateForm()
    {
        $this->addTabs();

        $fs = $this->form->addElement('fieldset')->setLabel('Bar page');

        // XXX: no date element yet
        $dateGroup = $fs->addElement('group', 'favDate')->setLabel('Favourite date:')
                        ->setSeparator('-');
        for ($i = 1, $doptions = array(); $i <= 31; $i++) {
            $doptions[$i] = sprintf('%02d', $i);
        }
        $dateGroup->addElement('select', 'd')->loadOptions($doptions);
        $dateGroup->addElement('select', 'M')->loadOptions(array(
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 5 => 'June',
            7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ));
        for ($i = 1950, $yoptions = array(); $i <= date('Y'); $i++) {
            $yoptions[$i] = $i;
        }
        $dateGroup->addElement('select', 'Y')->loadOptions($yoptions);


        $checkGroup = $fs->addElement('group', 'favLetter')->setLabel('Favourite letters:')
                         ->setSeparator(array('&nbsp;', '<br />'));
        foreach (array('A', 'B', 'C', 'D', 'X', 'Y', 'Z') as $letter) {
            $checkGroup->addElement('checkbox', $letter)->setContent($letter);
        }

        $this->addGlobalSubmit();
    }
}

class PageBaz extends TabbedPage
{
    protected function populateForm()
    {
        $this->addTabs();

        $fs = $this->form->addElement('fieldset')->setLabel('Baz page');

        $poem = $fs->addElement('textarea', 'textPoetry', array('rows' => 5, 'cols' => 40))
                   ->setLabel('Recite a poem:');
        $fs->addElement('textarea', 'textOpinion', array('rows' => 5, 'cols' => 40))
           ->setLabel('Did you like this demo?');

        $poem->addRule('required', 'Pretty please!');

        $this->addGlobalSubmit();
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

.quickform input.bigred {font-weight: bold; background: #FF6666;}
.quickform input.flat {border-style: solid; border-width: 2px; border-color: #000000;}

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
    $renderer = HTML_QuickForm2_Renderer::factory('default');
    $renderer->setTemplateForId('tabs', '<div style="float: right;">{content}</div>');
    echo $form->render($renderer);
?>
  </body>
</html>
<?php
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


$tabbed = new HTML_QuickForm2_Controller('Tabbed', false);

$tabbed->addPage(new PageFoo(new HTML_QuickForm2('foo')));
$tabbed->addPage(new PageBar(new HTML_QuickForm2('bar')));
$tabbed->addPage(new PageBaz(new HTML_QuickForm2('baz')));

// These actions manage going directly to the pages with the same name
$tabbed->addHandler('foo', new HTML_QuickForm2_Controller_Action_Direct());
$tabbed->addHandler('bar', new HTML_QuickForm2_Controller_Action_Direct());
$tabbed->addHandler('baz', new HTML_QuickForm2_Controller_Action_Direct());

// We actually add these handlers here for the sake of example
// They can be automatically loaded and added by the controller
$tabbed->addHandler('submit', new HTML_QuickForm2_Controller_Action_Submit());
$tabbed->addHandler('jump', new HTML_QuickForm2_Controller_Action_Jump());

// This is the action we should always define ourselves
$tabbed->addHandler('process', new ActionProcess());
// We redefine 'display' handler to use the proper stylesheets
$tabbed->addHandler('display', new ActionDisplay());

$tabbed->addDatasource(new HTML_QuickForm2_DataSource_Array(array(
    'iradYesNoMaybe' => 'M',
    'favLetter'      => array('A' => true, 'Z' => true),
    'favDate'        => array('d' => 1, 'M' => 1, 'Y' => 2001),
    'textOpinion'    => 'Yes, it rocks!'
)));

$tabbed->run();
?>