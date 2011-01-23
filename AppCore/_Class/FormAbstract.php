<?php
/**
 * abstrakte Basis-Klasse für alle Formulare
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Form
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: FormAbstract.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * abstrakte Basis-Klasse für alle Formulare
 *
 * @category  Kreditrechner
 * @package   Form
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class KreditCore_Class_FormAbstract extends Zend_Form
{
    /**
     * Config
     * @var array
     */
    protected $_config;

    /**
     * Global config
     *
     * @var array
     */
    protected $_appConfig;

    /**
     * Tab index iterator
     *
     * @var int
     */
    protected $_tabIndex = 1;

    /**
     * Current person starting with 0
     *
     * @var int
     */
    protected $_currentPerson = 0;

    /**
     * Number of persons
     *
     * @var int
     */
    protected $_totalPersons = 1;

    /**
     * Calc mode
     *
     * @var int
     * @see /application/configs/constants.php
     */
    protected $_calcFor = null;

    /**
     * Max number of persons to handle
     * @var Integer
     */
    protected $_handlePersons = 1;

    /**
     * Maps the original element names with the ones the Zend_Form class
     * sanitizes for the HTML output
     * @var array
     */
    protected $_mapArray = array();

    //public $name = null;

    /**
     * Element decorators
     *
     * @var array
     */
    /*
    protected $_elementDecorators = array(
        'ViewHelper',
        array('Errors', array('class' => 'Errors')),
        array('Label',  array(
            'class' => 'Label',
            '//requiredSuffix' => ' <span class="//requiredFlag">*</span>',
            'escape' => false
        ))
    );
    */

    /**
     * Decorator fuer die Form
     */
    public $formDecorators = array(
        'FormElements',
        array('HtmlTag', array('tag' => 'div')),
        'Form',
    );

    //Decorator fuer die Form
    public $formDecoratorsX = array(
        'FormElements',
        array('HtmlTag', array('tag' => 'div', 'style' => 'display:inline;')),
        'Form',
    );

    public $formDecoratorsDojo = array(
        'FormElements',
        array('HtmlTag', array('tag' => 'div')),
        'DijitForm',
    );

    public $subFormDecorators = array(
        'FormElements',
        'Fieldset',
    );

    //Decorator fuer die erste Zeile
    public $elementDecoratorsLogin = array(
        'ViewHelper',
        array('Errors', array('class' => 'Errors')),
        array('Description', array(
            'tag' => 'span',
            'class' => 'small description',
            'escape'=> false
        )),
        //array('Info', array('tag' => 'span', 'class' => 'info')),
        array('HtmlTag', array(
            'tag' => 'dd',
            'class' => 'content'
        )),
        array('Label',  array(
            'tag' => 'dt',
            'class' => 'Label',
            '//requiredSuffix' => ' <span class="//requiredFlag">*</span>',
            'escape' => false
        )),
        array('Row', array('tag' => 'dl', 'class' => '')),
    );

    //Decorator fuer die zweite Zeile
    public $elementDecoratorsSubmitLogin = array(
        'ViewHelper',
        array('HtmlTag', array(
            'tag' => 'dd',
            'class' => 'content'
        )),
        array('Label',  array(
            'tag' => 'dt',
            'class' => 'unvisible',
            'escape' => false
        )),
        /*
        array('Row', array(
            'tag' => 'dl',
            'class' => 'submit'
        )),*/
    );

    //Decorator fuer die erste Zeile
    public $elementDecorators = array(
        'ViewHelper',
        array('Errors', array('class' => 'Errors')),
        array('Description', array(
            'tag' => 'span',
            'class' => 'small description',
            'escape'=> false
        )),
        //array('Info', array('tag' => 'span', 'class' => 'info')),
        array('HtmlTag', array(
            //'tag' => '',
            'class' => 'content'
        )),
        array('Label',  array(
            //'tag' => '',
            'class' => 'label',
            '//requiredSuffix' => ' <span class="//requiredFlag">*</span>',
            'escape' => false
        )),
        //array('Row', array('tag' => 'div', 'class' => '')),
    );

    //Decorator fuer die erste Zeile
    public $elementDecoratorsDl = array(
        'ViewHelper',
        array('Errors', array('class' => 'Errors')),
        array('Description', array(
            'tag' => 'dt',
            'class' => 'small description',
            'escape'=> false
        )),
        //array('Info', array('tag' => 'span', 'class' => 'info')),
        //array('HtmlTag', array(
        //    'tag' => 'dd'
        //)),
        array('Label',  array(
            '//requiredSuffix' => ' <span class="//requiredFlag">*</span>',
            'escape' => false
        )),
        //array('Row', array('tag' => 'dl')),
    );

    //Decorator fuer die erste Zeile
    public $elementDecoratorsOdd = array(
        'ViewHelper',
        array('Errors', array('class' => 'Errors')),
        array('Description', array(
            'tag' => 'span',
            'class' => 'small description',
            'escape'=> false
        )),
        //array('Info', array('tag' => 'span', 'class' => 'info')),
        array('HtmlTag', array(
            'tag' => 'span',
            'class' => 'content'
        )),
        array('Label',  array(
            'tag' => 'span',
            'class' => 'label',
            '//requiredSuffix' => ' <span class="//requiredFlag">*</span>',
            'escape' => false
        )),
        array('Row', array(
            'tag' => 'div',
            'class' => 'odd'
        )),
    );

    //Decorator fuer die zweite Zeile
    public $elementDecoratorsEven = array(
        'ViewHelper',
        array('Errors', array('class' => 'Errors')),
        array('Description', array(
            'tag' => 'span',
            'class' => 'small description',
            'escape'=> false
        )),
        //array('Info', array('tag' => 'span', 'class' => 'info')),
        array('HtmlTag', array(
            'tag' => 'span',
            'class' => 'content'
        )),
        array('Label',  array(
            'tag' => 'span',
            'class' => 'label',
            '//requiredSuffix' => ' <span class="//requiredFlag">*</span>',
            'escape' => false
        )),
        array('Row', array(
            'tag' => 'div',
            'class' => 'even'
        )),
    );

    //Decorator fuer die zweite Zeile
    public $elementDecoratorsSubmit = array(
        'ViewHelper',
        array('HtmlTag', array(
            'tag' => 'span',
            'class' => 'content'
        )),
        array('Label',  array(
            'tag' => 'span',
            'class' => 'unvisible',
            'escape' => false
        )),
        array('Row', array(
            'tag' => 'div',
            'class' => 'submit'
        )),
    );

    //Decorator fuer die zweite Zeile
    public $elementDecoratorsHidden = array(
        'ViewHelper',
        array('Row', array(
            'tag' => 'div',
            'class' => 'hidden'
        )),
    );

    //Decorator fuer die erste Zeile (Dojo-Element)
    public $elementDecoratorsDojoOdd = array(
        'DijitElement',
        array('Errors', array('class' => 'Errors')),
        array('Description', array(
            'tag' => 'span',
            'class' => 'small description',
            'escape'=> false
        )),
        //array('Info', array('tag' => 'span', 'class' => 'info')),
        array('HtmlTag', array(
            'tag' => 'span',
            'class' => 'content'
        )),
        array('Label',  array(
            'tag' => 'span',
            'class' => 'Label',
            '//requiredSuffix' => ' <span class="//requiredFlag">*</span>',
            'escape' => false
        )),
        array('Row', array('tag' => 'div', 'class' => 'odd')),
    );

    //Decorator fuer die zweite Zeile (Dojo-Element)
    public $elementDecoratorsDojoEven = array(
        'DijitElement',
        array('Errors', array('class' => 'Errors')),
        array('Description', array(
            'tag' => 'span',
            'class' => 'small description',
            'escape'=> false
        )),
        //array('Info', array('tag' => 'span', 'class' => 'info')),
        array('HtmlTag', array(
            'tag' => 'span',
            'class' => 'content'
        )),
        array('Label',  array(
            'tag' => 'span',
            'class' => 'Label',
            '//requiredSuffix' => ' <span class="//requiredFlag">*</span>',
            'escape' => false
        )),
        array('Row', array('tag' => 'div', 'class' => 'even')),
    );

    /**
     * Custom error messsages
     *
     * @var    array
     * @access protected
     */
    protected $_errorMessages = array(
        \Zend\Validator\Alpha::STRING_EMPTY => 'Dieses Feld darf nicht leer sein',
        \Zend\Validator\StringLength::TOO_LONG => 'Zuviele Zeichen',
        \Zend\Validator\StringLength::TOO_SHORT => 'Zuwenig Zeichen'
    );

    /**
     * Class constructor
     *
     * @param array $options the form options
     *
     * @return void
     * @access public
     */
    public function __construct($options = array())
    {
        $this->_config = \Zend\Registry::get('_config');

        parent::__construct($options);

        $front     = \Zend\Controller\Front::getInstance();
        $basePath  = $front->getModuleDirectory('kredit-core');

        $this->addPrefixPath(
            'KreditCore_Class_Form_Decorator',
            $basePath .
            DS . 'classes' .
            DS . 'Form' .
            DS . 'Decorator' .
            DS,
            self::DECORATOR
        );
        $this->addPrefixPath(
            'Zend_Form_Decorator',
            LIB_PATH . DS . 'Zend' .
            DS . 'Form' .
            DS . 'Decorator' .
            DS,
            self::DECORATOR
        );
        $this->addPrefixPath(
            'KreditCore_Class_Form_Element',
            $basePath .
            DS . 'classes' .
            DS . 'Form' .
            DS . 'Element' .
            DS,
            self::ELEMENT
        );
        $this->addPrefixPath(
            'Zend_Form_Element',
            LIB_PATH . DS . 'Zend' .
            DS . 'Form' .
            DS . 'Element' .
            DS,
            self::ELEMENT
        );
        $this->addElementPrefixPath(
            'KreditCore_Class_Form_Decorator',
            $basePath .
            DS . 'classes' .
            DS . 'Form' .
            DS . 'Decorator' .
            DS,
            self::DECORATOR
        );
        $this->addElementPrefixPath(
            'Zend_Form_Decorator',
            LIB_PATH . DS . 'Zend' . DS . 'Form' . DS . 'Decorator' . DS,
            self::DECORATOR
        );
    }

    /**
     * Initialisierung der Form
     *
     * @return void
     * @access public
     */
    public function init()
    {
    }

    /**
     * Initialize Form Metadata
     *
     * @return KreditCore_Class_FormAbstract
     */
    protected function setupForm()
    {
        return $this;
    }

    /**
     * Initialize Form Elements
     *
     * must be overwritten
     *
     * @return void
     * @access protected
     */
    protected function setupElements()
    {
    }

    /**
     * Define which forms to display
     *
     * must be overwritten
     *
     * @param array $types an array of formtypes
     *
     * @return void
     * @access public
     */
    public function setFormTypes(array $types)
    {
        $this->_formTypes = $types;
    }

    /**
     * Set dafult element decorators
     *
     * @return void
     * @access public
     */
    public function loadDefaultDecorators()
    {
        //$this->setElementDecorators($this->_elementDecorators);
    }

    /**
     * returns TRUE, if the Calculator is not included in another site
     *
     * @return boolean
     * @access protected
     */
    protected function getInt()
    {
        if (\Zend\Registry::get('_urlType') == 'INT') {
            $int = true;
        } else {
            $int = false;
        }

        return $int;
    }
}
