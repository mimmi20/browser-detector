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
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class PhilipsFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'htb9245d'            => 'philips htb9245d',
        'htb9225d'            => 'philips htb9225d',
        'htb7250d'            => 'philips htb7250d',
        'htb6251d'            => 'philips htb6251d',
        'htb5570d'            => 'philips htb5570d',
        'htb5540d'            => 'philips htb5540d',
        'htb5520g'            => 'philips htb5520g',
        'htb5510d'            => 'philips htb5510d',
        'htb5260g'            => 'philips htb5260g',
        'htb4150b'            => 'philips htb4150b',
        'htb3550g'            => 'philips htb3550g',
        'htb3520g'            => 'philips htb3520g',
        'htb3570'             => 'philips htb3570',
        'bdp7750'             => 'philips bdp7750',
        'bdp5700'             => 'philips bdp5700',
        'bdp5600'             => 'philips bdp5600',
        'bdp3490m'            => 'philips bdp3490m',
        'bdp3490'             => 'philips bdp3490',
        'avm-2017'            => 'philips blueray player',
        'avm-2016'            => 'philips blueray player',
        'avm-2015'            => 'philips blueray player',
        'avm-2014'            => 'philips blueray player',
        'avm-2013'            => 'philips blueray player',
        'avm-2012'            => 'philips blueray player',
        '(; philips; ; ; ; )' => 'general philips tv',
        'philipstv'           => 'general philips tv',
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

        return $this->loader->load('general philips tv', $useragent);
    }
}
