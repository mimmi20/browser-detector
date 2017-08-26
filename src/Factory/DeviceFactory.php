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
namespace BrowserDetector\Factory;

use BrowserDetector\Helper\Desktop;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\Tv as TvHelper;
use BrowserDetector\Loader\LoaderInterface;
use Stringy\Stringy;

/**
 * Device detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DeviceFactory implements FactoryInterface
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
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect(string $useragent, Stringy $s = null): array
    {
        if (!$s->containsAny(['freebsd', 'raspbian'], false)
            && $s->containsAny(['darwin', 'cfnetwork'], false)
        ) {
            return (new Device\DarwinFactory($this->loader))->detect($useragent, $s);
        }

        if ((new MobileDevice($s))->isMobile()) {
            return (new Device\MobileFactory($this->loader))->detect($useragent, $s);
        }

        if ((new TvHelper($s))->isTvDevice()) {
            return (new Device\TvFactory($this->loader))->detect($useragent, $s);
        }

        if ((new Desktop($s))->isDesktopDevice()) {
            return (new Device\DesktopFactory($this->loader))->detect($useragent, $s);
        }

        return $this->loader->load('unknown', $useragent);
    }
}
