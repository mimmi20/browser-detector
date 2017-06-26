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
class OdysFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'mira'             => 'odys mira',
        'evolution12'      => 'odys evolution 12',
        'maven_10_plus'    => 'maven 10 plus',
        'xelio10extreme'   => 'xelio 10 extreme',
        'xelio 10 extreme' => 'xelio 10 extreme',
        'xtreme'           => 'xtreme',
        'xpress pro'       => 'xpress pro',
        'xpress'           => 'xpress',
        'xeno10'           => 'xeno 10',
        'xeno 10'          => 'xeno 10',
        'xeliopt2pro'      => 'xelio pt2 pro',
        'xelio10pro'       => 'xelio 10 pro',
        'xelio 10 pro'     => 'xelio 10 pro',
        'xelio7pro'        => 'xelio 7 pro',
        'xelio 7 pro'      => 'xelio 7 pro',
        'xelio'            => 'xelio',
        'uno_x10'          => 'uno x10',
        'space10_plus_3g'  => 'space 10 plus 3g',
        'space'            => 'space',
        'sky plus'         => 'sky plus 3g',
        'odys-q'           => 'q',
        'noon'             => 'noon',
        'adm816hc'         => 'adm816hc',
        'adm816kc'         => 'adm816kc',
        'neo_quad10'       => 'neo quad 10',
        'loox plus'        => 'loox plus',
        'loox'             => 'loox',
        'ieos_quad_10_pro' => 'ieos quad 10 pro',
        'ieos_quad_w'      => 'ieos quad w',
        'ieos_quad'        => 'ieos quad',
        'connect7pro'      => 'connect 7 pro',
        'genesis'          => 'genesis',
        'evo'              => 'evo',
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
    public function detect($useragent, Stringy $s = null)
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general odys device', $useragent);
    }
}
