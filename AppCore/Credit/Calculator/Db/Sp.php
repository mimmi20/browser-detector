<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Credit\Calculator\Db;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Sp.php 24 2011-02-01 20:55:24Z tmu $
 */
 
use AppCore\Credit\Calculator;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @deprecated
 */
class Sp extends Calculator\Db
{
    /**
     * calculates the credit results using a stored procedure
     *
     * @return array|boolean the result array or FALSE if an error occured
     * @access public
     */
    public function calculate()
    {
        $sparte = $this->getSparte();

        if (!is_numeric($sparte)) {
            $sparteModel = new \AppCore\Service\Sparten();
            $sparte      = $sparteModel->getId($sparte);
        }

        try {
            /*
             * calc(
             *  IN kreditbetrag INT(11) UNSIGNED,
             *  IN laufzeitName INT(11) UNSIGNED,
             *  IN vzweckName INT(11) UNSIGNED,
             *  IN campaignId INT(11) UNSIGNED,
             *  IN partnerId INT(11) UNSIGNED,
             *  IN sparte INT(11) UNSIGNED,
             *  IN teaserOnly TINYINT(1),
             *  IN bestOnly TINYINT(1),
             *  IN productId INT(11) UNSIGNED,
             *  IN instituteName MEDIUMTEXT
             * )
             */
            $query = 'CALL calc('
                   . (int) $this->getKreditbetrag() . ','
                   . (int) $this->getLaufzeit() . ','
                   . (int) $this->getZweck() . ','
                   . (int) $this->getCaid() . ','
                   . (int) $this->getPaid() . ','
                   . (int) $sparte . ','
                   . (int) $this->getTeaserOnly() . ','
                   . (int) $this->_bestonly . ','
                   . "'" . $this->getOnlyProduct() . "',"
                   . "'" . $this->getOnlyInstitut() . "'"
                   . ');';

            $stmt  = $this->_db->query($query);
            $stmt->execute();
        } catch (Exception $e) {
            if (APPLICATION_ENV == SERVER_ONLINE_LIVE
                || APPLICATION_ENV == SERVER_ONLINE_STAGING
            ) {
                /*
                 * nur auf Live-Servern auslösen, da SP auf Testserver nicht
                 * vorhanden ist
                 */
                $this->_logger->err($e);
            }

            return false;
        }

        return $this->getRows();
    }
}