<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Credit;

/**
 * Klasse für Kredit-Infos
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Klasse für Kredit-Infos
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Info extends CreditAbstract
{
    /**
     * @var    \Zend\View\View object
     * @access private
     */
    private $_view = null;

    /**
     * @var    integer
     * @access private
     */
    private $_product = 0;

    /**
     * get the information about an institute and its credits
     *
     * @param boolean $load   if TRUE,  the info is loaded here
     *                        if FALSE, the info is loaded via ajax
     *                                  later
     * @param boolean $fromDb if TRUE,  the info is loaded from database
     *                        if FALSE, the info is loaded from a
     *                                  template file
     *                        IF NULL,  it will be checked, if the info
     *                                  is in the database
     *
     * @return array
     * @access public
     */
    public function info($load = false, $fromDb = false)
    {
        if (!$load) {
            /*
             * do not load the info here
             * the info is loaded via ajax later
             */
            return '##ajax##';
        }

        if (null !== $fromDb && !$fromDb && !is_object($this->_view)) {
            /*
             * no view available
             * -> no rendering possible
             */
            return '';
        }

        $front = \Zend\Controller\Front::getInstance();
        $cache = $front->getParam('bootstrap')->getResource('cachemanager')->getCache('file');
        
        $cacheId  = 'productinfo_' . $this->_product;

        if (!$productinfo = $cache->load($cacheId)) {
            $modelProducts = new \AppCore\Service\Products();
            $productinfo   = $modelProducts->getInformation($this->_product);

            $product = $modelProducts->find($this->_product)->current();
            
            $modelInstitutes = new \AppCore\Service\Institutes();
            $institut        = $modelInstitutes->getName($product->idInstitutes);
            
            $max  = $product->max;
            $min  = $product->min;
            $zins = $modelProducts->getZins(
                $this->_product,
                $this->_laufzeit,
                $this->_betrag
            );

            //get Info from a template
            if (!$productinfo) {
                $this->_view->min      = $min;
                $this->_view->max      = $max;
                $this->_view->zins     = $zins;
                $this->_view->institut = $institut;
                $this->_view->mode     = $this->_mode;
                $this->_view->product  = $this->_product;
                $this->_view->sparte   = strtolower($this->_sparte);

                //include and aprse the template
                $productinfo = str_replace(
                    array("\r\n", "\r", "\n", "\t"),
                    '',
                    $this->_view->getInstituteFile(
                        strtolower($this->_sparte),
                        $institut,
                        $this->_mode,
                        $this->_product,
                        true
                    )
                );
            }

            try {
                /*
                 * cover the info with cdata marks and add a new root
                 * element to create a valid xml structure
                 */
                $xmlInfo = '<productinfo id="' . $this->_product . '">
                        <![CDATA[ ' . $productinfo . ' ]]>
                    </productinfo>';

                $xml = new \SimpleXMLElement($xmlInfo);
            } catch (Exception $e) {
                /*
                 * produkt info contains characters, who can not
                 * converted to utf-8
                 */
                $productinfo = '';
                $xml         = null;
                $message     = 'Info: ' . $xmlInfo . "\n\n" . $e->getMessage();

                $triggerException = new \Zend\Exception(
                    $message, $e->getCode, $e
                );

                $this->_logger->err($triggerException);
            }

            //replace the placeholders
            $productinfo = str_replace(
                array('###min###', '###max###', '###zins###'),
                array(
                    number_format($min, 2, ',', '.'),
                    number_format($max, 2, ',', '.'),
                    number_format($zins, 2, ',', '.')
                ),
                $productinfo
            );

            $cache->save($productinfo, $cacheId);
        }

        return $productinfo;
    }

    /**
     * @param \Zend\View\View $view an view object
     *
     * @return void
     * @access public
     */
    public function setView(\Zend\View\View $view)
    {
        $this->_view = clone $view;

        return $this;
    }

    /**
     * @param \Zend\View\View $view an view object
     *
     * @return void
     * @access public
     */
    public function setProduct($product)
    {
        $this->_product = (int) $product;

        return $this;
    }
}