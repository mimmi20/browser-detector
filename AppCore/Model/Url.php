<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Model;

/**
 * Model
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Url.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Url extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'urls';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'tku_id';

    /**
     * returns the actual Zins
     *
     * @param integer $productId the product ID
     * @param integer $caid      the campaign ID
     *
     * @return \Zend\Db\Table\Row|null
     */
    public function getFromProduct($productId, $caid)
    {
        if (!is_numeric($productId) || !is_numeric($caid)) {
            return null;
        }

        if (0 >= (int) $productId || 0 >= (int) $caid) {
            return null;
        }

        $select = $this->select();
        $select->where('kp_id = ?', (int) $productId);
        $select->where('id_campaign = ?', (int) $caid);
        $select->where(new \Zend\Db\Expr('active = 1'));
        $select->limit(1);

        $result = $this->fetchAll($select)->current();

        return $result;
    }

    /**
     * returns the actual Zins
     *
     * @param integer $productId the product ID
     *
     * @return string|null
     */
    public function getUrl($productId, $caid, $teaser = false)
    {
        if (!is_numeric($productId) || !is_numeric($caid)) {
            return null;
        }

        if (0 >= (int) $productId || 0 >= (int) $caid) {
            return null;
        }

        $result = $this->getFromProduct($productId, $caid);
        if ('\Zend\Db\Table\Row' != get_class($result)) {
            return null;
        }

        if ($teaser && $result->tku_url_teaser) {
            return $result->tku_url_teaser;
        }

        return $result->tku_url;
    }
}