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
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MotorolaFactory implements Factory\FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return array
     */
    public function detect($useragent)
    {
        $deviceCode = 'general motorola device';

        if (preg_match('/MotoG3/i', $useragent)) {
            $deviceCode = 'motog3';
        } elseif (preg_match('/XT1080/i', $useragent)) {
            $deviceCode = 'xt1080';
        } elseif (preg_match('/XT1068/i', $useragent)) {
            $deviceCode = 'xt1068';
        } elseif (preg_match('/XT1058/i', $useragent)) {
            $deviceCode = 'xt1058';
        } elseif (preg_match('/XT1052/i', $useragent)) {
            $deviceCode = 'xt1052';
        } elseif (preg_match('/XT1039/i', $useragent)) {
            $deviceCode = 'xt1039';
        } elseif (preg_match('/XT1033/i', $useragent)) {
            $deviceCode = 'xt1033';
        } elseif (preg_match('/XT1032/i', $useragent)) {
            $deviceCode = 'xt1032';
        } elseif (preg_match('/XT1021/i', $useragent)) {
            $deviceCode = 'xt1021';
        } elseif (preg_match('/XT926/i', $useragent)) {
            $deviceCode = 'xt926';
        } elseif (preg_match('/XT925/i', $useragent)) {
            $deviceCode = 'xt925';
        } elseif (preg_match('/DROID RAZR HD/i', $useragent)) {
            $deviceCode = 'xt923';
        } elseif (preg_match('/XT910/i', $useragent)) {
            $deviceCode = 'xt910';
        } elseif (preg_match('/XT907/i', $useragent)) {
            $deviceCode = 'xt907';
        } elseif (preg_match('/XT890/i', $useragent)) {
            $deviceCode = 'xt890';
        } elseif (preg_match('/(XT875|DROID BIONIC 4G)/i', $useragent)) {
            $deviceCode = 'xt875';
        } elseif (preg_match('/XT720/i', $useragent)) {
            $deviceCode = 'milestone xt720';
        } elseif (preg_match('/XT702/i', $useragent)) {
            $deviceCode = 'xt702';
        } elseif (preg_match('/XT615/i', $useragent)) {
            $deviceCode = 'xt615';
        } elseif (preg_match('/XT610/i', $useragent)) {
            $deviceCode = 'xt610';
        } elseif (preg_match('/XT530/i', $useragent)) {
            $deviceCode = 'xt530';
        } elseif (preg_match('/XT389/i', $useragent)) {
            $deviceCode = 'xt389';
        } elseif (preg_match('/XT320/i', $useragent)) {
            $deviceCode = 'xt320';
        } elseif (preg_match('/XT316/i', $useragent)) {
            $deviceCode = 'xt316';
        } elseif (preg_match('/XT311/i', $useragent)) {
            $deviceCode = 'xt311';
        } elseif (preg_match('/Xoom/i', $useragent)) {
            $deviceCode = 'xoom';
        } elseif (preg_match('/WX308/i', $useragent)) {
            $deviceCode = 'wx308';
        } elseif (preg_match('/T720/i', $useragent)) {
            $deviceCode = 't720';
        } elseif (preg_match('/RAZRV3x/i', $useragent)) {
            $deviceCode = 'razrv3x';
        } elseif (preg_match('/MOT\-V3i/', $useragent)) {
            $deviceCode = 'razr v3i';
        } elseif (preg_match('/nexus 6/i', $useragent)) {
            $deviceCode = 'nexus 6';
        } elseif (preg_match('/mz608/i', $useragent)) {
            $deviceCode = 'mz608';
        } elseif (preg_match('/(mz607|xoom 2 me)/i', $useragent)) {
            $deviceCode = 'mz607';
        } elseif (preg_match('/(mz616|xoom 2)/i', $useragent)) {
            $deviceCode = 'mz616';
        } elseif (preg_match('/mz615/i', $useragent)) {
            $deviceCode = 'mz615';
        } elseif (preg_match('/mz604/i', $useragent)) {
            $deviceCode = 'mz604';
        } elseif (preg_match('/mz601/i', $useragent)) {
            $deviceCode = 'mz601';
        } elseif (preg_match('/milestone x/i', $useragent)) {
            $deviceCode = 'milestone x';
        } elseif (preg_match('/milestone/i', $useragent)) {
            $deviceCode = 'milestone';
        } elseif (preg_match('/me860/i', $useragent)) {
            $deviceCode = 'me860';
        } elseif (preg_match('/me600/i', $useragent)) {
            $deviceCode = 'me600';
        } elseif (preg_match('/me525/i', $useragent)) {
            $deviceCode = 'me525';
        } elseif (preg_match('/me511/i', $useragent)) {
            $deviceCode = 'me511';
        } elseif (preg_match('/mb860/i', $useragent)) {
            $deviceCode = 'mb860';
        } elseif (preg_match('/mb632/i', $useragent)) {
            $deviceCode = 'mb632';
        } elseif (preg_match('/mb612/i', $useragent)) {
            $deviceCode = 'mb612';
        } elseif (preg_match('/mb526/i', $useragent)) {
            $deviceCode = 'mb526';
        } elseif (preg_match('/mb525/i', $useragent)) {
            $deviceCode = 'mb525';
        } elseif (preg_match('/mb511/i', $useragent)) {
            $deviceCode = 'mb511';
        } elseif (preg_match('/mb300/i', $useragent)) {
            $deviceCode = 'mb300';
        } elseif (preg_match('/mb200/i', $useragent)) {
            $deviceCode = 'mb200';
        } elseif (preg_match('/es405b/i', $useragent)) {
            $deviceCode = 'es405b';
        } elseif (preg_match('/e1000/i', $useragent)) {
            $deviceCode = 'e1000';
        } elseif (preg_match('/DROID X2/i', $useragent)) {
            $deviceCode = 'droid x2';
        } elseif (preg_match('/DROIDX/i', $useragent)) {
            $deviceCode = 'droidx';
        } elseif (preg_match('/DROID RAZR 4G/i', $useragent)) {
            $deviceCode = 'xt912b';
        } elseif (preg_match('/DROID RAZR/i', $useragent)) {
            $deviceCode = 'razr';
        } elseif (preg_match('/DROID Pro/i', $useragent)) {
            $deviceCode = 'droid pro';
        } elseif (preg_match('/droid(\-| )bionic/i', $useragent)) {
            $deviceCode = 'droid bionic';
        } elseif (preg_match('/DROID2/', $useragent)) {
            $deviceCode = 'droid2';
        } elseif (preg_match('/Droid/', $useragent)) {
            $deviceCode = 'droid';
        } elseif (preg_match('/MotoA953/', $useragent)) {
            $deviceCode = 'a953';
        } elseif (preg_match('/MotoQ9c/', $useragent)) {
            $deviceCode = 'q9c';
        } elseif (preg_match('/L7/', $useragent)) {
            $deviceCode = 'slvr l7';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
