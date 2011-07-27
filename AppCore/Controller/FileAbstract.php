<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

use Zend\Controller\Request\AbstractRequest,
    Zend\Controller\Response\AbstractResponse;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class FileAbstract extends ControllerAbstract
{
    /**
     * Code for the Partner
     *
     * @var string
     */
    protected $_partnerId = '';//partner-ID

    /**
     * Code for an Campaign of an Partner
     *
     * @var string
     */
    protected $_campaignId = '';//campaign-ID

    /**
     * ID der Sparte
     *
     * @var integer
     */
    protected $_sparte = 0;

    /**
     * ein File Cache fuer die Dateien
     *
     * @var Zend_Cache_Core
     */
    protected $_cache = null;

    /**
     * Name der Sparte
     *
     * @var string
     */
    protected $_categoriesName = '';

    protected $_content = '';

    protected $_time = 0;

    /**
     * Class constructor
     *
     * The request and response objects should be registered with the
     * controller, as should be any additional optional arguments; these will be
     * available via {@link getRequest()}, {@link getResponse()}, and
     * {@link getInvokeArgs()}, respectively.
     *
     * When overriding the constructor, please consider this usage as a best
     * practice and ensure that each is registered appropriately; the easiest
     * way to do so is to simply call parent::__construct($request, $response,
     * $invokeArgs).
     *
     * After the request, response, and invokeArgs are set, the
     * {@link $_helper helper broker} is initialized.
     *
     * Finally, {@link init()} is called as the final action of
     * instantiation, and may be safely overridden to perform initialization
     * tasks; as a general rule, override {@link init()} instead of the
     * constructor to customize an action controller's instantiation.
     *
     * @param \Zend\Controller\Request\AbstractRequest  $request    the Request
     * @param Zend_Controller_Response_Abstract $response   the Response
     * @param array                             $invokeArgs Any additional
     *                                                      invocation arguments
     *
     * @return void
     * @access public
     */
    
    public function __construct(AbstractRequest $request,
                                AbstractResponse $response,
                                array $invokeArgs = array())
    {
        $request->setParamSources(array('_GET'));
        parent::__construct($request, $response, $invokeArgs);
    }

    /**
     * (non-PHPdoc)
     *
     * @see    library/Zend/Controller/Zend_Controller_Action#preDispatch()
     * @return void
     * @access public
     */
    public function preDispatch()
    {
        parent::preDispatch();

        if (!$this->_request->isGet()) {
            $this->_helper->header->setErrorHeaders();

            return;
        }

        $this->_helper->viewRenderer->setNoRender();
        //$this->_helper->layout->disableLayout();

        //set headers
        if ($this->_response->canSendHeaders()) {
            $this->_response->setHeader('robots', 'noindex,nofollow', true);
            $this->_response->setHeader(
                'Cache-Control', 'public, max-age=3600', true
            );
        }

        $this->_paid   = (int) $this->_helper->getParam('paid', 0);
        $this->_caid   = (int) $this->_helper->getParam('caid', 0);
        $this->_sparte = (int) $this->_helper->getParam('sparte', KREDIT_SPARTE_KREDIT);

        $this->_partnerId = strtolower(
            $this->_helper->getParam('partner_id', '', 'Alpha')
        );
        $this->_campaignId = strtolower(
            $this->_helper->getParam('campaign_id', '', 'Alpha')
        );
        $this->_categoriesName = $this->_helper->getParam('categoriesName', '', 'Alpha');
        $this->_mode = strtolower($this->_helper->getParam('mode', 'html', 'Alpha'));

        $this->_cache = \Zend\Registry::get('_fileCache');
    }

    /**
     * indexAction-Methode wird aufgerufen wenn keine Action angegeben wurde
     *
     * @return void
     * @access public
     */
    public function indexAction()
    {
        $file = (string) $this->_helper->getParam(
            'file',
            '',
            '_\\AppCore\\Validator\\FileName'
        );

        if (!$file) {
            //set headers
            $this->_helper->header->setErrorHeaders();
        } else {
            $this->getCachedFile($file);

            $this->_response->setBody($this->_content);
        }
    }

    /**
     * indexAction-Methode wird aufgerufen wenn keine Action angegeben wurde
     *
     * @return void
     * @access public
     */
    public function campaignAction()
    {
        $file = (string) $this->_helper->getParam(
            'file',
            '',
            '_\\AppCore\\Validator\\FileName'
        );

        //$this->_logger->info($file);

        if (!$file) {
            /*
             * no file requested, or invalid file name
             * set headers
             */
            $this->_helper->header->setErrorHeaders();
            return;
        }

        $campaign = (string) $this->_helper->getParam('campaign', '');

        $this->loadPaid($campaign);

        //$this->_logger->info($this->_campaignId);

        if (!$this->_campaignId) {
            /*
             * invalid campaign set
             * set headers
             */
            $this->_helper->header->setErrorHeaders();
            return;
        }

        /*
         * create the path to the file
         */
        $file = HOME_PATH . DS . 'kampagne' . DS . $this->_campaignId . DS
              . $this->_controller . DS . $this->_mode . DS . $file
              . '.' . $this->_controller;

        //$this->_logger->info($file);

        $this->getCachedFile($file, null, $this->_campaignId);

        //var_dump($_SERVER, $this->_time, $this->_content);

        $this->_response->setBody($this->_content);
    }

    /**
     * loads a file, if possible from cache
     *
     * @param string $file the name of the file to be loaded
     *
     * @return void
     */
    protected function getCachedFile($file, $cacheId = null, $camapignId = null)
    {
        /*
         * get the date for the last modification of an css or js file
         */
        $this->_time = 0;

        if (is_array($file)) {
            foreach ($file as $singleFile) {
                $this->_time = $this->getFileDate($singleFile, $this->_time);
            }
        } else {
            $this->_time = $this->getFileDate($file, $this->_time);
        }

        /*
         * set the the last-modified- and the expires header
         */
        if ($this->_response->canSendHeaders()) {
            $time = (($this->_time == 0) ? time() : $this->_time);

            $this->_response->setHeader(
                'Last-Modified',
                gmdate('D, d M Y H:i:s', $time) . ' GMT',
                true
            );
            $this->_response->setHeader(
                'Expires',
                gmdate(
                    'D, d M Y H:i:s',
                    mktime(0, 0, 0, date('m'), date('d') + 10, date('Y'))
                )
                . ' GMT', true
            );
        }

        /*
         * check if the file was modified
         * -> do this, only if the if-modified-since-header is available
         */
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])
            && $this->_response->canSendHeaders()
        ) {
            $referenceDate = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);

            if ($referenceDate >= $this->_time) {
                /*
                 * the file was not modified
                 * -> set the header and clear the response body
                 */
                $responseCode = 304;

                $this->_response->setHttpResponseCode($responseCode);
                $this->_response->setRawHeader(
                    'HTTP/1.1 ' . $responseCode . ' ' .
                    $this->_statusCodes[$responseCode]
                );

                $this->_content = '';

                return;
            }
        }

        /*
         * the file is modified
         * -> load the file and parse the place holders
         */
        $this->_content = '';
        $noCss          = (int) $this->_getParam(
            'no',
            0,
            'Int'
        );

        if (null === $cacheId) {
            $mode    = preg_replace('/[^a-zA-Z0-9_]/', '', $this->_mode);
            $cacheId = $mode . 'file_'
                     . preg_replace('/[^a-zA-Z0-9_]/', '', $file)
                     . '_' . $mode;

            if ($noCss) {
                $cacheId .= '_1';
            }
        }

        $this->_content = $this->isCacheLoaded($cacheId);
        if (!$this->_content) {
            $useFileAsPaid = ($camapignId === null ? true : false);

            if (is_array($file)) {
                foreach ($file as $singleFile) {
                    $this->getFile(
                        $singleFile, true, false, false, $this->_mode, $noCss,
                        $useFileAsPaid
                    );
                }
            } else {
                $this->getFile(
                    $file, true, false, false, $this->_mode, $noCss,
                    $useFileAsPaid
                );
            }

            if (is_object($this->_cache)) {
                $this->_cache->save($this->_content, $cacheId);
            }
        }
    }

    /**
     * tries to load the cache
     *
     * @param string $cacheId
     *
     * @return string|boolean
     */
    protected function isCacheLoaded($cacheId)
    {
        if (!is_object($this->_cache)) {
            return false;
        }

        return $this->_cache->load($cacheId);
    }

    /**
     * returns the time of the last change for an existing file or NULL if the
     * file doesn't exist
     *
     * @param string  $file the file path
     * @param integer $time a timestamp
     *
     * @return integer|null
     */
    protected function getFileDate($file, $time)
    {
        if (file_exists($file)) {
            $iTime = filemtime($file);

            if ($time < $iTime) {
                $time = $iTime;
            }
        }

        return $time;
    }
}