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

$sourceDirectory = 'src\\Detector\\Os\\';

$iterator = new \RecursiveDirectoryIterator($sourceDirectory);

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $fullpath    = $file->getPathname();
    $filecontent = file_get_contents($fullpath);
    $matches     = [];

    if (!preg_match('/class (.*) extends AbstractOs/', $filecontent, $matches)
        && !preg_match('/class (.*)\\n    extends AbstractOs/', $filecontent, $matches)
    ) {
        echo 'class name not found in file ', $fullpath, PHP_EOL;
        continue;
    }

    $className = $matches[1];

    $targetFile = 'tests\\Detector\\Os\\' . $className . 'Test.php';

    if (file_exists($targetFile)) {
        continue;
    }

    $matches   = [];

    if (!preg_match('/namespace ([^;]+);/', $filecontent, $matches)
    ) {
        echo 'namespace not found in file ', $fullpath, PHP_EOL;
        continue;
    }

    $namespace = $matches[1];

    echo 'processing ', $fullpath, PHP_EOL;

    $testGenerator = new \SebastianBergmann\PHPUnit\SkeletonGenerator\TestGenerator($namespace . '\\' . $className, $fullpath, $className . 'Test', 'tests\\Detector\\Os\\' . $className . 'Test.php');
    $testContent = $testGenerator->generate();

    $testContent = str_replace('<?php', '<?php' . "\n\nnamespace BrowserDetectorTest\\Detector\\Os;\n\nuse BrowserDetector\\Detector\\Os\\$className;\n\n", $testContent);
    $testContent = str_replace('extends PHPUnit_Framework_TestCase', 'extends \\PHPUnit_Framework_TestCase', $testContent);
    $testContent = str_replace('protected $object', 'private $object', $testContent);
    $testContent = str_replace('$this->object = new ' . $className . ';', '$this->object = new ' . $className . '(\'Test-User-Agent\');', $testContent);
    $testContent = str_replace('$this->markTestIncomplete', 'static::markTestIncomplete', $testContent);

    file_put_contents($targetFile, $testContent);
}