<?php
namespace AppCore\Model;
declare(ENCODING = 'iso-8859-1');

/**
 * Model
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class ExceptionModel extends ModelAbstract
{
    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'ExceptionId';

    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'exceptions';

    /**
     * Inserts an Exception into Database
     *
     * @param Exception                        $exception the Exception Object
     * @param \Zend\Controller\Request\AbstractRequest $request   the Request Object
     * @param string                           $level     the error level
     *
     * @return mixed the Primary Key of the Row inserted
     * @access public
     */
    public function insertException(
        \Exception $exception,
        \Zend\Controller\Request\AbstractRequest $request,
        $level = 'Exception')
    {
        if (!is_object($exception)) {
            return null;
        }

        if (get_class($exception) != '\\Exception'
            && !is_subclass_of($exception, '\\Exception')
        ) {
            return null;
        }

        $message = $exception->getMessage();
        $trace   = $exception->getTraceAsString();

        $requestParams = array_merge(
            $request->getParams(),
            array(
                'uri' => ((isset($_SERVER['REQUEST_URI']))
                      ? $_SERVER['REQUEST_URI']
                      : '')
            )
        );

        $data = array(
            'Message'       => $message,
            'Trace'         => $trace,
            'Request'       => serialize($requestParams),
            'Enviroment'    => APPLICATION_ENV,
            'ApplicationId' => new \Zend\Db\Expr('NULL'),//@deprecated
            'SessionId'     => new \Zend\Db\Expr('NULL'),//@deprecated
            'level'         => $level
        );

        try {
            $id = $this->insert($data);
        } catch (Exception $e) {
            error_log($message);
            error_log($e->getMessage());

            $id = null;
        }

        return $id;
    }
}