<?php
/**
 * Info Decorator
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Form
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Info.php 4063 2010-11-14 21:17:55Z t.mueller $
 */

/**
 * KreditCore_Class_Form_Decorator_Info
 *
 * Accepts the options:
 * - separator: separator to use between label and content (defaults to PHP_EOL)
 * - placement: whether to append or prepend label to content
 *              (defaults to prepend)
 * - tag: if set, used to wrap the label in an additional HTML tag
 * - class: if set, override default class used with HTML tag
 * - escape: whether or not to escape description (true by default)
 *
 * Any other options passed will be used as HTML attributes of the HTML tag
 * used.
 *
 * @category  Kreditrechner
 * @package   Form
 * @copyright 2007-2010 Unister GmbH
 * @version   $Id: Info.php 4063 2010-11-14 21:17:55Z t.mueller $
 */
class KreditCore_Class_Form_Decorator_Info extends Zend_Form_Decorator_Abstract
{
    /**
     * Whether or not to escape the description
     * @var bool
     */
    protected $_escape;

    /**
     * Default placement: append
     * @var string
     */
    protected $_placement = 'APPEND';

    /**
     * HTML tag with which to surround description
     * @var string
     */
    protected $_tag;

    /**
     * Set HTML tag with which to surround description
     *
     * @param  string $tag
     * @return KreditCore_Class_Form_Decorator_Info
     */
    public function setTag($tag)
    {
        $this->_tag = (string) $tag;
        return $this;
    }

    /**
     * Get HTML tag, if any, with which to surround description
     *
     * @return string
     */
    public function getTag()
    {
        if (null === $this->_tag) {
            $tag = $this->getOption('tag');
            if (null !== $tag) {
                $this->removeOption('tag');
            } else {
                $tag = 'p';
            }

            $this->setTag($tag);
            return $tag;
        }

        return $this->_tag;
    }

    /**
     * Get class with which to define description
     *
     * Defaults to 'hint'
     *
     * @return string
     */
    public function getClass()
    {
        $class = $this->getOption('class');
        if (null === $class) {
            $class = 'hint';
            $this->setOption('class', $class);
        }

        return $class;
    }

    /**
     * Set whether or not to escape description
     *
     * @param  bool $flag
     * @return KreditCore_Class_Form_Decorator_Info
     */
    public function setEscape($flag)
    {
        $this->_escape = (bool) $flag;
        return $this;
    }

    /**
     * Get escape flag
     *
     * @return true
     */
    public function getEscape()
    {
        if (null === $this->_escape) {
            if (null !== ($escape = $this->getOption('escape'))) {
                $this->setEscape($escape);
                $this->removeOption('escape');
            } else {
                $this->setEscape(true);
            }
        }

        return $this->_escape;
    }

    /**
     * Render a description
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

        $description = $element->getDescription();
        $description = trim($description);

        if (!empty($description)
            && (null !== ($translator = $element->getTranslator()))
        ) {
            $description = $translator->translate($description);
        }

        if (empty($description)) {
            return $content;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $tag       = $this->getTag();
        //$class     = $this->getClass();
        $escape    = $this->getEscape();

        $options   = $this->getOptions();

        if ($escape) {
            $description = $view->escape($description);
        }

        if (!empty($tag)) {
            $options['tag'] = $tag;
            $decorator = new Zend_Form_Decorator_HtmlTag($options);
            $description = $decorator->render($description);
        }

        switch ($placement) {
            case self::PREPEND:
                $content = $description . $separator . $content;
                break;
            case self::APPEND:
            default:
                $content .= $separator . $description;
                break;
        }

        return $content;
    }
}
