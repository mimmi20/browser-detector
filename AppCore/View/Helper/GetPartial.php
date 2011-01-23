<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\View\Helper;

/**
 * View-Helper
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   View_Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: GetPartial.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * @category  Kreditrechner
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
