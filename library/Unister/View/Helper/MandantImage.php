<?php

require_once 'BaseUrl.php';

/**
 * View Helper to determine the valid public image path for Mandanten
 * @author a.hoffmann
 *
 */
class Unister_View_Helper_MandantImage extends Unister_View_Helper_BaseUrl
{

    /**
     *
     * @param $image Image File without Path
     * @return unknown_type
     */
    public function mandantImage($image)
    {
        $baseUrl = trim(parent::baseUrl(), '/');

        $folder = App_Mandant::getFolder();
        if (App_Mandant::isMandant() && !empty($folder)) {

            return $baseUrl . str_replace('//', '/', "/mandant/{$folder}/images/{$image}");
        } else {
            return $baseUrl . str_replace('//', '/', "/images/{$image}");
        }
    }

}