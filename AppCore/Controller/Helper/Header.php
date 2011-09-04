<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller\Helper;

/**
 * Service-Finder für alle Kredit-Services
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Service-Finder für alle Kredit-Services
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Header extends \Zend\Controller\Action\Helper\AbstractHelper
{
    private $_statusCodes = array(
        /* 10X */
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        /* 20X */
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        /* 30X */
        300 => 'Multiple Choice',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        /* 40X */
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a Teapot',
        419 => '',
        420 => '',
        421 => 'There are too many connections from your internet address',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        /* 50X */
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => '',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended'
    );

    /**
     * disables the output and sets header
     *
     * this function is called if the request is not allowed or there is no
     * result
     *
     * @param integer $responseCode HTTP Code
     *
     * @return void
     */
    public function setErrorHeaders($responseCode = 404, $message = '')
    {
        $this->getActionController()->getHelper('ViewRenderer')->setNoRender();
        $this->getActionController()->getHelper('Layout')->disableLayout();

        if (!is_int($responseCode)
            || !array_key_exists($responseCode, $this->_statusCodes)
        ) {
            $responseCode = 404;
        }

        if ($this->getResponse()->canSendHeaders()) {
            $this->getResponse()->setHttpResponseCode($responseCode);
            $this->getResponse()->setRawHeader(
                $this->getRequest()->getServer('SERVER_PROTOCOL') .
                ' ' . $responseCode . ' ' .
                $this->_statusCodes[$responseCode]
            );
            $this->getResponse()->setHeader('X-Robots-Tag', 'noindex,nofollow,nostore', true);
            $this->getResponse()->setHeader('Cache-Control', 'no-cache', true);
            $this->getResponse()->setHeader('Pragma', 'no-cache', true);
            $this->getResponse()->setHeader(
                'Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT', true
            );
            $this->getResponse()->setHeader(
                'Expires', gmdate('D, d M Y H:i:s') . ' GMT', true
            );
        }

        $this->getResponse()->setBody($message);
        $this->getRequest()->setDispatched(true);
    }

    /**
     * sets default headers like content language, expires
     *
     * @return void
     */
    public function setDefaultHeaders()
    {
        if ($this->getResponse()->canSendHeaders()) {
            $this->getResponse()->setHeader('Content-Language', 'de_DE', true);
            $this->getResponse()->setHeader(
                'Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT', true
            );
            $this->getResponse()->setHeader(
                'Expires',
                gmdate(
                    'D, d M Y H:i:s',
                    mktime(0, 0, 0, date('m'), date('d'), date('Y') + 10)
                )
                . ' GMT', true
            );
            $this->getResponse()->setHeader('Pragma', 'no-cache', true);
            $this->getResponse()->setHeader('X-Robots-Tag', 'index,follow', true);
            $this->getResponse()->setHeader(
                'Cache-Control',
                'public, max-age=3600',
                true
            );
        }
    }

    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link getService} verwendet
     *
     * @param string $service The name of the Service
     * @param string $module  The name of the module
     *
     * @return \\AppCore\\Service\Abstract The servics class
     */
    public function direct()
    {
        return $this;
    }
}