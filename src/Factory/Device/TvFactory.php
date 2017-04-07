<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class TvFactory implements Factory\FactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect($useragent, Stringy $s = null)
    {
        $deviceCode = 'general tv device';

        if (preg_match('/xbox one/i', $useragent)) {
            $deviceCode = 'xbox one';
        } elseif (preg_match('/xbox/i', $useragent)) {
            $deviceCode = 'xbox 360';
        } elseif (preg_match('/dlink\.dsm380/i', $useragent)) {
            $deviceCode = 'dsm 380';
        } elseif (preg_match('/NSZ\-GS7\/GX70/', $useragent)) {
            $deviceCode = 'nsz-gs7/gx70';
        } elseif (preg_match('/googletv/i', $useragent)) {
            $deviceCode = 'google tv';
        } elseif (preg_match('/idl\-6651n/i', $useragent)) {
            $deviceCode = 'idl-6651n';
        } elseif (preg_match('/loewe; sl32x/i', $useragent)) {
            $deviceCode = 'sl32x';
        } elseif (preg_match('/loewe; sl121/i', $useragent)) {
            $deviceCode = 'sl121';
        } elseif (preg_match('/loewe; sl150/i', $useragent)) {
            $deviceCode = 'sl150';
        } elseif (preg_match('/lf1v464/i', $useragent)) {
            $deviceCode = 'lf1v464';
        } elseif (preg_match('/lf1v401/i', $useragent)) {
            $deviceCode = 'lf1v401';
        } elseif (preg_match('/lf1v394/i', $useragent)) {
            $deviceCode = 'lf1v394';
        } elseif (preg_match('/lf1v373/i', $useragent)) {
            $deviceCode = 'lf1v373';
        } elseif (preg_match('/lf1v325/i', $useragent)) {
            $deviceCode = 'lf1v325';
        } elseif (preg_match('/lf1v307/i', $useragent)) {
            $deviceCode = 'lf1v307';
        } elseif (preg_match('/NETRANGEMMH/', $useragent)) {
            $deviceCode = 'netrangemmh';
        } elseif (preg_match('/viera/i', $useragent)) {
            $deviceCode = 'viera tv';
        } elseif (preg_match('/AVM\-2012/', $useragent)) {
            $deviceCode = 'blueray player';
        } elseif (preg_match('/\(; Philips; ; ; ; \)/', $useragent)) {
            $deviceCode = 'general philips tv';
        } elseif (preg_match('/Mxl661L32/', $useragent)) {
            $deviceCode = 'samsung smart tv';
        } elseif (preg_match('/SMART\-TV/', $useragent)) {
            $deviceCode = 'samsung smart tv';
        } elseif (preg_match('/KDL32HX755/', $useragent)) {
            $deviceCode = 'kdl32hx755';
        } elseif (preg_match('/KDL32W655A/', $useragent)) {
            $deviceCode = 'kdl32w655a';
        } elseif (preg_match('/KDL37EX720/', $useragent)) {
            $deviceCode = 'kdl37ex720';
        } elseif (preg_match('/KDL42W655A/', $useragent)) {
            $deviceCode = 'kdl42w655a';
        } elseif (preg_match('/KDL40EX720/', $useragent)) {
            $deviceCode = 'kdl40ex720';
        } elseif (preg_match('/KDL50W815B/', $useragent)) {
            $deviceCode = 'kdl50w815b';
        } elseif (preg_match('/SonyDTV115/', $useragent)) {
            $deviceCode = 'dtv115';
        } elseif (preg_match('/technisat digicorder isio s/i', $useragent)) {
            $deviceCode = 'digicorder isio s';
        } elseif (preg_match('/technisat digit isio s/i', $useragent)) {
            $deviceCode = 'digit isio s';
        } elseif (preg_match('/TechniSat MultyVision ISIO/', $useragent)) {
            $deviceCode = 'multyvision isio';
        } elseif (preg_match('/AQUOSBrowser/', $useragent)) {
            $deviceCode = 'aquos tv';
        } elseif (preg_match('/(CX919|gxt_dongle_3188)/', $useragent)) {
            $deviceCode = 'cx919';
        } elseif (preg_match('/Apple TV/', $useragent)) {
            $deviceCode = 'appletv';
        } elseif (preg_match('/netbox/i', $useragent)) {
            $deviceCode = 'netbox';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
