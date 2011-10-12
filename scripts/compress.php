#!/usr/bin/env /usr/bin/php
<?php


$basePath = dirname(__FILE__) .'/../';

/**
 * Load Config
 */
set_include_path($basePath . '/library/');
$docRoot = $_SERVER['DOCUMENT_ROOT'] . '/';

require_once $basePath . 'library/Zend/Config.php';
require_once $basePath . 'library/Zend/Config/Ini.php';

$config = new Zend_Config_Ini($basePath . 'scripts/compress.ini', 'deployment');

//var_dump($config->css->enable);
$cssDirs = $config->css->include->toArray();
$jsDir   = $config->js->include->toArray();


/**
 * Css Minify
 */
if ($config->css->enable) {
    require_once $basePath . '/library/Unister/Compressor/CSSMin.php';

    /*
     * Minify all dirs in the cssDirs array
     */
    foreach ($cssDirs as $dir) {
        try {
            $fullPfad = realpath($basePath . $dir);

            echo 'compress CSS folder: \'' . $fullPfad . "' ...  \n";
            minifyCssFolder($fullPfad);
        } catch (Exception $e) {
            echo 'failure ' . "\n";
            echo $e->getMessage();
            echo "\n\n";
        }
    }
}
/**
 * End Css Minify
 */


/**
 * Js Minify
 */
if ($config->js->enable) {
    require_once $basePath . '/library/Unister/Compressor/JSMin2.php';

    /*
     * Minify all dirs in the jsDirs array
     */
    foreach ($jsDir as $dir) {
        try {
            $fullPfad = realpath($basePath . $dir);

            echo 'compress JS folder: \'' . $fullPfad . "' ...  \n";
            minifyJsFolder($fullPfad);
        } catch (Exception $e) {
            echo 'failure ' . "\n";
            echo $e->getMessage();
            echo "\n\n";
        }
    }
}
/**
 * End Js Minify
 */






/**
 *
 * Iterate trough the filesystem and all subfolder to get css files
 *
 * @param string $handle
 *
 * @return boolean
 */
function minifyCssFolder($path)
{
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
            echo 'compress CSS folder: \'' . $fullPfad . "' ...  \n";

            $dir = minifyCssFolder($fullPfad);
        } elseif (preg_match('~.*\.css$~', $file->getFilename())
            && !preg_match('~.*\.min\.css$~', $file->getFilename())
        ) {
            $fullPath = realpath($file->getPath() .'/' . $file->getFilename());

            $oldContent = file_get_contents($fullPath);
            $newContent = Unister_Compressor_CSSMin::minify($oldContent);

            echo 'minify "' . $fullPath . '" old:' . strlen($oldContent) . 'B => ' . strlen($newContent) . 'B' . "\n";

            file_put_contents($fullPath, $newContent);
        }
    }

    return true;
}


/**
 *
 * Iterate trough the filesystem and all subfolder to get css files
 *
 * @param string $handle
 *
 * @return boolean
 */
function minifyJsFolder($path)
{
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
            echo 'compress JS folder: \'' . $fullPfad . "' ...  \n";
            $dir = minifyJsFolder($fullPfad);
        } elseif (preg_match('~.*\.js$~', $file->getFilename())
            && !preg_match('~.*\.min\.js$~', $file->getFilename())
        ) {
            $fullPath = realpath($file->getPath() .'/' . $file->getFilename());

            $oldContent = file_get_contents($fullPath);
            $newContent = Unister_Compressor_JSMin2::minify($oldContent);

            echo 'minify "' . $fullPath . '" old:' . strlen($oldContent) . 'B => ' . strlen($newContent) . 'B' . "\n";

            file_put_contents($fullPath, $newContent);
        }
    }

    return true;
}


/**
 *
 * Calls the google closure compile  to minify the js
 * @param string $fileContent
 *
 * @return string Minified Js
 */
function getMinifyJs($fileContent)
{

    $jsCode = $fileContent;

    $service_url = 'http://closure-compiler.appspot.com/compile';
    $header = array(
            "Content-type: application/x-www-form-urlencoded",
    );

    $curl = curl_init($service_url);
    $curl_post_data = array(
            "js_code" => $jsCode,
            "compilation_level" =>'SIMPLE_OPTIMIZATIONS' ,
            "output_format" => 'json',
            "output_info" => 'compiled_code',

    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($curl_post_data).'&output_info=errors');
    $curl_response = curl_exec($curl);

    curl_close($curl);


    var_dump(json_decode($curl_response));
    die();
    return $curl_response;
}

