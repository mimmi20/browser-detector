<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Result;

use BrowserDetector\Detector\Company\AbstractCompany;
use BrowserDetector\Detector\Company\Unknown as UnknownCompany;
use Psr\Log\LoggerInterface;
use UaBrowserType\TypeInterface;
use UaBrowserType\Unknown;
use UaResult\Version;
use UaHelper\Utils;
use UaMatcher\Browser\BrowserInterface;
use UaMatcher\Device\DeviceInterface;
use UaMatcher\Engine\EngineInterface;
use UaMatcher\Os\OsInterface;
use Wurfl\WurflConstants;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @property-read $id
 * @property-read $useragent
 */
class Result extends \UaResult\Result implements ResultInterface, \Serializable
{
    /**
     * should the device render the content like another?
     *
     * @var \BrowserDetector\Detector\Result\Result
     */
    private $renderAs = null;

    /**
     * @var \UaMatcher\Device\DeviceInterface
     */
    private $device = null;

    /**
     * @var \UaMatcher\Browser\BrowserInterface
     */
    private $browser = null;

    /**
     * @var \UaMatcher\Os\OsInterface
     */
    private $os = null;

    /**
     * @var \UaMatcher\Engine\EngineInterface
     */
    private $engine = null;

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \BrowserDetector\Detector\Result\Result
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * the class constructor
     *
     * @param string $useragent
     * @param LoggerInterface $logger
     * @param null|string $wurflKey
     * @param \UaMatcher\Device\DeviceInterface|null $device
     * @param \UaMatcher\Os\OsInterface|null $os
     * @param \UaMatcher\Browser\BrowserInterface|null $browser
     * @param \UaMatcher\Engine\EngineInterface|null $engine
     */
    public function __construct(
        $useragent,
        LoggerInterface $logger,
        $wurflKey = WurflConstants::NO_MATCH,
        DeviceInterface $device = null,
        OsInterface $os = null,
        BrowserInterface $browser = null,
        EngineInterface $engine = null
    ) {
        parent::__construct($useragent, $logger, $wurflKey);

        $this->device  = $device;
        $this->os      = $os;
        $this->browser = $browser;
        $this->engine  = $engine;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize(
            array(
                'properties' => $this->properties,
                'renderAs'   => $this->renderAs,
                'wurflKey'   => $this->wurflKey,
                'useragent'  => $this->useragent,
                'device'     => $this->device,
                'os'         => $this->os,
                'browser'    => $this->browser,
                'engine'     => $this->engine,
            )
        );
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $data <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($data)
    {
        $unseriliazedData = unserialize($data);

        foreach ($unseriliazedData['properties'] as $property => $value) {
            $this->properties[$property] = $value;
        }

        $this->renderAs  = $unseriliazedData['renderAs'];
        $this->wurflKey  = $unseriliazedData['wurflKey'];
        $this->useragent = $unseriliazedData['useragent'];
        $this->engine    = $unseriliazedData['engine'];
        $this->os        = $unseriliazedData['os'];
        $this->browser   = $unseriliazedData['browser'];
        $this->engine    = $unseriliazedData['engine'];
    }

    /**
     * @return \UaMatcher\Device\DeviceInterface|null
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @return \UaMatcher\Browser\BrowserInterface|null
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * @return \UaMatcher\Os\OsInterface|null
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * @return \UaMatcher\Engine\EngineInterface|null
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Returns the value of a given capability name for the current result
     *
     * @param string  $name            must be a valid name of an virtual capability
     * @param boolean $includeRenderAs If TRUE and the renderAs result is defined,
     *                                 the property from the renderAs result will be included too
     *
     * @return string|Version Capability value
     */
    public function getVirtualCapability(
        $name,
        $includeRenderAs = false
    ) {
        $name = 'controlcap_' . $name;

        return $this->getCapability($name, $includeRenderAs);
    }

    /**
     * Returns the value of a given capability name for the current device
     *
     * @param string  $capabilityName  must be a valid capability name
     * @param boolean $includeRenderAs If TRUE and the renderAs resulr is
     *                                 ndefined, the property from the renderAs result will be
     *                                 included also
     *
     * @return string|Version Capability value
     * @throws \InvalidArgumentException
     */
    public function getCapability(
        $capabilityName,
        $includeRenderAs = false
    ) {
        $propertyValue = parent::getCapability($capabilityName);
        $renderedAs    = $this->getRenderAs();

        if ($includeRenderAs
            && ($renderedAs instanceof Result)
            && 'unknown' != strtolower($renderedAs->getCapability('renderingengine_name'))
        ) {
            $propertyValue = $this->_propertyToString($this->properties[$capabilityName]);
            $propertyValue .= ' [' . $this->_propertyToString($renderedAs->getCapability($capabilityName, false)) . ']';
        }

        return $propertyValue;
    }

    /**
     * returns a second device for rendering properties
     *
     * @return \BrowserDetector\Detector\Result\Result
     */
    public function getRenderAs()
    {
        return $this->renderAs;
    }

    /**
     * sets a second device for rendering properties
     *
     * @var \BrowserDetector\Detector\Result\ResultInterface $result
     *
     * @return DeviceInterface
     */
    public function setRenderAs(ResultInterface $result)
    {
        $this->renderAs = $result;

        return $this;
    }

    /**
     * converts the property value into a string
     *
     * @param mixed $property
     *
     * @return string
     */
    private function _propertyToString($property)
    {
        if (null === $property) {
            $strProperty = '(NULL)';
        } elseif ('' === $property) {
            $strProperty = '(empty)';
        } elseif (false === $property) {
            $strProperty = '(false)';
        } elseif (true === $property) {
            $strProperty = '(true)';
        } else {
            $strProperty = (string)$property;
        }

        return $strProperty;
    }

    /**
     * Magic Method
     *
     * @param string $name
     *
     * @throws \InvalidArgumentException
     * @return string
     */
    public function __get($name)
    {
        if (isset($name)) {
            switch ($name) {
                case 'deviceClass':
                    return $this->getCapability('deviceClass', false);
                    break;
                default:
                    // nothing to do here
                    break;
            }
        }

        return parent::__get($name);
    }

    /**
     * returns the name of the browser including the company brand name, the browser version and the browser modes
     *
     * @param bool    $withBits
     * @param integer $mode
     *
     * @return string
     */
    public function getFullBrowser(
        $withBits = true,
        $mode = null
    ) {
        if (null === $mode) {
            $mode = Version::COMPLETE | Version::IGNORE_MICRO_IF_EMPTY;
        }

        $browser    = $this->getFullBrowserName($withBits, $mode);
        $renderedAs = $this->getRenderAs();

        if ($renderedAs instanceof Result && 'unknown' != strtolower(
            $renderedAs->getCapability('mobile_browser', false)
        )
        ) {
            $browser .= ' [' . $renderedAs->getFullBrowserName($withBits, $mode) . ']';
        }

        return trim($browser);
    }

    /**
     * returns the name of the browser including the browser version and the browser modes
     *
     * @param bool    $withBits
     * @param integer $mode
     *
     * @return string
     */
    public function getFullBrowserName(
        $withBits = true,
        $mode = null
    ) {
        $browser = $this->getCapability('mobile_browser', false);

        if (!$browser) {
            return null;
        }

        if ('unknown' == strtolower($browser)) {
            return 'unknown';
        }

        if (null === $mode) {
            $mode = Version::COMPLETE | Version::IGNORE_MICRO_IF_EMPTY;
        }

        $version = $this->getCapability('mobile_browser_version', false)->getVersion(
            $mode
        );

        if ($browser != $version && '' != $version) {
            $browser .= ' ' . $version;
        }

        $additional = array();

        $modus = $this->getCapability('mobile_browser_modus', false);

        if ($modus) {
            $additional[] = $modus;
        }

        $bits = $this->getCapability('mobile_browser_bits', false);

        if ($bits && $withBits) {
            $additional[] = $bits . ' Bit';
        }

        $browser .= (!empty($additional) ? ' (' . implode(', ', $additional) . ')' : '');

        return trim($browser);
    }

    /**
     * returns the name of the platform including the company brand name, the platform version
     *
     * @param bool    $withBits
     * @param integer $mode
     *
     * @return string
     */
    public function getFullPlatform(
        $withBits = true,
        $mode = null
    ) {
        if (null === $mode) {
            $mode = Version::COMPLETE_IGNORE_EMPTY;
        }

        $os         = $this->getFullPlatformName($withBits, $mode);
        $renderedAs = $this->getRenderAs();

        if ($renderedAs instanceof Result && 'unknown' != strtolower($renderedAs->getCapability('device_os', false))
        ) {
            $os .= ' [' . $renderedAs->getFullPlatformName($withBits, $mode) . ']';
        }

        return trim($os);
    }

    /**
     * returns the name of the platform including the platform version
     *
     * @param bool    $withBits
     * @param integer $mode
     *
     * @return string
     */
    public function getFullPlatformName(
        $withBits = true,
        $mode = null
    ) {
        $name = $this->getCapability('device_os', false);

        if (!$name) {
            return null;
        }

        if ('unknown' == strtolower($name)) {
            return 'unknown';
        }

        if (null === $mode) {
            $mode = Version::COMPLETE_IGNORE_EMPTY;
        }

        $version = $this->getCapability('device_os_version', false)->getVersion($mode);
        $bits    = $this->getCapability('device_os_bits', false);

        $os = $name . ($name != $version && '' != $version ? ' ' . $version : '') . (($bits && $withBits) ? ' (' . $bits . ' Bit)' : '');

        return trim($os);
    }

    /**
     * returns the name of the actual device with version
     *
     * @param bool $withManufacturer
     *
     * @return string
     */
    public function getFullDevice($withManufacturer = false)
    {
        $device     = $this->getFullDeviceName($withManufacturer);
        $renderedAs = $this->getRenderAs();

        if ($renderedAs instanceof Result && 'unknown' != strtolower($renderedAs->getDeviceName())
        ) {
            $device .= ' [' . $renderedAs->getFullDeviceName($withManufacturer) . ']';
        }

        return trim($device);
    }

    /**
     * returns the name of the actual device with version
     *
     * @param bool $withManufacturer
     *
     * @return string
     */
    public function getFullDeviceName($withManufacturer = false)
    {
        $device = $this->getDeviceName();

        if (!$device) {
            return null;
        }

        if ('unknown' == strtolower($device)) {
            return 'unknown';
        }

        $version = $this->getCapability('model_version', false)->getVersion(Version::MAJORMINOR);
        $device .= ($device != $version && '' != $version ? ' ' . $version : '');

        if ($withManufacturer) {
            $manufacturer = $this->getDeviceBrand()->brandname;

            if (!$manufacturer || 'unknown' == $manufacturer) {
                $manufacturer = $this->getDeviceManufacturer()->name;
            }

            if ('unknown' !== $manufacturer && '' !== $manufacturer && false === strpos(
                $device,
                'general'
            ) && false === strpos($device, $manufacturer)
            ) {
                $device = $manufacturer . ' ' . $device;
            }
        }

        return trim($device);
    }

    /**
     * return the Name of the rendering engine with the version
     *
     * @param integer $mode The format the version should be formated
     *
     * @return string
     */
    public function getFullEngine($mode = Version::COMPLETE_IGNORE_EMPTY)
    {
        $engine     = $this->getFullEngineName($mode);
        $renderedAs = $this->getRenderAs();

        if ($renderedAs instanceof Result && 'unknown' != strtolower(
            $renderedAs->getCapability('renderingengine_name', false)
        )
        ) {
            $engine .= ' [' . $renderedAs->getFullEngineName($mode) . ']';
        }

        return trim($engine);
    }

    /**
     * return the Name of the rendering engine with the version
     *
     * @param integer $mode The format the version should be formated
     *
     * @return string
     */
    public function getFullEngineName($mode = Version::COMPLETE_IGNORE_EMPTY)
    {
        $engine = $this->getCapability('renderingengine_name', false);

        if (!$engine) {
            return null;
        }

        if ('unknown' == strtolower($engine)) {
            return 'unknown';
        }

        if (null === $mode) {
            $mode = Version::COMPLETE_IGNORE_EMPTY;
        }

        $version = $this->getCapability('renderingengine_version', false)->getVersion(
            $mode
        );

        return trim(
            $engine . (($engine != $version && '' != $version) ? ' ' . $version : '')
        );
    }

    /**
     * returns the name of the actual device without version
     *
     * @return string
     */
    public function getDeviceName()
    {
        return $this->device->getCapability('code_name');
    }

    /**
     * @return string
     */
    public function getDeviceMarketingName()
    {
        return $this->device->getCapability('marketing_name');
    }

    /**
     * returns the veraion of the actual device
     *
     * @return string
     */
    public function getDeviceVersion()
    {
        return null;
    }

    /**
     * returns the manufacturer of the actual device
     *
     * @return \UaMatcher\Company\CompanyInterface */
    public function getDeviceManufacturer()
    {
        $value = $this->device->getManufacturer();

        if (!($value instanceof AbstractCompany)) {
            $value = new UnknownCompany();
        }

        return $value;
    }

    /**
     * returns the brand of the actual device
     *
     * @return \UaMatcher\Company\CompanyInterface */
    public function getDeviceBrand()
    {
        $value = $this->device->getBrand();

        if (!($value instanceof AbstractCompany)) {
            $value = new UnknownCompany();
        }

        return $value;
    }

    /**
     * @return \UaDeviceType\TypeInterface
     */
    public function getDeviceType()
    {
        $type = $this->device->getDeviceType();

        if (!($type instanceof \UaDeviceType\TypeInterface)) {
            $type = new \UaDeviceType\Unknown();
        }

        return $type;
    }

    /**
     * @return \UaBrowserType\TypeInterface
     */
    public function getBrowserType()
    {
        $type = $this->browser->getBrowserType();

        if (!($type instanceof TypeInterface)) {
            $type = new Unknown();
        }

        return $type;
    }

    /**
     * @return string
     */
    public function getDevicePointingMethod()
    {
        return $this->device->getCapability('pointing_method');
    }

    /**
     * @return int|null
     */
    public function getDeviceResolutionWidth()
    {
        return $this->device->getCapability('resolution_width');
    }

    /**
     * @return int|null
     */
    public function getDeviceResolutionHeight()
    {
        return $this->device->getCapability('resolution_height');
    }

    /**
     * @return bool
     */
    public function hasDeviceDualOrientation()
    {
        return $this->device->getCapability('dual_orientation');
    }

    /**
     * @return bool
     */
    public function hasDeviceTouchScreen()
    {
        return ($this->getDevicePointingMethod() === 'touchscreen');
    }

    /**
     * @return int
     */
    public function getDeviceColors()
    {
        return $this->device->getCapability('colors');
    }

    /**
     * @return bool
     */
    public function hasDeviceSmsEnabled()
    {
        return $this->device->getCapability('sms_enabled');
    }

    /**
     * @return bool
     */
    public function hasDeviceNfcSupport()
    {
        return $this->device->getCapability('nfc_support');
    }

    /**
     * @return bool
     */
    public function hasDeviceQwertyKeyboard()
    {
        return $this->device->getCapability('has_qwerty_keyboard');
    }

    /**
     * returns TRUE if the device supports RSS Feeds
     *
     * @return boolean
     */
    public function isRssSupported()
    {
        return $this->browser->getCapability('rss_support');
    }

    /**
     * returns TRUE if the device supports PDF documents
     *
     * @return boolean
     */
    public function isPdfSupported()
    {
        return $this->browser->getCapability('pdf_support');
    }

    /**
     * returns TRUE if the device is a mobile
     *
     * @return boolean
     */
    public function isMobileDevice()
    {
        return $this->getDeviceType()->isMobile();
    }

    /**
     * returns TRUE if the device is a tablet
     *
     * @return boolean
     */
    public function isTablet()
    {
        return $this->getDeviceType()->isTablet();
    }

    /**
     * @return bool
     */
    public function isPhone()
    {
        return $this->getDeviceType()->isPhone();
    }

    /**
     * @return bool
     */
    public function isSmartphone()
    {
        if (!$this->isMobileDevice()) {
            return false;
        }

        if ($this->isTablet()) {
            return false;
        }

        if (!$this->isPhone()) {
            return false;
        }

        if (!$this->hasDeviceTouchScreen()) {
            return false;
        }

        if ($this->getDeviceResolutionWidth() < 320) {
            return false;
        }

        $osVersion = (float)$this->os->detectVersion()->getVersion(Version::MAJORMINOR);

        switch ($this->os->getName()) {
            case 'iOS':
                $isSmartPhone = ($osVersion >= 3.0);
                break;
            case 'Android':
                $isSmartPhone = ($osVersion >= 2.2);
                break;
            case 'Windows Phone OS':
                $isSmartPhone = true;
                break;
            case 'RIM OS':
                $isSmartPhone = ($osVersion >= 7.0);
                break;
            case 'webOS':
                $isSmartPhone = true;
                break;
            case 'MeeGo':
                $isSmartPhone = true;
                break;
            case 'Bada OS':
                $isSmartPhone = ($osVersion >= 2.0);
                break;
            default:
                $isSmartPhone = false;
                break;
        }

        return $isSmartPhone;
    }

    /**
     * returns TRUE if the device is a desktop device
     *
     * @return boolean
     */
    public function isDesktop()
    {
        return $this->getDeviceType()->isDesktop();
    }

    /**
     * returns TRUE if the device is a TV device
     *
     * @return boolean
     */
    public function isTvDevice()
    {
        return $this->getDeviceType()->isTv();
    }

    /**
     * returns TRUE if the device ia a game console
     *
     * @return boolean
     */
    public function isConsole()
    {
        return $this->getDeviceType()->isConsole();
    }

    /**
     * returns TRUE if the browser is a crawler
     *
     * @return boolean
     */
    public function isCrawler()
    {
        return $this->getBrowserType()->isBot();
    }

    /**
     * returns TRUE if the device is a Transcoder
     *
     * @return boolean
     */
    public function isTranscoder()
    {
        return $this->getBrowserType()->isTranscoder();
    }

    /**
     * returns TRUE if the device is a Syndication Reader
     *
     * @return boolean
     */
    public function isSyndicationReader()
    {
        return $this->getBrowserType()->isSyndicationReader();
    }

    /**
     * returns TRUE if the device is a Syndication Reader
     *
     * @return boolean
     */
    public function isBanned()
    {
        return $this->getBrowserType()->isBanned();
    }

    /**
     * @return bool
     */
    public function isApp()
    {
        $ua    = $this->useragent;
        $utils = new Utils();
        $utils->setUserAgent($ua);

        if ($this->os->getName() == 'iOS' && !$utils->checkIfContains('Safari')) {
            return true;
        }

        $patterns = array(
            '^Dalvik',
            'Darwin/',
            'CFNetwork',
            '^Windows Phone Ad Client',
            '^NativeHost',
            '^AndroidDownloadManager',
            '-HttpClient',
            '^AppCake',
            'AppEngine-Google',
            'AppleCoreMedia',
            '^AppTrailers',
            '^ChoiceFM',
            '^ClassicFM',
            '^Clipfish',
            '^FaceFighter',
            '^Flixster',
            '^Gold/',
            '^GoogleAnalytics/',
            '^Heart/',
            '^iBrowser/',
            'iTunes-',
            '^Java/',
            '^LBC/3.',
            'Twitter',
            'Pinterest',
            '^Instagram',
            'FBAN',
            '#iP(hone|od|ad)[\d],[\d]#',
            // namespace notation (com.google.youtube)
            '#[a-z]{3,}(?:\.[a-z]+){2,}#',
            //Windows MSIE Webview
            'WebView',
        );

        foreach ($patterns as $pattern) {
            if ($pattern[0] === '#') {
                // Regex
                if (preg_match($pattern, $ua)) {
                    return true;
                    break;
                }
                continue;
            }

            // Substring matches are not abstracted for performance
            $patternLength = strlen($pattern);
            $uaLength      = strlen($ua);

            if ($pattern[0] === '^') {
                // Starts with
                if (strpos($ua, substr($pattern, 1)) === 0) {
                    return true;
                    break;
                }
            } elseif ($pattern[$patternLength - 1] === '$') {
                // Ends with
                $patternLength--;
                $pattern = substr($pattern, 0, $patternLength);
                if (strpos($ua, $pattern) === ($uaLength - $patternLength)) {
                    return true;
                    break;
                }
            } else {
                // Match anywhere
                if (strpos($ua, $pattern) !== false) {
                    return true;
                    break;
                }
            }
        }

        return false;
    }

    /**
     * returns TRUE if the browser supports Frames
     *
     * @return boolean
     */
    public function supportsFrames()
    {
        return $this->getCapability('xhtml_supports_frame', false);
    }

    /**
     * returns TRUE if the browser supports IFrames
     *
     * @return boolean
     */
    public function supportsIframes()
    {
        return $this->getCapability('xhtml_supports_iframe', false);
    }

    /**
     * returns TRUE if the browser supports Tables
     *
     * @return boolean
     */
    public function supportsTables()
    {
        return $this->engine->getCapability('xhtml_table_support');
    }

    /**
     * returns TRUE if the browser supports Cookies
     *
     * @return boolean
     */
    public function supportsCookies()
    {
        return $this->engine->getCapability('cookie_support');
    }

    /**
     * returns TRUE if the browser supports BackgroundSounds
     *
     * @return boolean
     */
    public function supportsBackgroundSounds()
    {
        return $this->getCapability('supports_background_sounds', false);
    }

    /**
     * returns TRUE if the browser supports JavaScript
     *
     * @return boolean
     */
    public function supportsJavaScript()
    {
        return $this->getCapability('ajax_support_javascript', false);
    }

    /**
     * returns TRUE if the browser supports VBScript
     *
     * @return boolean
     */
    public function supportsVbScript()
    {
        return $this->getCapability('supports_vb_script', false);
    }

    /**
     * returns TRUE if the browser supports Java Applets
     *
     * @return boolean
     */
    public function supportsJavaApplets()
    {
        return $this->getCapability('supports_java_applets', false);
    }

    /**
     * returns TRUE if the browser supports ActiveX Controls
     *
     * @return boolean
     */
    public function supportsActivexControls()
    {
        return $this->getCapability('supports_activex_controls', false);
    }

    /**
     * builds a atring for comparation with wurfl
     *
     * @return string
     */
    public function getComparationName()
    {
        return $this->getCapability('mobile_browser', false) . ' on ' . $this->getCapability(
            'device_os',
            false
        ) . ', ' . $this->getDeviceName();
    }
}
