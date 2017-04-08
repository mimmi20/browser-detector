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
class TexetFactory implements Factory\FactoryInterface
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
        if ($s->contains('x-pad ix 7 3g', false)) {
            return $this->loader->load('tm-7068', $useragent);
        }

        if ($s->contains('x-pad lite 7.1', false)) {
            return $this->loader->load('tm-7066', $useragent);
        }

        if ($s->contains('x-pad style 7.1 3g', false)) {
            return $this->loader->load('tm-7058', $useragent);
        }

        if ($s->contains('x-navi', false)) {
            return $this->loader->load('tm-4672', $useragent);
        }

        if ($s->contains('tm-3204r', false)) {
            return $this->loader->load('tm-3204r', $useragent);
        }

        if ($s->contains('tm-7055hd', false)) {
            return $this->loader->load('tm-7055hd', $useragent);
        }

        if ($s->contains('tm-7058hd', false)) {
            return $this->loader->load('tm-7058hd', $useragent);
        }

        if ($s->contains('tm-7058', false)) {
            return $this->loader->load('tm-7058', $useragent);
        }

        if ($s->contains('tm-5204', false)) {
            return $this->loader->load('tm-5204', $useragent);
        }

        return $this->loader->load('general texet device', $useragent);
    }
}
