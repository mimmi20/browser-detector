<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Service;

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Service
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   Services
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Service
 *
 * @category  CreditCalc
 * @package   Services
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class ServiceAbstract
{
    /**
     * @var \AppCore\Model\ModelAbstract
     */
    protected $_model = null;

    /**
     * @var \AppCore\Model\Cache_Abstract
     */
    protected $_cache = null;

    /**
     * is called, if a function is not defined
     *
     * @param string $method the name of the called function
     * @param array  $params the parameters for called function
     *
     * @return mixed
     */
    public function __call($method, $params)
    {
        //these functions are not cached
        if (!is_callable(array($this->_model, $method))) {
            throw new \BadFunctionCallException(
                'unknows function \'' . $method . '\' called'
            );
        }

        return call_user_func_array(array($this->_model, $method), $params);
    }

    /**
     * cleans the model cache
     *
     * need to be overwritten in the child classes
     *
     * @return void
     */
    abstract public function cleanCache();

    /**
     * cleans the model cachefrom entries which are tagged by $tag
     *
     * @param string $tag the name of the tag to be cleaned
     *
     * @return ServiceAbstract
     */
    protected function cleanTaggedCache($tag = '')
    {
        $this->_model
            ->getCached()
            ->getCache()
            ->clean(\Zend\Cache\Frontend\Core::CLEANING_MODE_MATCHING_ANY_TAG, array($tag));

        return $this;
    }
    
    public function getModel()
    {
        return $this->_model;
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */