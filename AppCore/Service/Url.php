<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Service;

/**
 * Service
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Url.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Service
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Url extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \Credit\Core\Service\Url
     */
    public function __construct()
    {
        $this->_model = new \Credit\Core\Model\Url();
    }

    /**
     * returns the actual Zins
     *
     * @param integer $productId the product ID
     *
     * @return boolean
     * @access public
     */
    public function getFromProduct($productId, $caid)
    {
        return $this->_model->getCached('url')->getFromProduct(
            $productId, $caid
        );
    }

    /**
     * returns the actual Zins
     *
     * @param integer $productId the product ID
     *
     * @return boolean
     * @access public
     */
    public function getUrl($productId, $caid, $teaser = false)
    {
        return $this->_model->getCached('url')->getUrl(
            $productId, $caid, $teaser
        );
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \Credit\Core\Service\Url
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('url');
    }
}