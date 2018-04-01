<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Platform;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class WindowsMobileFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $platforms = [
        'windows iot 10'                                                         => 'windows iot 10.0',
        'windows ce'                                                             => 'windows ce',
        'windows mobile; wce'                                                    => 'windows ce',
        '/Windows Phone 6/'                                                      => 'windows mobile os',
        '/Windows Phone OS|XBLWP7|ZuneWP7|Windows Phone|WPDesktop| wds |WPOS\:/' => 'windows phone',
        '/Windows Mobile (7|10)/'                                                => 'windows phone',
        '/Windows NT (?:7|8|10); ARM; Lumia/'                                    => 'windows phone',
    ];

    /**
     * @var string
     */
    private $genericPlatform = 'windows mobile os';

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
        foreach ($this->platforms as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load($this->genericPlatform, $useragent);
    }
}
