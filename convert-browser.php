<?php
/**
 * Created by PhpStorm.
 * User: Thomas Müller
 * Date: 03.03.2016
 * Time: 07:22
 */

chdir(__DIR__);

require 'vendor/autoload.php';

ini_set('memory_limit', '-1');

$sourceDirectory = 'src\\Detector\\Browser\\';

$iterator = new \RecursiveDirectoryIterator($sourceDirectory);

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $filename = $file->getFilename();

    $skip = [
        'A6Indexer.php',
        'AbstractBrowser.php',
        'AbontiBot.php',
        'Aboundexbot.php',
        'AboutUsBot.php',
        'AboutUsBotJohnny5.php',
        'Abrowse.php',
        'Acapbot.php',
        'AccServer.php',
        'AcoonBot.php',
        'AdbeatBot.php',
        'AddCatalog.php',
        'AddThisRobot.php',
        'Adidxbot.php',
        'AdmantxPlatformSemanticAnalyzer.php',
        'AdMuncher.php',
        'AdobeAIR.php',
        'AdvancedEmailExtractor.php',
        'AdvBot.php',
        'AhrefsBot.php',
        'AiHitBot.php',
        'Airmail.php',
        'AjaxSnapBot.php',
        'Akregator.php',
        'Alcatel.php',
        'AlcoholSearch.php',
        'Alexabot.php',
        'AlexaSiteAudit.php',
        'AlltopApp.php',
    ];
    
    if (in_array($filename, $skip)) {
        continue;
    }

    $fullpath    = $file->getPathname();
    $pathMatches = [];

    $template = 'data/templates/general-browser.php.tmp';

    $filecontent     = file_get_contents($fullpath);
    $templateContent = file_get_contents($template);
    $matches         = [];

    if (!preg_match('/class (.*) extends AbstractBrowser/', $filecontent, $matches)
        && !preg_match('/class (.*)\\n    extends AbstractBrowser/', $filecontent, $matches)
    ) {
        echo 'class name not found in file ', $fullpath, PHP_EOL;
        exit;
    }

    echo 'processing ', $fullpath, PHP_EOL;

    $templateContent = str_replace(
        ['###ClassName###'],
        [$matches[1]],
        $templateContent
    );

    if (preg_match('/\\\'pdfSupport\\\'\s+ => (true|false)/', $filecontent, $matches)) {
        $pdf = $matches[1];
    } else {
        $pdf = 'false';
    }

    if (preg_match('/\\\'rssSupport\\\'\s+ => (true|false)/', $filecontent, $matches)) {
        $rss = $matches[1];
    } else {
        $rss = 'null';
    }

    if (preg_match('/\\\'canSkipAlignedLinkRow\\\'\s+ => (true|false)/', $filecontent, $matches)) {
        $skipalign = $matches[1];
    } else {
        $skipalign = 'null';
    }

    if (preg_match('/\\\'claimsWebSupport\\\'\s+ => (true|false)/', $filecontent, $matches)) {
        $websupport = $matches[1];
    } else {
        $websupport = 'null';
    }

    if (preg_match('/\\\'supportsEmptyOptionValues\\\'\s+ => (true|false)/', $filecontent, $matches)) {
        $emptyoptions = $matches[1];
    } else {
        $emptyoptions = 'null';
    }

    if (preg_match('/\\\'supportsBasicAuthentication\\\'\s+=> (true|false)/', $filecontent, $matches)) {
        $basic = $matches[1];
    } else {
        $basic = 'null';
    }

    if (preg_match('/\\\'supportsPostMethod\\\'\s+ => (true|false)/', $filecontent, $matches)) {
        $post = $matches[1];
    } else {
        $post = 'null';
    }

    if (preg_match('/\\\'type\\\'\s+ => new UaBrowserType\\\\([^\\(]+)/', $filecontent, $matches)) {
        $type = $matches[1];
    } else {
        $type = 'Unknown';
    }

    if (preg_match('/\\\'name\\\'\s+ => \\\'([^\\\\\']+)\\\'/', $filecontent, $matches)) {
        $name = $matches[1];
    } else {
        $name = 'unknown';
    }

    if (preg_match('/\\\'manufacturer\\\'\s+ => \\(new Company\\\\([^\\(]+)/', $filecontent, $matches)) {
        $manufacturer = $matches[1];
    } else {
        $manufacturer = 'Unknown';
    }

    if (preg_match('/getEngine\\(\\)\\n    {\\n        return new Engine\\\\([^\\(]+)/', $filecontent, $matches)) {
        $engine = $matches[1];
    } else {
        $engine = 'UnknownEngine';
    }

    if (preg_match('/public function detectVersion/', $filecontent)) {
        $pos1 = strpos($filecontent, 'public function detectVersion');
        $pos2 = strpos($filecontent, '{', $pos1);
        $pos3 = strpos($filecontent, "\n    }", $pos2);
        $check = trim(substr($filecontent, $pos2 + 1, $pos3 - $pos2));

        $check = str_replace(
            ['return VersionFactory::detectVersion($this->useragent, $searches);', '$detector = new Version();'],
            ['return VersionFactory::detectVersion($this->useragent, $searches);', ''],
            $check
        );
    } elseif (preg_match('/private function detectVersion/', $filecontent)) {
        $pos1 = strpos($filecontent, 'private function detectVersion');
        $pos2 = strpos($filecontent, '{', $pos1);
        $pos3 = strpos($filecontent, "\n    }", $pos2);
        $check = trim(substr($filecontent, $pos2 + 1, $pos3 - $pos2));

        $check = str_replace(
            ['return VersionFactory::detectVersion($this->useragent, $searches);', '$detector = new Version();'],
            ['return VersionFactory::detectVersion($this->useragent, $searches);', ''],
            $check
        );
    } else {
        $check = 'return new Version(0);';
    }

    $templateContent = str_replace(
        ['###pdf###', '###rss###', '###skipalign###', '###websupport###', '###emptyoptions###', '###basic###', '###post###', '###type###', '###name###', '###Manu###', '###engine###', '###detectVersion###'],
        [$pdf, $rss, $skipalign, $websupport, $emptyoptions, $basic, $post, $type, $name, $manufacturer, $engine, $check],
        $templateContent
    );

    file_put_contents($fullpath, $templateContent);

    if (false !== strpos($templateContent, '#')) {
        echo 'placeholders found in file ', $fullpath, PHP_EOL;
        exit;
    }//exit;
}