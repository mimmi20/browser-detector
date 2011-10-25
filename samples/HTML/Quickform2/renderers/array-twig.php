<?php
/**
 * Usage example for HTML_QuickForm2 package: Array renderer with Twig template engine
 *
 * For this example to run, you need to install Twig template engine
 * from its separate PEAR channel:
 * <code>
 * $ pear channel-discover pear.twig-project.org
 * $ pear install twig/Twig
 * </code>
 *
 * $Id$
 */

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Renderer.php';
require_once 'Twig/Autoloader.php';

Twig_Autoloader::register();

$options = array(
    'a' => 'Letter A', 'b' => 'Letter B', 'c' => 'Letter C',
    'd' => 'Letter D', 'e' => 'Letter E', 'f' => 'Letter F'
);

$main = array("Pop", "Rock", "Classical");

$secondary = array(
    array(0 => "Belle & Sebastian", 1 => "Elliot Smith", 2 => "Beck"),
    array(3 => "Noir Desir", 4 => "Violent Femmes"),
    array(5 => "Wagner", 6 => "Mozart", 7 => "Beethoven")
);

$form = new HTML_QuickForm2('elements');

// data source with default values:
$form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
    'textTest'        => 'Some text',
    'areaTest'        => "Some text\non multiple lines",
    'userTest'        => 'luser',
    'selSingleTest'   => 'f',
    'selMultipleTest' => array('b', 'c'),
    'boxTest'         => '1',
    'radioTest'       => '2',
    'testDate'        => time(),
    'testHierselect'  => array(2, 5)
)));

// text input elements
$fsText = $form->addElement('fieldset')->setLabel('Text boxes');
$fsText->addElement(
    'text', 'textTest', array('style' => 'width: 300px;'), array('label' => 'Test Text:')
)->addRule('required', 'This field is required');
$fsText->addElement(
    'password', 'pwdTest', array('style' => 'width: 300px;'), array('label' => 'Test Password:')
);
$area = $fsText->addElement(
    'textarea', 'areaTest', array('style' => 'width: 300px;', 'cols' => 50, 'rows' => 7),
    array('label' => 'Test Textarea:')
);
$area->addRule('required', 'This field is required');

$fsNested = $form->addElement('fieldset')->setLabel('Nested fieldset');
$fsNested->addElement(
    'text', 'userTest', array('style' => 'width: 200px'), array('label' => 'Username:')
);
$fsNested->addElement(
    'password', 'passTest', array('style' => 'width: 200px'), array('label' => 'Password:')
);
// Now we move the fieldset into another fieldset!
$fsText->insertBefore($fsNested, $area);


// selects
$fsSelect = $form->addElement('fieldset')->setLabel('Selects');
$fsSelect->addElement(
    'select', 'selSingleTest', null, array('options' => $options, 'label' => 'Single select:')
);
$fsSelect->addElement(
    'select', 'selMultipleTest', array('multiple' => 'multiple', 'size' => 4),
    array('options' => $options, 'label' => 'Multiple select:')
);

// checkboxes and radios
$fsCheck = $form->addElement('fieldset')->setLabel('Checkboxes and radios');
$fsCheck->addElement(
    'checkbox', 'boxTest', null, array('content' => 'check me', 'label' => 'Test Checkbox:')
);
$fsCheck->addElement(
    'radio', 'radioTest', array('value' => 1), array('content' => 'select radio #1', 'label' => 'Test radio:')
);
$fsCheck->addElement(
    'radio', 'radioTest', array('value' => 2), array('content' => 'select radio #2', 'label' => '(continued)')
);

$fsCustom = $form->addElement('fieldset')->setLabel('Custom elements');
$fsCustom->addElement(
    'date', 'testDate', null,
    array('format' => 'd-F-Y', 'minYear' => date('Y'), 'maxYear' => 2001)
)->setLabel('Today is:');

$fsCustom->addElement('hierselect', 'testHierselect', array('style' => 'width: 20em;'))
         ->setLabel('Hierarchical select:')
         ->loadOptions(array($main, $secondary))
         ->setSeparator('<br />');

// buttons
$fsButton = $form->addElement('fieldset')->setLabel('Buttons');
$testReset = $fsButton->addElement(
    'reset', 'testReset', array('value' => 'This is a reset button')
);
$fsButton->addElement(
    'inputbutton', 'testInputButton',
    array('value' => 'Click this button', 'onclick' => "alert('This is a test.');")
);
$fsButton->addElement(
    'button', 'testButton', array('onclick' => "alert('Almost nothing');", 'type' => 'button'),
    array('content' => '<img src="http://pear.php.net/gifs/pear-icon.gif" '.
          'width="32" height="32" alt="pear" />This button does almost nothing')
);
// submit buttons in nested fieldset
$fsSubmit = $fsButton->addElement('fieldset')->setLabel('These buttons can submit the form');
$fsSubmit->addElement(
    'submit', 'testSubmit', array('value' => 'Test Submit')
);
$fsSubmit->addElement(
    'button', 'testSubmitButton', array('type' => 'submit'),
    array('content' => '<img src="http://pear.php.net/gifs/pear-icon.gif" '.
          'width="32" height="32" alt="pear" />This button submits')
);
$fsSubmit->addElement(
    'image', 'testImage', array('src' => 'http://pear.php.net/gifs/pear-icon.gif')
);

$context = array();
// outputting form values
if ($form->validate()) {
    $context['submitvalues'] = print_r($form->getValue(), true);
    // let's freeze the form and remove the reset button
    $fsButton->removeChild($testReset);
    $form->toggleFrozen(true);
}

if ('@data_dir@' != '@' . 'data_dir@') {
    $filename = '@data_dir@/HTML_QuickForm2/quickform.css';
} else {
    $filename = dirname(dirname(dirname(dirname(__FILE__)))) . '/data/quickform.css';
}
$context['default_styles'] = file_get_contents($filename);

$renderer = HTML_QuickForm2_Renderer::factory('array');
$form->render($renderer);

$loader   = new Twig_Loader_Filesystem(dirname(__FILE__) . '/templates');
// in real life usage you should set up the cache directory!
$twig     = new Twig_Environment($loader);
$template = $twig->loadTemplate('array-twig.tpl');

$template->display($context + array(
    'js_libraries' => $renderer->getJavascriptBuilder()->getLibraries(true, true),
    'form'         => $renderer->toArray()
));
?>
