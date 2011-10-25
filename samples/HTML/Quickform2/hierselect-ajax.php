<?php
/**
 * Usage example for HTML_QuickForm2 package: AJAX-backed hierselect element.
 *
 * NB: This usage example requires HTML_AJAX package to work.
 *
 * $Id$
 */

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Renderer.php';
require_once 'HTML/AJAX/Helper.php';
require_once './support/hierselect-loader.php';

$form = new HTML_QuickForm2('ajaxHierselect');
$form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
    'syncHS'  => array(2, 16),
    'asyncHS' => array(2, 16)
)));

$loader = new OptionLoader();

$fsSync = $form->addElement('fieldset')->setLabel('Sync call');

$fsSync->addElement('hierselect', 'syncHS', array('style' => 'width: 250px;'))
       ->setLabel('Choose package:')
       ->loadOptions(array($loader->getOptions(), array()),
                     array($loader, 'getOptions'), 'loadOptionsSync')
       ->setSeparator('<br />');

$fsAsync = $form->addElement('fieldset')->setLabel('Async call');
$fsAsync->addElement('hierselect', 'asyncHS', array('style' => 'width: 250px;'))
        ->setLabel('Choose package again:')
        ->loadOptions(array($loader->getOptions(), array()),
                      array($loader, 'getOptions'), 'loadOptionsAsync')
        ->setSeparator('<br />');

$form->addElement('submit', 'testSubmit', array('value' => 'Send'));

$renderer = HTML_QuickForm2_Renderer::factory('default');
$form->render($renderer);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>HTML_QuickForm2: AJAX-backed hierselect element</title>
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
<?php
// output script tags for AJAX server
$ajaxHelper = new HTML_AJAX_Helper();
$ajaxHelper->serverUrl = 'js/hierselect-server.php';
$ajaxHelper->stubs[]   = 'OptionLoader';
echo $ajaxHelper->setupAJAX();
?>
    <script type="text/javascript">
// <![CDATA[

function loadOptionsSync(keys)
{
    return (new OptionLoader).getOptionsAjax(keys);
}

function loadOptionsAsync(keys, selectId)
{
    // trying to load options for an empty value (or waiting for an async
    // call result)
    if ('' == keys[keys.length - 1]) {
        return qf.elements.hierselect.missingOptions;
    }

    var callback = {
        getOptionsAjax: qf.elements.hierselect.getAsyncCallback(selectId, keys)
    };

    // Asynchronous call
    (new OptionLoader(callback)).getOptionsAjax(keys);

    // actual options will be added later, for now just return empty options
    // (this will also prevent useless AJAX requests)
    return qf.elements.hierselect.missingOptions;
}

// ]]>
    </script>
<?php
// Inline QuickForm's javascript libraries
echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
?>
  </head>
  <body>
<?php

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    echo "<pre>\n";
    var_dump($form->getValue());
    echo "</pre>\n<hr />";
}

echo $renderer;

?>
  </body>
</html>