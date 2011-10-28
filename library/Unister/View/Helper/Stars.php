<?php

/**
 *
 * @author a.hoffmann
 *
 */
class Unister_View_Helper_Stars extends Zend_View_Helper_Abstract
{

    public function stars($review)
    {
        if (!is_numeric($review)) {
            return '';
        }

        $return = '';
        $source = $this->view->mandantImage('star.png');
        $source_half = $this->view->mandantImage('star_half.png');
        for ($i = 1; $i <= $review; $i++) {
            $return .= "<img src='$source' alt='*' />";
        }
        if (strlen($review) > 1) {
            $return .= "<img src='$source_half' alt='*' />";
        }

        return $return;
    }

}