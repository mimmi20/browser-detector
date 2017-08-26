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
namespace BrowserDetector\Factory\Device\Tv;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class SonyFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'nsz-gs7/gx70' => 'sony nsz-gs7-gx70',
        'kdl32hx755'   => 'sony kdl32hx755',
        'kdl32w655a'   => 'sony kdl32w655a',
        'kdl37ex720'   => 'sony kdl37ex720',
        'kdl42w655a'   => 'sony kdl42w655a',
        'kdl40ex720'   => 'sony kdl40ex720',
        'kdl50w815b'   => 'sony kdl50w815b',
    ];

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
    public function detect(string $useragent, Stringy $s = null): array
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('sony dtv', $useragent);
    }
}
