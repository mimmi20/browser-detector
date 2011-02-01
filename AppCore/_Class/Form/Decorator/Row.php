<?php
/**
 * Zeilen Decorator
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Form
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * KreditCore_Class_Form_Decorator_Row
 *
 * Accepts the options:
 * - separator: separator to use between label and content (defaults to PHP_EOL)
 * - placement: whether to append or prepend label to content
 *              (defaults to prepend)
 * - tag: if set, used to wrap the label in an additional HTML tag
 * - opt(ional)Prefix: a prefix to the label to use when the element is optional
 * - opt(iona)lSuffix: a suffix to the label to use when the element is optional
 * - req(uired)Prefix: a prefix to the label to use when the element is required
 * - req(uired)Suffix: a suffix to the label to use when the element is required
 *
 * Any other options passed will be used as HTML attributes of the label tag.
 *
 * @category  Kreditrechner
 * @package   Form
 * @copyright 2007-2010 Unister GmbH
 * @version   $Id$
 */
class KreditCore_Class_Form_Decorator_Row extends Zend_Form_Decorator_Abstract
{
    /**
     * Default placement: prepend
     * @var string
     */
    protected $_placement = 'PREPEND';

    /**
     * HTML tag with which to surround row
     * @var string
     */
    protected $_tag;

    /**
     * Set element ID
     *
     * @param  string $id
     * @return KreditCore_Class_Form_Decorator_Row
     */
    public function setId($id)
    {
        $this->setOption('id', $id);
        return $this;
    }

    /**
     * Retrieve element ID (used in 'for' attribute)
     *
     * If none set in decorator, looks first for element 'id' attribute, and
     * defaults to element name.
     *
     * @return string
     */
    public function getId()
    {
        $id = $this->getOption('id');
        if (null === $id) {
            if (null !== ($element = $this->getElement())) {
                $id = $element->getId();
                $this->setId($id);
            }
        }

        return $id;
    }

    /**
     * Set HTML tag with which to surround row
     *
     * @param  string $tag
     * @return KreditCore_Class_Form_Decorator_Row
     */
    public function setTag($tag)
    {
        if (empty($tag)) {
            $this->_tag = null;
        } else {
            $this->_tag = (string) $tag;
        }
        return $this;
    }

    /**
     * Get HTML tag, if any, with which to surround row
     *
     * @return void
     */
    public function getTag()
    {
        if (null === $this->_tag) {
            $tag = $this->getOption('tag');
            if (null !== $tag) {
                $this->removeOption('tag');
                $this->setTag($tag);
            }
            return $tag;
        }

        return $this->_tag;
    }

    /**
     * Get class with which to define row
     *
     * Appends either 'optional' or 'required' to class, depending on whether
     * or not the element is required.
     *
     * @return string
     */
    public function getClass()
    {
        $class   = '';
        $element = $this->getElement();

        $decoratorClass = $this->getOption('class');
        if (!empty($decoratorClass)) {
            $class .= ' ' . $decoratorClass;
        }

        $type  = $element->isRequired() ? 'required' : 'optional';

        if (!strstr($class, $type)) {
            $class .= ' ' . $type;
            $class = trim($class);
        }

        return $class;
    }

    /**
     * Load an optional/required suffix/prefix key
     *
     * @param  string $key
     * @return void
     */
    protected function loadOptReqKey($key)
    {
        if (!isset($this->$key)) {
            $value = $this->getOption($key);
            $this->$key = (string) $value;
            if (null !== $value) {
                $this->removeOption($key);
            }
        }
    }

    /**
     * Overloading
     *
     * Currently overloads:
     *
     * - getOpt(ional)Prefix()
     * - getOpt(ional)Suffix()
     * - getReq(uired)Prefix()
     * - getReq(uired)Suffix()
     * - setOpt(ional)Prefix()
     * - setOpt(ional)Suffix()
     * - setReq(uired)Prefix()
     * - setReq(uired)Suffix()
     *
     * @param  string $method
     * @param  array $args
     * @return mixed
     * @throws Zend_Form_Exception for unsupported methods
     */
    public function __call($method, $args)
    {
        try {
            throw new Zend_Form_Exception(
                'undefined function ' . __CLASS__ . '::' . $method . ' called'
            );
        } catch (Exception $e) {
            $logger = \Zend\Registry::get('log');
            $logger->err($e);
        }

        $tail = substr($method, -6);
        $head = substr($method, 0, 3);
        if (in_array($head, array('get', 'set'))
            && (('Prefix' == $tail) || ('Suffix' == $tail))
        ) {
            $position = substr($method, -6);
            $type     = strtolower(substr($method, 3, 3));
            switch ($type) {
                case 'req':
                    $key = 'required' . $position;
                    break;
                case 'opt':
                    $key = 'optional' . $position;
                    break;
                default:
                    throw new Zend_Form_Exception(
                        sprintf(
                            'Invalid method "%s" called in Label decorator, ' .
                            'and detected as type %s',
                            $method,
                            $type
                        )
                    );
                    break;
            }

            switch ($head) {
                case 'set':
                    if (0 === count($args)) {
                        throw new Zend_Form_Exception(
                            sprintf(
                                'Method "%s" requires at least one argument; ' .
                                'none provided',
                                $method
                            )
                        );
                    }
                    $value = array_shift($args);
                    $this->$key = $value;
                    return $this;
                    break;
                case 'get':
                    // Break intentionally omitted
                default:
                    if (null === ($element = $this->getElement())) {
                        $this->loadOptReqKey($key);
                    } elseif (isset($element->$key)) {
                        $this->$key = (string) $element->$key;
                    } else {
                        $this->loadOptReqKey($key);
                    }
                    return $this->$key;
                    break;
            }
        }

        throw new Zend_Form_Exception(
            sprintf('Invalid method "%s" called in Row decorator', $method)
        );
    }

    /**
     * Render a row
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $tag       = $this->getTag();

        if (empty($tag) || null === $tag) {
            return $content;
        }

        //$separator = $this->getSeparator();
        //$id        = $this->getId();
        //$options   = $this->getOptions();
        $class     = $this->getClass();

        $decorator = new Zend_Form_Decorator_HtmlTag();
        $decorator->setOptions(
            array(
                'tag'   => $tag,
                'id'    => $this->getElement()->getName() . '-row',
                'class' => $class
            )
        );

        $content = $decorator->render($content);

        return $content;
    }
}
