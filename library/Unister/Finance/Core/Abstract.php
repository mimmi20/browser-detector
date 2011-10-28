<?php
require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'Abstract.php';

/**
 * TODO
 *
 * @author Thomas Mueller <thomas.mueller@unister-gmbh.de>
 */
abstract class Unister_Finance_Core_Abstract extends Unister_Finance_Abstract
{
    /**
     * View Object
     *
     * @var Zend_View View-Objekt
     */
    protected $_view = null;

    /**
     * Module Object
     *
     * @var Unister_Finance_Core_Module Objekt
     */
    protected $_module = null;

    /**
     * Class constructor
     *
     * The request and response objects should be registered with the
     * controller, as should be any additional optional arguments; these will be
     * available via {@link getRequest()}, {@link getResponse()}, and
     * {@link getInvokeArgs()}, respectively.
     *
     * When overriding the constructor, please consider this usage as a best
     * practice and ensure that each is registered appropriately; the easiest
     * way to do so is to simply call parent::__construct($request, $response,
     * $invokeArgs).
     *
     * After the request, response, and invokeArgs are set, the
     * {@link $_helper helper broker} is initialized.
     *
     * Finally, {@link init()} is called as the final action of
     * instantiation, and may be safely overridden to perform initialization
     * tasks; as a general rule, override {@link init()} instead of the
     * constructor to customize an action controller's instantiation.
     *
     * @param mixed  $view
     *
     * @return void
     * @access public
     */
    public function __construct()
    {
        parent::__construct();                //$this->_db = Zend_Registry::get('db');
        
        //$this->_view = $view;
    }

    /**
     * Class destructor
     *
     * @return void
     * @access public
     */
    public function __destruct()
    {
        //unset($this->_view);        //unset($this->_db);
        
        parent::__destruct();
    }
}