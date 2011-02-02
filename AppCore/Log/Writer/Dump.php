<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Log\Writer;

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Log
 * @subpackage Writer
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * @category   Zend
 * @package    Zend_Log
 * @subpackage Writer
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Dump extends \Zend\Log\Writer\AbstractWriter
{
    /**
     * Create a new instance of \AppCore\Log\Writer\Dump
     *
     * @param  array|\Zend\Config\Config $config
     * @return \AppCore\Log\Writer\Dump
     * @throws \Zend\Log\Exception
     */
    static public function factory($config = array())
    {
        return new self();
    }

    /**
     * Formatting is not possible on this writer
     */
    public function setFormatter(\Zend\Log\Formatter $formatter)
    {
        throw new \Zend\Log\Exception(
            get_class($this) . ' does not support formatting'
        );
    }

    /**
     * Write a message to the log.
     *
     * @param  array  $event  event data
     * @return void
     */
    protected function _write($event)
    {
        $priority = (isset($event['priorityName'])
                  ? $event['priorityName'] : 'unknown');

        if (isset($event['message'])) {
            $message = $event['message'];

            if (is_object($message) && ($message instanceof \Exception)) {
                $sMessage  = $this->_addLine($message->getMessage(), $event);
                $fullTrace = $message->getTrace();
                $traceKeys = array_keys($fullTrace);

                foreach ($traceKeys as $key) {
                    $trace     = $fullTrace[$key];
                    $sMessage .= '#' . $key . ' '
                               . (isset($trace['file'])
                                ? $trace['file'] . ' --> ' . $trace['line']
                                : '')
                               . ': '
                               . (isset($trace['class']) ? $trace['class'] : '')
                               . (isset($trace['type']) ? $trace['type'] : '')
                               . $trace['function'] . '()'
                               . "\n";
                }

                $priority = 'EXCEPTION';
                $message  = $sMessage;
            } else {
                $message = $this->_addLine($message, $event);
            }
        } else {
            $message  = 'no other message';
        }

        $priority .= ' (' . APPLICATION_ENV . ')';
        $message   = 'PHP Version: ' . phpversion() . "\n"
                   . 'XDebug: ' . phpversion('xdebug') . "\n"
                   . $message;

        \Zend\Debug::dump($message, $priority, true);
    }

    /**
     * adds the file and the line of an error to the output message
     *
     * @param string $message
     * @param array  $event
     *
     * @return string
     */
    private function _addLine($message, $event)
    {
        if (isset($event['file'])) {
            $message .= ' [File: ' . $event['file'];

            if (isset($event['line'])) {
                $message .= ' on Line ' . $event['line'];
            }

            $message .= ']';
        }

        return $message . "\n\n";
    }
}
