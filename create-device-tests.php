<?php
/**
 * Created by PhpStorm.
 * User: Thomas Müller
 * Date: 03.03.2016
 * Time: 07:22
 */

// @todo: add "phpunit/phpunit-skeleton-generator": "*" to composer.json to run this script

chdir(__DIR__);

require 'vendor/autoload.php';

ini_set('memory_limit', '-1');

$sourceDirectory = 'src\\Detector\\Device\\';

$iterator = new \RecursiveDirectoryIterator($sourceDirectory);

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $fullpath    = $file->getPathname();
    $filecontent = file_get_contents($fullpath);
    $matches     = [];

    if (!preg_match('/class (.*) extends Device/', $filecontent, $matches)
        && !preg_match('/class (.*)\\n    extends Device/', $filecontent, $matches)
    ) {
        echo 'class name not found in file ', $fullpath, PHP_EOL;
        continue;
    }

    $className = $matches[1];
    $matches   = [];

    if (!preg_match('/namespace ([^;]+);/', $filecontent, $matches)
    ) {
        echo 'namespace not found in file ', $fullpath, PHP_EOL;
        continue;
    }

    $namespace = $matches[1];

    echo 'processing ', $fullpath, PHP_EOL;

    $testGenerator = new \SebastianBergmann\PHPUnit\SkeletonGenerator\TestGenerator($namespace . '\\' . $className, $fullpath, $className . 'Test');
    $testContent = $testGenerator->generate();

    $testContent = str_replace('<?php', '<?php' . "\n\nnamespace " . str_replace('BrowserDetector', 'BrowserDetectorTest', $namespace) . ";\n\nuse $namespace\\$className;\n\n", $testContent);
    $testContent = str_replace('extends PHPUnit_Framework_TestCase', 'extends \\PHPUnit_Framework_TestCase', $testContent);
    $testContent = str_replace('protected $object', 'private $object', $testContent);
    $testContent = str_replace('$this->object = new ' . $className . ';', '$this->object = new ' . $className . '(\'Test-User-Agent\');', $testContent);
    $testContent = str_replace('$this->markTestIncomplete', 'static::markTestIncomplete', $testContent);

    if (!file_exists(str_replace('BrowserDetector', 'tests', $namespace))) {
        mkdir(str_replace('BrowserDetector', 'tests', $namespace));
    }

    file_put_contents(str_replace('BrowserDetector', 'tests', $namespace) . '\\' . $className . 'Test.php', $testContent);
}