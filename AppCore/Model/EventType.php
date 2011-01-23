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
 * @version   SVN: $Id: EventType.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class EventType extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'eventtype';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'EventTypeId';
}