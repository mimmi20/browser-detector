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

$factoryFile    = 'src\\Detector\\Factory\\BrowserFactory.php';
$factoryContent = file_get_contents($factoryFile);

$classMatches = [];

preg_match_all('/return new ([^\(]+)\(\$useragent, \[\]\)\;/', $factoryContent, $classMatches);
$sourceDirectory = 'src\\Detector\\Browser\\';

$processedClases = [];

foreach ($classMatches[1] as $index => $classBasename) {
    $classFile = $sourceDirectory . $classBasename . '.php';

    echo 'processing ', $classFile, PHP_EOL;

    if (!file_exists($classFile)) {
        str_replace($classMatches[0][$index], $classMatches[0][$index] . ' // file not found', $factoryContent);
        file_put_contents($factoryFile, $factoryContent);

        continue;
    }

    if (in_array($classBasename, $processedClases)) {
        continue;
    }

    $filecontent = file_get_contents($classFile);
    $pdfMatches  = [];

    if (preg_match('/\$this\->pdfSupport\s+= (true|false)/', $filecontent, $pdfMatches)) {
        $pdf = $pdfMatches[1];
    } else {
        $pdf = 'false';
    }

    $rssMatches = [];

    if (preg_match('/\$this\->rssSupport\s+= (true|false)/', $filecontent, $rssMatches)) {
        $rss = $rssMatches[1];
    } else {
        $rss = 'null';
    }

    $skipMatches = [];

    if (preg_match('/\$this\->canSkipAlignedLinkRow\s+= (true|false)/', $filecontent, $skipMatches)) {
        $skipalign = $skipMatches[1];
    } else {
        $skipalign = 'null';
    }

    $webMatches = [];

    if (preg_match('/\$this\->claimsWebSupport\s+= (true|false)/', $filecontent, $webMatches)) {
        $websupport = $webMatches[1];
    } else {
        $websupport = 'null';
    }

    $emptyMatches = [];

    if (preg_match('/\$this\->supportsEmptyOptionValues\s+= (true|false)/', $filecontent, $emptyMatches)) {
        $emptyoptions = $emptyMatches[1];
    } else {
        $emptyoptions = 'null';
    }

    $basicMatches = [];

    if (preg_match('/\$this\->supportsBasicAuthentication\s+= (true|false)/', $filecontent, $basicMatches)) {
        $basic = $basicMatches[1];
    } else {
        $basic = 'null';
    }

    $postMatches = [];

    if (preg_match('/\$this\->supportsPostMethod\s+= (true|false)/', $filecontent, $postMatches)) {
        $post = $postMatches[1];
    } else {
        $post = 'null';
    }

    $typeMatches = [];

    if (preg_match('/\$this\->type\s+= new UaBrowserType\\\\([^\\(]+)/', $filecontent, $typeMatches)) {
        $type = $typeMatches[1];
    } else {
        $type = 'Unknown';
    }

    $nameMatches = [];

    if (preg_match('/\$this\->name\s+= \\\'([^\\\\\']+)\\\'/', $filecontent, $nameMatches)) {
        $name = $nameMatches[1];
    } else {
        $name = 'unknown';
    }

    $manuMatches = [];

    if (preg_match('/\$this\->manufacturer\s+= \\(new Company\\\\([^\\(]+)/', $filecontent, $manuMatches)) {
        $manufacturer = $manuMatches[1];
    } else {
        $manufacturer = 'Unknown';
    }

    $engineMatches = [];

    if (preg_match('/getEngine\\(\\)\\n    {\\n        return new Engine\\\\([^\\(]+)/', $filecontent, $engineMatches)) {
        $engine = $engineMatches[1];
    } else {
        $engine = 'UnknownEngine';
    }

    $delete         = false;
    $rename         = false;
    $rewrite        = false;
    $versionMatches = [];

    if (preg_match('/\$this\->version\s+= (VersionFactory::detectVersion[^\\;]+)/', $filecontent, $versionMatches)) {
        $version = $versionMatches[1];
        $delete  = true;
        $rewrite = true;
    } elseif (preg_match('/\$this\->version\s+= (new Version[^\\;]+)/', $filecontent, $versionMatches)) {
        $version = $versionMatches[1];
        $delete  = true;
        $rewrite = true;
    } elseif (preg_match('/\$this\->version\s+= (\\\\BrowserDetector\\\\Detector\\\\Version[^\\;]+)/', $filecontent, $versionMatches)) {
        $version = $versionMatches[1];
        $delete  = true;
        $rewrite = true;
    } elseif (preg_match('/public function detectVersion/', $filecontent)) {
        $pos1 = strpos($filecontent, 'public function detectVersion');
        $pos2 = strpos($filecontent, '{', $pos1);
        $pos3 = strpos($filecontent, "\n    }", $pos2);
        $check = trim(substr($filecontent, $pos2 + 1, $pos3 - $pos2));

        $countNewlines = substr_count($check, "\n");

        if (0 === $countNewlines && preg_match('/return (new Version[^\\;]+)/', $check, $versionMatches)) {
            $version = $versionMatches[1];
            $delete  = true;
            $rewrite = true;
        } elseif (0 === $countNewlines && preg_match('/return (VersionFactory::detectVersion[^\\;]+)/', $check, $versionMatches)) {
            $version = str_replace('$this->useragent', '$useragent', $versionMatches[1]);
            $delete  = true;
            $rewrite = true;
        } elseif (2 === $countNewlines) {
            $serachMatches = [];

            if (preg_match('/return (VersionFactory::detectVersion\(\$this\-\>useragent, \$searches\))/', $check, $versionMatches)
                && preg_match('/\$searches = ([^\\;]+)/', $check, $serachMatches)
            ) {

                $version = str_replace(['$this->useragent', '$searches'], ['$useragent', $serachMatches[1]], $versionMatches[1]);
                $delete  = true;
                $rewrite = true;
            }
        } elseif (2 <= $countNewlines && !preg_match('/VersionFactory::set/', $check)) {
            $serachMatches = [];

            if (preg_match('/return (VersionFactory::detectVersion\(\$this\-\>useragent, \$searches\))/', $check, $versionMatches)
                && preg_match('/\$searches = ([^\\;]+)/', $check, $serachMatches)
            ) {

                $version = str_replace(['$this->useragent', '$searches'], ['$useragent', str_replace(["\r\n", "\n"], '', $serachMatches[1])], $versionMatches[1]);
                $delete  = true;
                $rewrite = true;
            }
        } else {
            echo 'processing file #', $index, ': ', $classFile, PHP_EOL;
            var_dump($countNewlines, $check);

            $version = 'null';
        }
    } elseif (preg_match('/private function detectVersion/', $filecontent)) {
        $pos1 = strpos($filecontent, 'private function detectVersion');
        $pos2 = strpos($filecontent, '{', $pos1);
        $pos3 = strpos($filecontent, "\n    }", $pos2);
        $check = trim(substr($filecontent, $pos2 + 1, $pos3 - $pos2));

        $countNewlines = substr_count($check, "\n");

        if (0 === $countNewlines && preg_match('/return (new Version[^\\;]+)/', $check, $versionMatches)) {
            $version = $versionMatches[1];
            $delete  = true;
            $rewrite = true;
        } elseif (0 === $countNewlines && preg_match('/return (VersionFactory::detectVersion[^\\;]+)/', $check, $versionMatches)) {
            $version = str_replace('$this->useragent', '$useragent', $versionMatches[1]);
            $delete  = true;
            $rewrite = true;
        } elseif (2 === $countNewlines) {
            $serachMatches = [];

            if (preg_match('/return (VersionFactory::detectVersion\(\$this\-\>useragent, \$searches\))/', $check, $versionMatches)
                && preg_match('/\$searches = ([^\\;]+)/', $check, $serachMatches)
            ) {

                $version = str_replace(['$this->useragent', '$searches'], ['$useragent', $serachMatches[1]], $versionMatches[1]);
                $delete  = true;
                $rewrite = true;
            }
        } elseif (2 <= $countNewlines && !preg_match('/VersionFactory::set/', $check)) {
            $serachMatches = [];

            if (preg_match('/return (VersionFactory::detectVersion\(\$this\-\>useragent, \$searches\))/', $check, $versionMatches)
                && preg_match('/\$searches = ([^\\;]+)/', $check, $serachMatches)
            ) {

                $version = str_replace(['$this->useragent', '$searches'], ['$useragent', str_replace(["\r\n", "\n"], '', $serachMatches[1])], $versionMatches[1]);
                $delete  = true;
                $rewrite = true;
            }
        } else {
            echo 'processing file #', $index, ': ', $classFile, PHP_EOL;
            var_dump($countNewlines, $check);

            $version = 'null';
        }
    } else {
        $version = 'null';
        echo PHP_EOL, PHP_EOL, $filecontent, PHP_EOL, PHP_EOL;
        //exit;
    }

    if ($rewrite) {
        $newCall = 'return new \UaResult\Browser\Browser($useragent, \'' . $name . '\', ' . $version . ', \'' . $manufacturer . '\', $bits, new UaBrowserType\\' . $type . '(), ' . $pdf . ', ' . $rss . ', ' . $skipalign . ', ' . $websupport . ', ' . $emptyoptions . ', ' . $basic . ', ' . $post . ');';

        $factoryContent = str_replace($classMatches[0][$index], $newCall, $factoryContent);
        file_put_contents($factoryFile, $factoryContent);

        $processedClases[] = $classBasename;
    } else {
        $delete = false;
    }

    if ($delete) {
        echo 'removing ', $classFile, PHP_EOL;

        unlink($classFile);
    }
}

$iterator = new \RecursiveDirectoryIterator($sourceDirectory);

foreach (new \RecursiveIteratorIterator($iterator) as $file) {
    /** @var $file \SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $filename = $file->getFilename();

    $skip = [
        'AbstractBrowser.php',
    ];
    
    if (in_array($filename, $skip)) {
        continue;
    }

    $fullpath    = $file->getPathname();
    $pathMatches = [];

    $template = 'data/templates/general-browser.php.tmp';

    $filecontent = file_get_contents($fullpath);
    $matches     = [];

    if (!preg_match('/class (.*) extends AbstractBrowser/', $filecontent, $matches)
        && !preg_match('/class (.*)\\n    extends AbstractBrowser/', $filecontent, $matches)
    ) {
        echo 'class name not found in file ', $fullpath, PHP_EOL;
        continue;
    }

    $classBasename = $file->getBasename('.php');

    if (in_array($classBasename, $processedClases)) {
        continue;
    }

    echo 'processing ', $fullpath, PHP_EOL;

    $pdfMatches  = [];

    if (preg_match('/\$this\->pdfSupport\s+= (true|false)/', $filecontent, $pdfMatches)) {
        $pdf = $pdfMatches[1];
    } else {
        $pdf = 'false';
    }

    $rssMatches = [];

    if (preg_match('/\$this\->rssSupport\s+= (true|false)/', $filecontent, $rssMatches)) {
        $rss = $rssMatches[1];
    } else {
        $rss = 'null';
    }

    $skipMatches = [];

    if (preg_match('/\$this\->canSkipAlignedLinkRow\s+= (true|false)/', $filecontent, $skipMatches)) {
        $skipalign = $skipMatches[1];
    } else {
        $skipalign = 'null';
    }

    $webMatches = [];

    if (preg_match('/\$this\->claimsWebSupport\s+= (true|false)/', $filecontent, $webMatches)) {
        $websupport = $webMatches[1];
    } else {
        $websupport = 'null';
    }

    $emptyMatches = [];

    if (preg_match('/\$this\->supportsEmptyOptionValues\s+= (true|false)/', $filecontent, $emptyMatches)) {
        $emptyoptions = $emptyMatches[1];
    } else {
        $emptyoptions = 'null';
    }

    $basicMatches = [];

    if (preg_match('/\$this\->supportsBasicAuthentication\s+= (true|false)/', $filecontent, $basicMatches)) {
        $basic = $basicMatches[1];
    } else {
        $basic = 'null';
    }

    $postMatches = [];

    if (preg_match('/\$this\->supportsPostMethod\s+= (true|false)/', $filecontent, $postMatches)) {
        $post = $postMatches[1];
    } else {
        $post = 'null';
    }

    $typeMatches = [];

    if (preg_match('/\$this\->type\s+= new UaBrowserType\\\\([^\\(]+)/', $filecontent, $typeMatches)) {
        $type = $typeMatches[1];
    } else {
        $type = 'Unknown';
    }

    $nameMatches = [];

    if (preg_match('/\$this\->name\s+= \\\'([^\\\\\']+)\\\'/', $filecontent, $nameMatches)) {
        $name = $nameMatches[1];
    } else {
        $name = 'unknown';
    }

    $manuMatches = [];

    if (preg_match('/\$this\->manufacturer\s+= \\(new Company\\\\([^\\(]+)/', $filecontent, $manuMatches)) {
        $manufacturer = $manuMatches[1];
    } else {
        $manufacturer = 'Unknown';
    }

    $engineMatches = [];

    if (preg_match('/getEngine\\(\\)\\n    {\\n        return new Engine\\\\([^\\(]+)/', $filecontent, $engineMatches)) {
        $engine = $engineMatches[1];
    } else {
        $engine = 'UnknownEngine';
    }

    $delete         = false;
    $rename         = false;
    $rewrite        = false;
    $versionMatches = [];

    if (preg_match('/\$this\->version\s+= (VersionFactory::detectVersion[^\\;]+)/', $filecontent, $versionMatches)) {
        $version = $versionMatches[1];
        $delete  = true;
        $rewrite = true;
    } elseif (preg_match('/\$this\->version\s+= (new Version[^\\;]+)/', $filecontent, $versionMatches)) {
        $version = $versionMatches[1];
        $delete  = true;
        $rewrite = true;
    } elseif (preg_match('/\$this\->version\s+= (\\\\BrowserDetector\\\\Detector\\\\Version[^\\;]+)/', $filecontent, $versionMatches)) {
        $version = $versionMatches[1];
        $delete  = true;
        $rewrite = true;
    } elseif (preg_match('/public function detectVersion/', $filecontent)) {
        $pos1 = strpos($filecontent, 'public function detectVersion');
        $pos2 = strpos($filecontent, '{', $pos1);
        $pos3 = strpos($filecontent, "\n    }", $pos2);
        $check = trim(substr($filecontent, $pos2 + 1, $pos3 - $pos2));

        $countNewlines = substr_count($check, "\n");

        if (0 === $countNewlines && preg_match('/return (new Version[^\\;]+)/', $check, $versionMatches)) {
            $version = $versionMatches[1];
            $delete  = true;
            $rewrite = true;
        } elseif (0 === $countNewlines && preg_match('/return (VersionFactory::detectVersion[^\\;]+)/', $check, $versionMatches)) {
            $version = str_replace('$this->useragent', '$useragent', $versionMatches[1]);
            $delete  = true;
            $rewrite = true;
        } elseif (2 === $countNewlines) {
            $serachMatches = [];

            if (preg_match('/return (VersionFactory::detectVersion\(\$this\-\>useragent, \$searches\))/', $check, $versionMatches)
                && preg_match('/\$searches = ([^\\;]+)/', $check, $serachMatches)
            ) {

                $version = str_replace(['$this->useragent', '$searches'], ['$useragent', $serachMatches[1]], $versionMatches[1]);
                $delete  = true;
                $rewrite = true;
            }
        } elseif (2 <= $countNewlines && !preg_match('/VersionFactory::set/', $check)) {
            $serachMatches = [];

            if (preg_match('/return (VersionFactory::detectVersion\(\$this\-\>useragent, \$searches\))/', $check, $versionMatches)
                && preg_match('/\$searches = ([^\\;]+)/', $check, $serachMatches)
            ) {

                $version = str_replace(['$this->useragent', '$searches'], ['$useragent', str_replace(["\r\n", "\n"], '', $serachMatches[1])], $versionMatches[1]);
                $delete  = true;
                $rewrite = true;
            }
        } else {
            echo 'processing file #', $index, ': ', $classFile, PHP_EOL;
            var_dump($countNewlines, $check);

            $version = 'null';
        }
    } elseif (preg_match('/private function detectVersion/', $filecontent)) {
        $pos1 = strpos($filecontent, 'private function detectVersion');
        $pos2 = strpos($filecontent, '{', $pos1);
        $pos3 = strpos($filecontent, "\n    }", $pos2);
        $check = trim(substr($filecontent, $pos2 + 1, $pos3 - $pos2));

        $countNewlines = substr_count($check, "\n");

        if (0 === $countNewlines && preg_match('/return (new Version[^\\;]+)/', $check, $versionMatches)) {
            $version = $versionMatches[1];
            $delete  = true;
            $rewrite = true;
        } elseif (0 === $countNewlines && preg_match('/return (VersionFactory::detectVersion[^\\;]+)/', $check, $versionMatches)) {
            $version = str_replace('$this->useragent', '$useragent', $versionMatches[1]);
            $delete  = true;
            $rewrite = true;
        } elseif (2 === $countNewlines) {
            $serachMatches = [];

            if (preg_match('/return (VersionFactory::detectVersion\(\$this\-\>useragent, \$searches\))/', $check, $versionMatches)
                && preg_match('/\$searches = ([^\\;]+)/', $check, $serachMatches)
            ) {

                $version = str_replace(['$this->useragent', '$searches'], ['$useragent', $serachMatches[1]], $versionMatches[1]);
                $delete  = true;
                $rewrite = true;
            }
        } elseif (2 <= $countNewlines && !preg_match('/VersionFactory::set/', $check)) {
            $serachMatches = [];

            if (preg_match('/return (VersionFactory::detectVersion\(\$this\-\>useragent, \$searches\))/', $check, $versionMatches)
                && preg_match('/\$searches = ([^\\;]+)/', $check, $serachMatches)
            ) {

                $version = str_replace(['$this->useragent', '$searches'], ['$useragent', str_replace(["\r\n", "\n"], '', $serachMatches[1])], $versionMatches[1]);
                $delete  = true;
                $rewrite = true;
            }
        } else {
            echo 'processing file #', $index, ': ', $classFile, PHP_EOL;
            var_dump($countNewlines, $check);

            $version = 'null';
        }
    } else {
        $version = 'null';
        echo PHP_EOL, PHP_EOL, $filecontent, PHP_EOL, PHP_EOL;
        //exit;
    }

    $endpos = strpos($factoryContent, "        }\n\n        return new \\UaResult\\Browser\\Browser(\$useragent, 'unknown'");

    if ($rewrite && false !== $endpos) {
        $newCall = 'return new \UaResult\Browser\Browser($useragent, \'' . $name . '\', ' . $version . ', \'' . $manufacturer . '\', $bits, new UaBrowserType\\' . $type . '(), ' . $pdf . ', ' . $rss . ', ' . $skipalign . ', ' . $websupport . ', ' . $emptyoptions . ', ' . $basic . ', ' . $post . ');';

        $factoryContent = substr_replace($factoryContent, ' elseif () {' . "\n" . '            ' . $newCall . "\n" . '        }', $endpos + 9, 0);
        file_put_contents($factoryFile, $factoryContent);

        $processedClases[] = $classBasename;
        $delete = false;
    } else {
        $delete = false;
    }

    if ($delete) {
        echo 'removing ', $fullpath, PHP_EOL;

        unlink($fullpath);
    }
}