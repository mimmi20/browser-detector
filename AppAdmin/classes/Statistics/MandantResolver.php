<?php
/**
 * Klaase mit Backend-Funktionen für die Partner-Behandlung in der Statistik
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: MandantResolver.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Klaase mit Backend-Funktionen für die Partner-Behandlung in der Statistik
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_MandantResolver
{

    /**
     * Whitelist of Mandant Rows
     * @var Array of \Zend\Db\Table\Row
     */
    private $_featMandants;

    /**
     * @var \\AppCore\\Model\Partner
     */
    private $_dbPartner;

    /**
     * Constructor
     *
     * @return KreditAdmin_Class_Statistics_MandantResolver
     */
    public function __construct()
    {
        $this->_featMandants = array(0 => true);
        $this->_dbPartner    = new \AppCore\Model\Portale();

        $this->addAllMandants();
    }

    /**
     * Disable use of Default Mandant
     *
     * @return KreditAdmin_Class_Statistics_MandantResolver
     */
    public function dispableDefaultMandant()
    {
        unset($this->_featMandants[0]);

        return $this;
    }

    /**
     * Add all known Mandants to Whitelist
     *
     * @return boolean
     */
    public function addAllMandants()
    {
        $this->_featMandants = array(0 => true);
        $parents = $this->_dbPartner->fetchList();

        if (false !== $parents) {
            foreach ($parents as $parent) {
                $this->_featMandants[$parent->p_name] = $parent->toArray();
                $childs = $this->_dbPartner->getChildList($parent);

                foreach ($childs as $child) {
                    $cName = $child->p_name;
                    $this->_featMandants[$cName] = $child->toArray();
                    $this->_featMandants[$cName]['parent'] = $parent->p_name;
                }
            }

            return true;
        }

        return false;
    }

    /**
     * returns the name of an portal for a given campaign
     *
     * @param string $referenceId the mandant
     *
     * @return string
     */
    public function getParentName($referenceId)
    {
        $mandant = $this->_getMandant($referenceId);

        if (is_array($mandant) && isset($mandant['parent'])) {
            return $mandant['parent'];
        }

        return '';
    }

    /**
     * returns the data of an portal for a given campaign
     *
     * @param string $referenceId the mandant
     *
     * @return array
     */
    public function getParent($referenceId)
    {
        $parent = $this->getParentName($referenceId);

        if ($parent
            && isset($this->_featMandants[$parent])
            && is_array($this->_featMandants[$parent])
        ) {
            return $this->_featMandants[$parent];
        }

        return array();
    }

    /**
     * get the name of a mandant
     *
     * @param string $referenceId the mandant
     *
     * @return string
     */
    public function getMandantName($referenceId)
    {
        $mandant = $this->_getMandant($referenceId);

        if (is_array($mandant) && isset($mandant['name'])) {
            return $mandant['name'];
        }
        return '';
    }

    /**
     * get the color of a mandant (for statistics)
     *
     * @param string $referenceId the mandant
     *
     * @return string
     */
    public function getMandantColor($referenceId)
    {
        $mandant = $this->_getMandant($referenceId);

        if (is_array($mandant) && isset($mandant['color'])) {
            return $mandant['color'];
        }

        return 'ddd';
    }

    /**
     * get Whitelist as Array of Mandant Id's
     *
     * @param string $campaigns a comma separated list of campaign ids
     *
     * @return array
     */
    public function getReferenceList($campaigns = '')
    {
        $mandants = $this->_featMandants;

        if (is_string($campaigns)) {
            $campaigns = explode(',', (string) $campaigns);
        } elseif (is_object($campaigns)) {
            $campaigns = (array) $campaigns;
        } else {
            $campaigns = array();
        }

        $references = array();
        unset($mandants[0]);

        foreach ($mandants as $mandant) {
            if (isset($mandant['id_campaign'])
                && in_array($mandant['id_campaign'], $campaigns)
            ) {
                $references[] = $mandant['p_name'];
            }
        }

        return $references;
    }

    /**
     * Get Whitelist as Array of Mandant Id's
     *
     * @return array
     */
    public function getIdList()
    {
        $result = array();

        foreach ($this->_featMandants as $row) {
            $result[] = ((isset($row['partner_id']))
                      ? (int)$row['partner_id']
                      : null);
        }

        return array_unique($result);
    }

    /**
     * Get List of all Mandants that are Parents
     *
     * @return array
     */
    public function getPortalList()
    {
        return $this->_dbPartner->fetchList();
    }

    /**
     * get List of Campaigns for a Portal
     *
     * @param integer|string|array $portalId  the id of the portal
     * @param boolean              $withTests if TRUE, also the Test-Campaigns
     *                                        will be returned
     *
     * @return array
     */
    public function getKampagnenList($portalId, $withTests = true)
    {
        if (is_array($portalId)
            || (is_string($portalId) && strpos($portalId, ',') !== false)
        ) {
            return $this->_dbPartner->getChildListPartly($portalId, $withTests);
        } elseif (is_numeric($portalId) && (int) $portalId > 0) {
            $parentList = $this->_dbPartner->find($portalId);
            $parent     = $parentList->current();

            return $this->_dbPartner->getChildList($parent, $withTests);
        } else {
            return $this->_dbPartner->getChildListComplete($withTests);
        }
    }

    /**
     * clears the list of mandants and the session
     *
     * @return KreditAdmin_Class_Statistics_MandantResolver
     */
    public function clear()
    {
        $this->_featMandants = array(0 => true);

        return $this;
    }

    /**
     * get List of all Mandants that are Parents
     *
     * @return array
     */
    public function getPortale()
    {
        $parentRows = $this->getPortalList();

        $parentArray = array();
        foreach ($parentRows as $row) {
            $parentArray[$row->p_name] = $row;
        }

        return $parentArray;
    }

    /**
     * get List of all Mandants that are Parents
     *
     * @return array
     */
    public function getPortaleFull()
    {
        $parentArray = array();
        $parentRows  = $this->getPortalList();

        if (false !== $parentRows) {
            foreach ($parentRows as $row) {
                $pName = $row->p_name;

                $parentArray[$pName] = $row->toArray();

                $parentArray[$pName]['children'] =
                    $this->getKampagnenList($row->p_id)->toArray();

                $childIds     = array();
                $childClasses = array();

                foreach ($parentArray[$pName]['children'] as $id => $child) {
                    if (!is_array($child)) {
                        continue;
                    }

                    $cId = $child['id_campaign'];

                    $parentArray[$pName]['children'][$id]['p_id'] = $cId;

                    $childIds[]     = '.filtersC' . $cId;
                    $childClasses[] = '#filtersC-' . $cId;
                }
                $parentArray[$pName]['childrenIds'] = implode(', ', $childIds);
                $parentArray[$pName]['childrenCbx'] = implode(
                    ', ', $childClasses
                );
            }
        }

        return $parentArray;
    }

    /**
     * @param string|integer $referenceId
     *
     * @return array|null
     */
    private function _getMandant($referenceId)
    {
        if (!is_numeric($referenceId) && !is_string($referenceId)) {
            return null;
        }

        if (is_numeric($referenceId)) {
            $referenceId = $this->_dbPartner->getName($referenceId);
        }

        if (null === $referenceId || '' == $referenceId) {
            return null;
        }

        if (isset($this->_featMandants[$referenceId])
            && is_array($this->_featMandants[$referenceId])
        ) {
            return $this->_featMandants[$referenceId];
        }

        return null;
    }
}