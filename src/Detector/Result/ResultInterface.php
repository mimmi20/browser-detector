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

use UaMatcher\Browser\BrowserInterface;
use UaMatcher\Device\DeviceInterface;
use UaMatcher\Engine\EngineInterface;
use UaMatcher\Os\OsInterface;
use UaMatcher\Version\VersionInterface;
use Wurfl\WurflConstants;
use Psr\Log\LoggerInterface;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @property-read $id
 * @property-read $userAgent
 */
interface ResultInterface extends \UaMatcher\Result\ResultInterface
{
    /**
     * the class constructor
     *
     * @param string                              $userAgent
     * @param \Psr\Log\LoggerInterface            $logger
     * @param string|null                         $wurflKey
     * @param \UaMatcher\Device\DeviceInterface   $device
     * @param \UaMatcher\Os\OsInterface           $os
     * @param \UaMatcher\Browser\BrowserInterface $browser
     * @param \UaMatcher\Engine\EngineInterface   $engine
     */
    public function __construct(
        $userAgent,
        LoggerInterface $logger,
        $wurflKey = WurflConstants::NO_MATCH,
        DeviceInterface $device = null,
        OsInterface $os = null,
        BrowserInterface $browser = null,
        EngineInterface $engine = null
    );

    /**
     * returns a second device for rendering properties
     *
     * @return \BrowserDetector\Detector\Result\ResultInterface
     */
    public function getRenderAs();

    /**
     * sets a second device for rendering properties
     *
     * @var \BrowserDetector\Detector\Result\ResultInterface $result
     *
     * @return DeviceInterface
     */
    public function setRenderAs(ResultInterface $result);

    /**
     * returns the name of the browser including the company brand name, the browser version and the browser modes
     *
     * @param bool    $withBits
     * @param integer $mode
     *
     * @return mixed
     */
    public function getFullBrowser($withBits = true, $mode = null);

    /**
     * returns the name of the browser including the browser version and the browser modes
     *
     * @param bool    $withBits
     * @param integer $mode
     *
     * @return string
     */
    public function getFullBrowserName($withBits = true, $mode = null);

    /**
     * returns the name of the platform including the company brand name, the platform version
     *
     * @param bool    $withBits
     * @param integer $mode
     *
     * @return mixed
     */
    public function getFullPlatform($withBits = true, $mode = null);

    /**
     * returns the name of the platform including the platform version
     *
     * @param bool    $withBits
     * @param integer $mode
     *
     * @return mixed
     */
    public function getFullPlatformName($withBits = true, $mode = null);

    /**
     * returns the name of the actual device with version
     *
     * @param bool $withManufacturer
     *
     * @return string
     */
    public function getFullDevice($withManufacturer = false);

    /**
     * returns the name of the actual device with version
     *
     * @param bool $withManufacturer
     *
     * @return string
     */
    public function getFullDeviceName($withManufacturer = false);

    /**
     * return the Name of the rendering engine with the version
     *
     * @param integer $mode The format the version should be formated
     *
     * @return string
     */
    public function getFullEngine($mode = VersionInterface::COMPLETE_IGNORE_EMPTY);

    /**
     * return the Name of the rendering engine with the version
     *
     * @param integer $mode The format the version should be formated
     *
     * @return string
     */
    public function getFullEngineName($mode = VersionInterface::COMPLETE_IGNORE_EMPTY);

    /**
     * returns the name of the actual device without version
     *
     * @return string
     */
    public function getDeviceName();

    /**
     * @return string
     */
    public function getDeviceMarketingName();

    /**
     * returns the veraion of the actual device
     *
     * @return string
     */
    public function getDeviceVersion();

    /**
     * returns the manufacturer of the actual device
     *
     * @return \UaMatcher\Company\CompanyInterface
     */
    public function getDeviceManufacturer();

    /**
     * returns the brand of the actual device
     *
     * @return \UaMatcher\Company\CompanyInterface
     */
    public function getDeviceBrand();

    /**
     * @return \UaMatcher\Type\Device\TypeInterface
     */
    public function getDeviceType();

    /**
     * @return \UaMatcher\Type\Browser\TypeInterface
     */
    public function getBrowserType();

    /**
     * @return string
     */
    public function getDevicePointingMethod();

    /**
     * @return int|null
     */
    public function getDeviceResolutionWidth();

    /**
     * @return int|null
     */
    public function getDeviceResolutionHeight();

    /**
     * @return bool
     */
    public function hasDeviceDualOrientation();

    /**
     * @return bool
     */
    public function hasDeviceTouchScreen();

    /**
     * @return int
     */
    public function getDeviceColors();

    /**
     * @return bool
     */
    public function hasDeviceSmsEnabled();

    /**
     * @return bool
     */
    public function hasDeviceNfcSupport();

    /**
     * @return bool
     */
    public function hasDeviceQwertyKeyboard();

    /**
     * returns TRUE if the device supports RSS Feeds
     *
     * @return boolean
     */
    public function isRssSupported();

    /**
     * returns TRUE if the device supports PDF documents
     *
     * @return boolean
     */
    public function isPdfSupported();

    /**
     * returns TRUE if the device is a mobile
     *
     * @return boolean
     */
    public function isMobileDevice();

    /**
     * returns TRUE if the device is a tablet
     *
     * @return boolean
     */
    public function isTablet();

    /**
     * @return bool
     */
    public function isPhone();

    /**
     * @return bool
     */
    public function isSmartphone();

    /**
     * returns TRUE if the device is a desktop device
     *
     * @return boolean
     */
    public function isDesktop();

    /**
     * returns TRUE if the device is a TV device
     *
     * @return boolean
     */
    public function isTvDevice();

    /**
     * returns TRUE if the device ia a game console
     *
     * @return boolean
     */
    public function isConsole();

    /**
     * returns TRUE if the browser is a crawler
     *
     * @return boolean
     */
    public function isCrawler();

    /**
     * returns TRUE if the device is a Transcoder
     *
     * @return boolean
     */
    public function isTranscoder();

    /**
     * returns TRUE if the device is a Syndication Reader
     *
     * @return boolean
     */
    public function isSyndicationReader();

    /**
     * returns TRUE if the device is a Syndication Reader
     *
     * @return boolean
     */
    public function isBanned();

    /**
     * @return bool
     */
    public function isApp();

    /**
     * returns TRUE if the browser supports Frames
     *
     * @return boolean
     */
    public function supportsFrames();

    /**
     * returns TRUE if the browser supports IFrames
     *
     * @return boolean
     */
    public function supportsIframes();

    /**
     * returns TRUE if the browser supports Tables
     *
     * @return boolean
     */
    public function supportsTables();

    /**
     * returns TRUE if the browser supports Cookies
     *
     * @return boolean
     */
    public function supportsCookies();

    /**
     * returns TRUE if the browser supports BackgroundSounds
     *
     * @return boolean
     */
    public function supportsBackgroundSounds();

    /**
     * returns TRUE if the browser supports JavaScript
     *
     * @return boolean
     */
    public function supportsJavaScript();

    /**
     * returns TRUE if the browser supports VBScript
     *
     * @return boolean
     */
    public function supportsVbScript();

    /**
     * returns TRUE if the browser supports Java Applets
     *
     * @return boolean
     */
    public function supportsJavaApplets();

    /**
     * returns TRUE if the browser supports ActiveX Controls
     *
     * @return boolean
     */
    public function supportsActivexControls();

    /**
     * builds a atring for comparation with wurfl
     *
     * @return string
     */
    public function getComparationName();
}
