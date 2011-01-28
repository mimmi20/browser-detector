<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller\Helper;

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
 * @package    Zend_Controller
 * @subpackage Zend_Controller_Action_Helper
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: ContentNegogation.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Simplify AJAX context switching based on requested format
 *
 * @uses       \Zend\Controller\Action\Helper\AbstractHelper
 * @category   Zend
 * @package    Zend_Controller
 * @subpackage Zend_Controller_Action_Helper
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class ContentNegogation extends \Zend\Controller\Action\Helper\ContextSwitch
{
    private $_headers = array(
        'content-language' => array('placement' => 'APPEND', 'keyType' => 'http-equiv'),
        'content-type' => array('placement' => 'PREPEND', 'keyType' => 'http-equiv'),
        'content-length' => array('placement' => 'APPEND', 'keyType' => 'http-equiv'),
        'content-style-type' => array('placement' => 'APPEND', 'keyType' => 'http-equiv'),
        'content-script-type' => array('placement' => 'APPEND', 'keyType' => 'http-equiv'),
        'expires' => array('placement' => 'APPEND', 'keyType' => 'http-equiv'),
        'pragma' => array('placement' => 'APPEND', 'keyType' => 'http-equiv'),
        'refresh' => array('placement' => 'APPEND', 'keyType' => 'http-equiv'),
        'reply-to' => array('placement' => 'APPEND', 'keyType' => 'http-equiv'),
        'cache-control' => array('placement' => 'APPEND', 'keyType' => 'http-equiv'),
        'last-modified' => array('placement' => 'APPEND', 'keyType' => 'http-equiv'),
    );
    
    private $_useHtmlFive = false;
    
    /**
     * Constructor
     *
     * Add HTML context
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $isAjax = $this->getRequest()->isXmlHTTPRequest();
        
        $this->setContexts(array(
            'json' => array(
                'suffix'    => 'json',
                'headers'   => array('Content-Type' => 'application/json'),
                'callbacks' => array(
                    'init' => 'initJsonContext',
                    'post' => 'postJsonContext'
                )
            ),
            'xml'  => array(
                'suffix'    => 'xml',
                'headers'   => array('Content-Type' => 'application/xml')
            ),
            'xhtml'  => array(
                'suffix'    => ($isAjax ? 'xajax' : 'xhtml'),
                'headers'   => array('Content-Type' => 'application/xhtml+xml'),
                'callbacks' => array(
                    'post' => 'postHtmlContext'
                )
            ),
            'xhtmlmp'  => array(
                'suffix'    => ($isAjax ? 'xajaxmp' : 'xhtmlmp'),
                'headers'   => array('Content-Type' => 'text/html'),
                'callbacks' => array(
                    'post' => 'postHtmlContext'
                )
            ),
            'html'  => array(
                'suffix'    => ($isAjax ? 'ajax' : 'html'),
                'headers'   => array('Content-Type' => 'text/html'),
                'callbacks' => array(
                    'post' => 'postHtmlContext'
                )
            ),
            'chtml'  => array(
                'suffix'    => ($isAjax ? 'cajax' : 'chtml'),
                'headers'   => array('Content-Type' => 'text/html'),
                'callbacks' => array(
                    'post' => 'postHtmlContext'
                )
            ),
            'wap'  => array(
                'suffix'    => 'wap',
                'headers'   => array('Content-Type' => 'text/html'),
                'callbacks' => array(
                    'post' => 'postHtmlContext'
                )
            ),
            'rss'  => array(
                'suffix'    => 'rss',
                'headers'   => array('Content-Type' => 'text/html')
            ),
            'atom'  => array(
                'suffix'    => 'atom',
                'headers'   => array('Content-Type' => 'text/html')
            ),
            'css'  => array(
                'suffix'    => 'css',
                'headers'   => array('Content-Type' => 'text/css')
            ),
            'js'  => array(
                'suffix'    => 'js',
                'headers'   => array('Content-Type' => 'text/javascript')
            )
        ));
    }

    /**
     * HTML post processing
     *
     * JSON serialize view variables to response body
     *
     * @return void
     */
    public function postHtmlContext()
    {
        $response = $this->getResponse();
        $headers  = $response->getHeaders();
        $view     = $this->getActionController()->view;
        
        $encoding = \Zend\Registry::get('_encoding');
        
        if ($view->doctype()->isHtml5()) {
            $view->headMeta()->setCharset($encoding);
        }
        
        foreach ($headers as $header) {
            $headerName  = strtolower($header['name']);
            $headerType  = 'name';
            $headerPlace = 'APPEND';
            
            if (isset($this->_headers[$headerName])) {
                $headerType  = $this->_headers[$headerName]['keyType'];
                $headerPlace = $this->_headers[$headerName]['placement'];
            }
            
            $view->headMeta($header['value'], $headerName, $headerType, array(), $headerPlace);
        }
    }

    /**
     * Initialize Negogiation context switching
     *
     * Checks for XHR requests; if detected, attempts to perform context switch.
     *
     * @param  string $format
     * @return void
     */
    public function initContext($format = null)
    {
        // nintialize the Negotiator object
        $negotiator = new \I18N\Negotiator('de', 'iso-8859-1', 'de', 'application/xhtml+xml');
        
        // detect the encoding and set it to the registry and the view
        $encoding = $negotiator->getEncodingMatch(array('utf-8', 'iso-8859-1', 'utf-16'));
        
        \Zend\Registry::set('_encoding', $encoding);

        mb_internal_encoding($encoding);
        mb_regex_encoding($encoding);

        $view = $this->getActionController()->view;

        $view->setEncoding($encoding);
        $view->encoding = $encoding;
        
        // detect the locale and set it to the registry
        $sLocale      = $negotiator->getLocaleMatch(array('de-DE', 'de', 'en-US', 'en'));
        $view->locale = $sLocale;
        
        $oLocale = new \Zend\Locale\Locale($sLocale);
        \Zend\Registry::set('\\Zend\\Locale\\Locale', $oLocale);
        
        // detect the content type and search a matching context
        $type = $negotiator->getTypeMatch(array(/*'application/xhtml+xml', 'application/xml',*/ 'text/html', 'text/xml', 'text/javascript', 'text/css'));
        
        $contexts = $this->getContexts();
        //var_dump($format, $contexts[$format]);
        
        if (!isset($contexts[$format])) {
            foreach ($contexts as $context => $contextValues) {
                if ($type == $contextValues['headers']['Content-Type']) {
                    $format = $context;
                    break;
                }
            }
        }
        
        // set the doctype depending on the content type or disable the layout
        $layout = \Zend\Layout\Layout::getMvcInstance();
        
        if (in_array($format, array('html', 'ajax'))) {
            $view->doctype()->setDoctype($this->_useHtmlFive ? \Zend\View\Helper\Doctype::HTML5 : \Zend\View\Helper\Doctype::HTML4_STRICT);
        } elseif (in_array($format, array('xhtml', 'xajax'))) {
            $view->doctype()->setDoctype($this->_useHtmlFive ? \Zend\View\Helper\Doctype::XHTML5 : \Zend\View\Helper\Doctype::XHTML1_STRICT);
        }
        
        if (in_array($format, array('html', 'xhtml'))) {
            $layout->enableLayout();
        } else {
            $layout->disableLayout();
            //$layout->enableLayout();
        }
        
        // add the encoding to the content type
        $headers = $this->getHeaders($format);
        if (!empty($headers)) {
            $headerKeys = array_keys($headers);
            
            foreach ($headerKeys as $header) {
                $headers[$header] .= '; charset=' . $encoding;
            }
            
            $this->setHeaders($format, $headers);
        }
        
        // add the selected context to the request object
        $request = $this->getRequest();
        $request->setParam($this->getContextParam(), $format);
        
        // switch off auto disabling the layout
        $this->setAutoDisableLayout(false);

        parent::initContext($format);
        
        $layout->setViewSuffix($this->_getViewRenderer()->getViewSuffix());
    }
    
    public function setUseHtmlFive($usage)
    {
        $this->_useHtmlFive = (($usage) ? true : false);
        
        return $this;
    }
}
