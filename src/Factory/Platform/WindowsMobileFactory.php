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
namespace BrowserDetector\Factory\Platform;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class WindowsMobileFactory implements Factory\FactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Gets the information about the platform by User Agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect(string $useragent, Stringy $s)
    {
        if ($s->containsAny(['windows ce', 'windows mobile; wce'], false)) {
            return $this->loader->load('windows ce', $useragent);
        }

        if (preg_match('/(Windows Phone OS|XBLWP7|ZuneWP7|Windows Phone|WPDesktop| wds )/', $useragent)) {
            $doMatchPhone = preg_match('/Windows Phone ([\d\.]+)/', $useragent, $matchesPhone);

            if (!$doMatchPhone || 7 <= $matchesPhone[1]) {
                return $this->loader->load('windows phone', $useragent);
            }

            return $this->loader->load('windows mobile os', $useragent);
        }

        if (preg_match('/Windows Mobile ([\d]+)/', $useragent, $matchesMobile) && 7.0 <= (float) $matchesMobile[1]) {
            return $this->loader->load('windows phone', $useragent);
        }

        if (preg_match('/Windows NT ([\d\.]+); ARM; Lumia/', $useragent, $matchesMobile) && 7.0 <= (float) $matchesMobile[1]) {
            return $this->loader->load('windows phone', $useragent);
        }

        return $this->loader->load('windows mobile os', $useragent);
    }
}
