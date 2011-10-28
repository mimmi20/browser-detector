<?php
/**
 * TODO:Description
 *
 * PHP version 5
 *
 * @category  kredit.geld.de
 * @package   form
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2009 Unister GmbH
 * @version   SVN: $Id: Form.php 13 2011-01-06 21:27:04Z tmu $
 */

/**
 * TODO:Description
 *
 * @category  kredit.geld.de
 * @package   form
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2009 Unister GmbH
 */
class Unister_Finance_Form extends Zend_Form
{
    protected $_parent = null;

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
     * @param mixed $parent
     *
     * @return void
     */
    public function __construct($parent = null)
    {
        $this->_parent = $parent;

        parent::__construct();
    }

    /**
     * Initialisierung der Form
     */
    public function init()
    {
        Zend_Dojo::enableForm($this);

        $this->addPrefixPath('Unister_Finance_Form_Decorator', LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'Form' . DS . 'Decorator', 'decorator');
        $this->addElementPrefixPath('Unister_Finance_Form_Decorator', LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'Form' . DS . 'Decorator', 'decorator');
    }

    /**
     * Render form
     *
     * @param  Zend_View_Interface $view
     * @return string
     */
    public function render(Zend_View_Interface $view = null)
    {
        if (null !== $view) {
            $this->setView($view);
        }

        $content = '';
        foreach ($this->getDecorators() as $decorator) {
            $decorator->setElement($this);
            $content = $decorator->render($content);
        }
        return $content;
    }
}