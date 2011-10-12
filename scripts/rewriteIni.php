#!/usr/bin/env /usr/bin/php
<?php
$basePath = dirname(__FILE__) .'/../';

include $basePath . 'public/constants.php';

/**
 * Load Config
 */

set_include_path($basePath . '/library/');
$docRoot = $_SERVER['DOCUMENT_ROOT'] . '/';
require_once $basePath . 'library/Zend/Config.php';
require_once $basePath . 'library/Zend/Config/Ini.php';

$config  = new Zend_Config_Ini($basePath . 'scripts/rewriteIni.ini', 'deployment');
$iniDirs = $config->ini->include->toArray();


/**
 * Css Minify
 */

if ($config->ini->enable) {
    require_once $basePath . 'application/module/kredit-core/classes/Config/Writer/Array.php';

    /*
     * Minify all dirs in the cssDirs array
     */
    foreach ($iniDirs as $dir) {
        try {
            changeIniFolder(realpath($basePath . $dir));
        } catch (Exception $e) {
            echo "failure \n";
            echo $e->getMessage();
            echo "\n \n";
        }
    }
}

/**
 *
 * Iterate trough the filesystem and all subfolder to get css files
 *
 * @param string $handle
 *
 * @return boolean
 */
function changeIniFolder($path)
{
    echo 'convert INI folder: "' . $path . '" ... ' . "\n";

    $writer = new KreditCore_Class_Config_Writer_Array();
    //$writer = new Zend_Config_Writer_Array();

    foreach (new DirectoryIterator($path) as $file) {
        // if the file is not this file, and does not start with a '.' or '..',
        if ($file->isDot()) {
            continue;
        }

        $pfad = $file->getFilename();

        if ($pfad == basename($_SERVER['PHP_SELF'])) {
            continue;
        }

        $fullPfad = realpath($path . '/'. $pfad);

        // then store it for later display
        if ($file->isDir() && substr($pfad, 0, 1) != '.') {
            $dir = changeIniFolder($fullPfad);
        } elseif ('browscap.ini' != $pfad && preg_match('~.*\.ini$~', $pfad)) {
            echo 'convert "' . $fullPfad . '" ' . "\n";

            $config = new Zend_Config_Ini(
                $fullPfad,
                null,
                array(
                    'skipExtends'        => false,
                    'allowModifications' => false
                )
            );

            $filename = str_replace('ini', 'php', $fullPfad);
            $writer->write($filename, $config);
        }
    }
    return true;

}