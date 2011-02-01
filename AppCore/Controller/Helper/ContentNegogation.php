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
 * @version    $Id$
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
     * Save default encoding code.
     *
     * @var     string
     */
    private $_defaultEncoding;

    /**
     * HTTP_ACCEPT_CHARSET
     * 
     * @var     array
     */
    private $_acceptEncoding = array();

    /**
     * the encodings which are wished to deliver
     * 
     * @var     array
     */
    private $_wantedEncoding = array();

    /**
     * Save default content type.
     *
     * @var     string
     */
    private $_defaultType;

    /**
     * HTTP_ACCEPT
     * 
     * @var     array
     */
    private $_acceptType = array();

    /**
     * the content type which is wished to deliver
     * 
     * @var     array
     */
    private $_wantedType = array();
    
    /**
     * Constructor
     *
     * Add HTML context
     *
     * @return void
     */
    public function __construct($options = null)
    {
        parent::__construct($options);
        
        $this->_negotiateEncoding();
        $this->_negotiateType();
        
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
                'headers'   => array('Content-Type' => 'application/vnd.wap.xhtml+xml'),
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
            'wap'  => array(
                'suffix'    => 'wap',
                'headers'   => array('Content-Type' => 'text/vnd.wap.wml'),
                'callbacks' => array(
                    'post' => 'postHtmlContext'
                )
            ),
            'rss'  => array(
                'suffix'    => 'rss',
                'headers'   => array('Content-Type' => 'application/rss+xml')
            ),
            'atom'  => array(
                'suffix'    => 'atom',
                'headers'   => array('Content-Type' => 'application/atom+xml')
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
        $defaultLocale = \Zend\Locale\Locale::findLocale();
        
        // detect the encoding and set it to the registry and the view
        $encoding = $this->_getEncodingMatch();
        
        \Zend\Registry::set('_encoding', $encoding);

        mb_internal_encoding($encoding);
        mb_regex_encoding($encoding);

        $view = $this->getActionController()->view;

        $view->setEncoding($encoding);
        $view->encoding = $encoding;
        
        // detect the locale and set it to the registry
        $sLocale      = \Zend\Locale\Locale::findLocale();
        $view->locale = $sLocale;
        
        $oLocale = new \Zend\Locale\Locale($sLocale);
        \Zend\Registry::set('Zend_Locale', $oLocale);
        
        // detect the content type and search a matching context
        $type = $this->_getTypeMatch();
        
        $contexts = $this->getContexts();
        
        if (!isset($contexts[$format])) {
            foreach ($contexts as $context => $contextValues) {
                if (!isset($contextValues['headers']['Content-Type'])) {
                    continue;
                }
                
                $header = $contextValues['headers']['Content-Type'];
                
                if (is_string($header) && $type == $header) {
                    $format = $context;
                    break;
                }
            }
        }
        
        // set the doctype depending on the content type or disable the layout
        $layout = \Zend\Layout\Layout::getMvcInstance();
        
        if (in_array($format, array('html', 'ajax'))) {
            $view->doctype()->setDoctype($this->_useHtmlFive ? \Zend\View\Helper\Doctype::HTML5 : \Zend\View\Helper\Doctype::HTML4_STRICT);
        } elseif (in_array($format, array('xhtml', 'xajax', 'xhtmlmp', 'xajaxmp'))) {
            $view->doctype()->setDoctype($this->_useHtmlFive ? \Zend\View\Helper\Doctype::XHTML5 : \Zend\View\Helper\Doctype::XHTML1_STRICT);
        }
        
        if (in_array($format, array('html', 'xhtml', 'xhtmlmp'))) {
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
        
        $suffix = $this->getSuffix($format);

        $this->_getViewRenderer()->setViewSuffix($suffix);
        $layout->setViewSuffix($suffix);
    }
    
    /**
     * sets the flag to tell that HTML5 should be used, if possible
     * 
     * @param boolean $usage
     *
     * @return ContentNegogation
     */
    public function setUseHtmlFive($usage)
    {
        $this->_useHtmlFive = (($usage) ? true : false);
        
        return $this;
    }
    
    /**
     * sets the default encoding
     * 
     * @param string $encoding
     *
     * @return ContentNegogation
     */
    public function setDefaultEncoding($encoding)
    {
        if (is_string($encoding)) {
            $this->_defaultEncoding = $encoding;
        }
        
        return $this;
    }
    
    /**
     * sets the default content type
     * 
     * @param string $type
     *
     * @return ContentNegogation
     */
    public function setDefaultType($type)
    {
        if (is_string($type)) {
            $this->_defaultType = $type;
        }
        
        return $this;
    }
    
    /**
     * sets the possible encodings to match against the possible ones
     * 
     * @param array|\Zend\Config\Config|string $encoding
     *
     * @return ContentNegogation
     */
    public function setMatchingEncoding($encoding)
    {
        if ($encoding instanceof \Zend\Config\Config) {
            $encoding = $encoding->toArray();
        }
        
        if (!is_array($encoding) && !is_string($encoding)) {
            return $this;
        }
        
        if (!is_array($encoding)) {
            $encoding = array($encoding);
        }
        
        $this->_wantedEncoding = $encoding;
        
        return $this;
    }
    
    /**
     * sets the default content type
     * 
     * @param array|\Zend\Config\Config|string $type
     *
     * @return ContentNegogation
     */
    public function setMatchingType($type)
    {
        if ($type instanceof \Zend\Config\Config) {
            $type = $type->toArray();
        }
        
        if (!is_array($type) && !is_string($type)) {
            return $this;
        }
        
        if (!is_array($type)) {
            $encoding = array($type);
        }
        
        $this->_wantedType = $type;
        
        return $this;
    }
    
    /**
     * Negotiate Encoding
     *
     * @return  void
     */
    private function _negotiateEncoding()
    {
        if (!isset($_SERVER['HTTP_ACCEPT_CHARSET'])) {
            $charsets = array_keys(\Zend\Locale\Locale::getHttpCharset());
        } else {
            $charsets = explode(',', $_SERVER['HTTP_ACCEPT_CHARSET']);
        }
        
        foreach ($charsets as $encoding) {
            if (!empty($encoding)) {
                $this->_acceptEncoding[] = preg_replace('/;.*/', '', $encoding);
            }
        }
    }
    
    /**
     * Negotiate the Content Type
     *
     * @return  void
     */
    private function _negotiateType()
    {
        if (!isset($_SERVER['HTTP_ACCEPT'])) {
            return;
        }
        foreach (explode(',', $_SERVER['HTTP_ACCEPT']) as $type) {
            if (!empty($type)) {
                $this->_acceptType[] = preg_replace('/;.*/', '', $type);
            }
        }
    }

    /**
     * Find Encoding match
     * 
     * @return  string
     */
    private function _getEncodingMatch()
    {
        $match = $this->_getMatch(
            (is_array($this->_wantedEncoding) ? $this->_wantedEncoding : array()), 
            $this->_acceptEncoding, 
            $this->_defaultEncoding
        );
        
        return strtolower($match);
    }

    /**
     * Find Content type match
     *
     * @return  string
     */
    private function _getTypeMatch()
    {
        $match = $this->_getMatch(
            (is_array($this->_wantedType) ? $this->_wantedType : array()), 
            $this->_acceptType,
            $this->_defaultType
        );
        
        return strtolower($match);
    }
    
    /**
     * Return first matched value from first and second parameter.
     * If there is no match found, then return third parameter.
     * 
     * @return  string
     * @param   array   $needle
     * @param   array   $haystack
     * @param   string  $default
     */
    private function _getMatch(array $needle, array $haystack, $default = '')
    {
        if (!$haystack) {
            return $default;
        }
        if (!$needle) {
            return current($haystack);
        }
        
        $a = array_intersect($needle, $haystack);
        
        if ($result = current($a)) {
            return $result;
        }
        return $default;
    }
}
