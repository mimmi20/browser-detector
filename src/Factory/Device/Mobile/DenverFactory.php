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
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class DenverFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tad-90032'    => 'denver tad-90032',
        'taq-10223g'   => 'denver taq-10223g',
        'taq-10182mk2' => 'denver taq-10182mk2',
        'taq-10172mk3' => 'denver taq-10172mk3',
        'taq-10153'    => 'denver taq-10153',
        'taq-10112'    => 'denver taq-10112',
        'tad-10023'    => 'denver tad-10023',
        'tad-70112'    => 'denver tad-70112',
        'taq-70252'    => 'denver taq-70252',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general denver device';

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

        return $this->loader->load($this->genericDevice, $useragent);
    }
}
