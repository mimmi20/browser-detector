<?php
/**
 * Usage example for HTML_QuickForm2_Controller: wizard
 *
 * @version SVN: $Id: wizard.php 295963 2010-03-08 14:33:43Z avb $
 * @author  Alexey Borzov <avb@php.net>
 * @ignore
 */

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Controller.php';
require_once 'HTML/QuickForm2/Renderer.php';

// Load some default action handlers
require_once 'HTML/QuickForm2/Controller/Action/Next.php';
require_once 'HTML/QuickForm2/Controller/Action/Back.php';
require_once 'HTML/QuickForm2/Controller/Action/Jump.php';
require_once 'HTML/QuickForm2/Controller/Action/Display.php';

// Start the session, form-page values will be kept there
session_start();

class PageFirst extends HTML_QuickForm2_Controller_Page
{
    protected function populateForm()
    {
        $fs = $this->form->addElement('fieldset')->setLabel('Wizard page 1 of 3');

        $radioGroup = $fs->addElement('group')->setLabel('Are you absolutely sure?');
        $radioGroup->addElement('radio', 'iradYesNo', array('value' => 'Y'), array('content' => 'Yes'));
        $radioGroup->addElement('radio', 'iradYesNo', array('value' => 'N'), array('content' => 'No'));

        $fs->addElement('submit', $this->getButtonName('next'), array('value' => 'Next >>'));

        $radioGroup->addRule('required', 'Check Yes or No');

        $this->setDefaultAction('next', 'empty.gif');
    }
}

class PageSecond extends HTML_QuickForm2_Controller_Page
{
    protected function populateForm()
    {
        $fs = $this->form->addElement('fieldset')->setLabel('Wizard page 2 of 3');

        $nameGroup = $fs->addElement('group', 'name', array('id' => 'nameGrp'))
                        ->setLabel('Name:')
                        ->setSeparator(',&nbsp;');
        $nameGroup->addElement('text', 'last', array('size' => 20))
                  ->setLabel('Last')
                  ->addRule('required', 'Last name is required');
        $nameGroup->addElement('text', 'first', array('size' => 20))
                  ->setLabel('first');

        $buttonGroup = $fs->addElement('group');
        $buttonGroup->addElement('submit', $this->getButtonName('back'), array('value' => '<< Back'));
        $buttonGroup->addElement('submit', $this->getButtonName('next'), array('value' => 'Next >>'));

        $this->setDefaultAction('next', 'empty.gif');
    }
}

class PageThird extends HTML_QuickForm2_Controller_Page
{
    protected function populateForm()
    {
        $fs = $this->form->addElement('fieldset')->setLabel('Wizard page 3 of 3');

        $fs->addElement('textarea', 'itxaTest', array('rows' => 5, 'cols' => 40))
           ->setLabel('Parting words:')
           ->addRule('required', 'Say something!');

        $buttonGroup = $fs->addElement('group');
        $buttonGroup->addElement('submit', $this->getButtonName('back'), array('value' => '<< Back'));
        $buttonGroup->addElement('submit', $this->getButtonName('next'), array('value' => 'Finish'));

        $this->setDefaultAction('next', 'empty.gif');
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
    <title>HTML_QuickForm2 basic elements example</title>
  </head>
  <body>
<?php
    $renderer = HTML_QuickForm2_Renderer::factory('default');
    $renderer->setElementTemplateForGroupId(
        'nameGrp', 'html_quickform2_element',
        '<div class="element<qf:error> error</qf:error>"><qf:error><span class="error">{error}</span><br /></qf:error>{element}<br /><label for="{id}"><qf:required><span class="required">* </span></qf:required>{label}</label></div>'
    );
    $renderer->setTemplateForId(
        'nameGrp', '<div class="row"><label class="element"><qf:required><span class="required">* </span></qf:required>{label}</label>{content}</div>'
    );
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

$wizard = new HTML_QuickForm2_Controller('Wizard');
$wizard->addPage(new PageFirst(new HTML_QuickForm2('page1')));
$wizard->addPage(new PageSecond(new HTML_QuickForm2('page2')));
$wizard->addPage(new PageThird(new HTML_QuickForm2('page3')));

// We actually add these handlers here for the sake of example
// They can be automatically loaded and added by the controller
$wizard->addHandler('next', new HTML_QuickForm2_Controller_Action_Next());
$wizard->addHandler('back', new HTML_QuickForm2_Controller_Action_Back());
$wizard->addHandler('jump', new HTML_QuickForm2_Controller_Action_Jump());

// This is the action we should always define ourselves
$wizard->addHandler('process', new ActionProcess());
// We redefine 'display' handler to use the proper stylesheets
$wizard->addHandler('display', new ActionDisplay());

$wizard->run();
?>