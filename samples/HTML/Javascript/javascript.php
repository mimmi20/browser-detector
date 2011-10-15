<html>
<head>
<title>HTML_Javascript::Javascript Sample 1</title>
</head>
<body>
<h1>HTML_Javascript</h1>
<?php
/**
 * HTML_Javascript::Javascript Sample usage
 *
 * Show how to use the base of HTML_Javascript
 *
 * @author Pierre-Alain Joye <paj@pearfr.org>
 * @package HTML_Javascript
 * @filesource
 */

/** requires the main class */
require_once 'HTML/Javascript.php';

$htmljs = new HTML_Javascript();

// Starts the JS script
echo $htmljs->startScript();

echo $htmljs->writeLine('<h2>document.write</h2>');

// document.write methods

/*
 * Simple usage of write and writeLine
 * See the confirm, prompt examples to see these methods
 * usage with JS variables.
 */
echo $htmljs->writeLine('writeln: Test JS Line 1', false);
echo $htmljs->write('write: Test JS Line 2', false);
echo $htmljs->write('write: Test JS still Line 2', false);


echo $htmljs->writeLine('<h2>Interaction with the users, prompt, alert and confirm</h2>');

echo $htmljs->alert('I will ask you three questions and write back the answers.');

// alert, confirm and prompt methods
/*
 * Yes/No Dialog box, be carefull, the 1st arg is the target JS variable.
 * We will certainly use the same argument order in futurs major releases
 * of HTML_Javascript ($str, as a 1st argument).
 * The result (boolean) is stored in a JS variable given as a 2nd arg, here likehtmljs
 */
echo $htmljs->confirm('Do you like HTML_Javascript?','likehtmljs');
echo $htmljs->write('Do you like HTML_Javascript? Your answer:');
echo $htmljs->writeLine('likehtmljs',true);

/*
 * Ask a value, works exactly as confirm. The 1st argument is the string to write
 * in the dialog box, the 2nd is the name of the JS variable to store the return value
 */
echo $htmljs->prompt('What is your favourite langage?','favouritelangage');
echo $htmljs->write('What is your favourite langage? Your answer:');
echo $htmljs->writeLine('favouritelangage',true);

/**
 * So you like popups?
 */

echo $htmljs->popup('popup_page1','page1.html', 'HTML_Javascript_page1', 400,300, false);
$popupContent = '<html>
<head>
<title>HTML_Javascript popupWrite Usage</title>
</head>
<body>
<h1>HTML_Javascript::popupWrite</h1>
This is a popup with dynamic content<br>
</body>
</html>
';

echo $htmljs->popupWrite('popup_page2',$popupContent, 'HTML_Javascript_page2', 300,300, false);

$popupContent = '<html>
<head>
<title>HTML_Javascript popupWrite Usage</title>
</head>
<body>
<h1>HTML_Javascript::popupWrite</h1>
This is a popup with dynamic content.<br>
It uses the different options.
</body>
</html>
';
/**
 *  resizable, scrollbars, menubar, toolbar, status, location
 */
$attrs = array(false, false, true, false, true, true);

echo $htmljs->popupWrite('popup_page3',$popupContent, 'HTML_Javascript_page3', 300,300, false);

// Ends the script
echo $htmljs->endScript();
?>
</body>
</html>
