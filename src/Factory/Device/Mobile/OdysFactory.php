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
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class OdysFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'rapid_10_lte'     => 'odys rapid 10 lte',
        'neo6_lte'         => 'odys neo 6 lte',
        'visio'            => 'odys visio',
        'rapid7lte'        => 'odys rapid 7 lte',
        'pro q8 plus'      => 'odys pro q8 plus',
        'score_plus_3g'    => 'odys score plus 3g',
        'connect8plus'     => 'odys connect 8 plus 3g',
        'xelio_next_10'    => 'odys xelio next 10',
        'mira'             => 'odys mira',
        'evolution12'      => 'odys evolution 12',
        'maven_10_plus'    => 'odys maven 10 plus',
        'xelio10extreme'   => 'odys xelio 10 extreme',
        'xelio 10 extreme' => 'odys xelio 10 extreme',
        'xtreme'           => 'odys xtreme',
        'xpress pro'       => 'odys xpress pro',
        'xpress'           => 'odys xpress',
        'xeno10'           => 'odys xeno 10',
        'xeno 10'          => 'odys xeno 10',
        'xeliopt2pro'      => 'odys xelio pt2 pro',
        'xelio10pro'       => 'odys xelio 10 pro',
        'xelio 10 pro'     => 'odys xelio 10 pro',
        'xelio7pro'        => 'odys xelio 7 pro',
        'xelio 7 pro'      => 'odys xelio 7 pro',
        'xelio'            => 'odys xelio',
        'uno_x10'          => 'odys uno x10',
        'space10_plus_3g'  => 'odys space 10 plus 3g',
        'space'            => 'odys space',
        'sky plus'         => 'odys sky plus 3g',
        'odys-q'           => 'odys q',
        'noon'             => 'odys noon',
        'adm816hc'         => 'odys adm816hc',
        'adm816kc'         => 'odys adm816kc',
        'neo_quad10'       => 'odys neo quad 10',
        'loox plus'        => 'odys loox plus',
        'loox'             => 'odys loox',
        'ieos_quad_10_pro' => 'odys ieos quad 10 pro',
        'ieos_quad_pro'    => 'odys ieos quad pro',
        'ieos_quad_w'      => 'odys ieos quad w',
        'ieos_quad'        => 'odys ieos quad',
        'connect7pro'      => 'odys connect 7 pro',
        'genesis'          => 'odys genesis',
        'evo'              => 'odys evo',
        'tablet-pc-4'      => 'odys tablet pc 4',
    ];

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
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect(string $useragent, Stringy $s): array
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general odys device', $useragent);
    }
}
