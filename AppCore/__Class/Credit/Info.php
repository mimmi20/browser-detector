<?php
/**
 * Klasse für Kredit-Infos
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Info.php 4240 2010-12-14 15:21:44Z t.mueller $
 */

/**
 * Klasse für Kredit-Infos
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditCore_Class_Credit_Info extends \AppCore\Credit\CreditAbstract
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

    private $_cache = null;

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

        $institut = null;

        $modelProdukte = new \AppCore\Model\Produkte();
        if (!$this->_product
            || !$modelProdukte->lade($this->_product, $institut, $this->_sparte)
        ) {
            //product not given or product is not available or inactive
            return '';
        }

        $product = $modelProdukte->find($this->_product)->current();

        $usages  = explode(',', $product->kp_usages);
        if (!in_array($this->_zweck, $usages)) {
            //product is not available for the selected useage
            return '';
        }

        if (null === $fromDb) {
            $fromDb = ('' != $product->kp_info);
        }

        if (\Zend\Registry::isRegistered('_fileCache')) {
            $this->_cache = \Zend\Registry::get('_fileCache');
        }
        $cacheId      = 'productinfo_' . $this->_product;
        $productinfo  = '';

        if (!is_object($this->_cache)
            || !$productinfo = $this->_cache->load($cacheId)
        ) {
            $max  = $product->kp_rahmen_max;
            $min  = $product->kp_rahmen_min;
            $zins = $modelProdukte->getZins(
                $this->_product,
                $this->_laufzeit,
                $this->_betrag
            );

            if ($fromDb) {
                //get Info from database
                $productinfo = $product->kp_info;
            } else {
                //get Info from a template
                if (!$institut) {
                    /*
                     * no institute found
                     * -> rendering not possible
                     */
                    $productinfo = '';
                } else {
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
            }

            try {
                /*
                 * cover the info with cdata marks and add a new root
                 * element to create a valid xml structure
                 */
                $xmlInfo = '<productinfo id="' . $institut . '">
                        <![CDATA[ ' . $productinfo . ' ]]>
                    </productinfo>';

                $xml = new SimpleXMLElement($xmlInfo);
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

            if (is_object($this->_cache) && $productinfo != '') {
                $this->_cache->save($productinfo, $cacheId);
            }
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