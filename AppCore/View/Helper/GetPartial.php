<?php
declare(ENCODING = 'utf-8');
namespace AppCore\View\Helper;

/**
 * View-Helper
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   View_Helper
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * @category  CreditCalc
 * @package   View_Helper
 */
class GetPartial extends \Zend\View\Helper\AbstractHelper
{
    /**
     * Strategy pattern: helper method to invoke
     *
     * @return string
     */
    public function direct($sparte = 'Kredit', $institut = '', $mode = 'js', $product = '', $include = false)
    {
        $file = $this->view->getInstituteFileName(
            $sparte, $institut, $mode, $product
        );

        if ($include) {
            $file = $this->view->includeFile($file);

            if ($file == '') {
                $file = '<!-- no information found -->';
            }
        }

        return $file;
    }
}
