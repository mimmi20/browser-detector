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
class ArnovaFactory implements Factory\FactoryInterface
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
        if ($s->contains('101 g4', false)) {
            return $this->loader->load('101 g4', $useragent);
        }

        if ($s->contains('AN10DG3', false)) {
            return $this->loader->load('10d g3', $useragent);
        }

        if ($s->contains('AN10BG3', false)) {
            return $this->loader->load('an10bg3', $useragent);
        }

        if ($s->contains('AN9G2I', false)) {
            return $this->loader->load('9 g2', $useragent);
        }

        if ($s->contains('AN7FG3', false)) {
            return $this->loader->load('7f g3', $useragent);
        }

        if ($s->contains('AN7EG3', false)) {
            return $this->loader->load('7e g3', $useragent);
        }

        if ($s->contains('AN7DG3', false)) {
            return $this->loader->load('7d g3', $useragent);
        }

        if ($s->contains('AN7CG2', false)) {
            return $this->loader->load('7c g2', $useragent);
        }

        if ($s->contains('AN7BG2DT', false)) {
            return $this->loader->load('7b g2 dt', $useragent);
        }

        if ($s->contains('ARCHM901', false)) {
            return $this->loader->load('archm901', $useragent);
        }

        return $this->loader->load('general arnova device', $useragent);
    }
}
