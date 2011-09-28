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
class GetPartialFile extends GetFileAbstract
{
    /**
     * Strategy pattern: helper method to invoke
     *
     * @return mixed
     */
    public function direct($paid = null, $caid = null, $mode = null, $fileName = 'js', array $params = array())
    {
        $basePath = APPLICATION_PATH . DS . 'module' . DS . 'kredit-core' . DS
                  . 'views' . DS . 'scripts' . DS . 'partials' . DS;
        $file     = $basePath . $fileName;

        foreach ($params as $param => $value) {
            $this->view->$param = $value;
        }

        $content = $this->includeFile($file, true, $paid, $caid, $mode);

        return $content;
    }
}
