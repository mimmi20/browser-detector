<?php
/**
 * Usage example for HTML_QuickForm2 package: default renderer
 *
 * The example demonstrates how the default renderer can be used and abused.
 * It also provides a default stylesheet.
 *
 * $Id: default-renderer.php 288534 2009-09-21 15:21:42Z avb $
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <style type="text/css">
      body { margin: 0; padding: 0; font: 80%/1.5 Arial,Helvetica,sans-serif; color: #111; background-color: #FFF; }
      .quickform { margin: 5px; padding: 5px; background-color: #FFF; }
      .quickform form fieldset { margin: 10px 0; padding: 10px; border: #DDD 1px solid; }
      .quickform form legend { font-weight: bold; color: #666; }
      .quickform form div.element { padding: 0.25em 0; }
      .quickform form label,
      .quickform span.qf-label { margin-right: 10px; padding-right: 10px; width: 150px; display: block; float: left; text-align: right; position: relative; }
      .quickform form .required:after { position: absolute; right: 0; font-size: 120%; font-style: normal; color: #C00; content: "*"; }
      .quickform form .qf-label-1 { margin-left:160px; padding-left:10px; color:#888; font-size: 85%; }
      .quickform div.reqnote { font-size: 92%; color: #555; }
      .quickform div.reqnote em { font-style: normal; color: #C00; }
      .quickform div.reqnote strong { color:#000; font-weight: bold; }
      .quickform div.errors { background-color: #FEE; border: 1px solid #ECC; padding:5px; margin:0 0 20px 0 }
      .quickform div.errors p,
      .quickform div.errors ul { margin:0; }
      .quickform div.error input { border-color: #C00; background-color: #FEF; }
      .quickform div.qf-checkable label, 
      .quickform div.qf-checkable input { display: inline; float: none; }
      .quickform div.qf-checkable div,
      .quickform div.qf-message { margin-left: 170px; }
      .quickform div.qf-message { font-size: 88%; color: #C00; }
    </style>
    <title>HTML_QuickForm2 default renderer example</title>
  </head>
  <body>
<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Renderer.php';

$form = new HTML_QuickForm2('example');
$fs = $form->addFieldset()->setLabel('Your information');

$username = $fs->addText('username')->setLabel('Username');
$username->addRule('required', 'Username is required');

$password = $fs->addPassword('pass')
            ->setLabel(array('Password', 'Password should be 8 characters at minimum'));
$password->addRule('required', 'Password is required');

$form->addHidden('my_hidden1')->setValue('1');
$form->addHidden('my_hidden2')->setValue('2');
$form->addSubmit('submit', array('value' => 'Send', 'id' => 'submit'));

if ($form->validate()) {
    $form->toggleFrozen(true);
}


$renderer = HTML_QuickForm2_Renderer::factory('default')
    ->setOption(array(
        'group_hiddens' => true,
        'group_errors'  => true,
        'required_note' => '<strong>Note:</strong> Required fields are marked with an asterisk (<em>*</em>).'
    ))
    ->setTemplateForId('submit', '<div class="element">{element} or <a href="/">Cancel</a></div>')
    ->setTemplateForClass(
        'HTML_QuickForm2_Element_Input',
        '<div class="element<qf:error> error</qf:error>"><qf:error>{error}</qf:error>' .
        '<label for="{id}" class="qf-label<qf:required> required</qf:required>">{label}</label>' .
        '{element}' .
        '<qf:label_2><div class="qf-label-1">{label_2}</div></qf:label_2></div>' 
    );

echo $form->render($renderer);
?>
</body>
</html>