<?php
require_once LIB_PATH . 'Unister' . DS . 'View' . DS . 'Smarty.php';
require_once LIB_PATH . 'Zend' . DS . 'View' . DS . 'Interface.php';

/**
 * TODO
 *
 * @author Thomas Mueller <thomas.mueller@unister-gmbh.de>
 */
class Unister_Finance_Smarty extends Unister_View_Smarty implements Zend_View_Interface
{
    /**
     * Constructor
     *
     * @param string $tmplPath
     * @param array $extraParams
     * @return void
     */
    public function __construct($tmplPath = null, $extraParams = array())
    {
        require_once LIB_PATH . 'Smarty' . DS . 'Smarty.class.php';

        $this->_smarty = new Smarty;

        if (null !== $tmplPath) {
            $this->setScriptPath($tmplPath);
        }

        foreach ($extraParams as $key => $value) {
            $this->_smarty->$key = $value;
        }
    }
}