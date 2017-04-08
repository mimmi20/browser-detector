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
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BqFactory implements Factory\FactoryInterface
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
        if ($s->contains('Aquaris E5 HD', true)) {
            return $this->loader->load('aquaris e5 hd', $useragent);
        }

        if ($s->contains('Aquaris M10', true)) {
            return $this->loader->load('aquaris m10', $useragent);
        }

        if ($s->contains('Aquaris M5', true)) {
            return $this->loader->load('aquaris m5', $useragent);
        }

        if ($s->containsAny(['Aquaris M4.5', 'Aquaris_M4.5'], true)) {
            return $this->loader->load('aquaris m4.5', $useragent);
        }

        if ($s->contains('Aquaris 5 HD', true)) {
            return $this->loader->load('aquaris e5', $useragent);
        }

        if ($s->contains('7056G', true)) {
            return $this->loader->load('7056g', $useragent);
        }

        if ($s->contains('BQS-4007', true)) {
            return $this->loader->load('bqs-4007', $useragent);
        }

        if ($s->contains('BQS-4005', true)) {
            return $this->loader->load('bqs-4005', $useragent);
        }

        return $this->loader->load('general bq device', $useragent);
    }
}
