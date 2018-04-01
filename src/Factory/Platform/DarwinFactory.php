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
use BrowserDetector\Loader\PlatformLoader;
use Stringy\Stringy;

/**
 * Browser detection class
 */
class DarwinFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $platforms = [
        '/cfnetwork\/887.*\(x86_64\)/' => 'mac os x',
        'cfnetwork/887'                => 'ios',
        'cfnetwork/808'                => 'ios',
        'cfnetwork/811'                => 'mac os x',
        'cfnetwork/807'                => 'mac os x',
        'cfnetwork/802'                => 'mac os x',
        'cfnetwork/798'                => 'mac os x',
        'cfnetwork/796'                => 'mac os x',
        'cfnetwork/790'                => 'ios',
        'cfnetwork/760'                => 'mac os x',
        'cfnetwork/758'                => 'ios',
        'cfnetwork/757'                => 'ios',
        'cfnetwork/720'                => 'mac os x',
        'cfnetwork/718'                => 'mac os x',
        'cfnetwork/714'                => 'mac os x',
        'cfnetwork/709'                => 'mac os x',
        'cfnetwork/708'                => 'mac os x',
        'cfnetwork/705'                => 'mac os x',
        'cfnetwork/699'                => 'mac os x',
        'cfnetwork/696'                => 'mac os x',
        'cfnetwork/711'                => 'ios',
        'cfnetwork/673'                => 'mac os x',
        'cfnetwork/647'                => 'mac os x',
        'cfnetwork/672'                => 'ios',
        'cfnetwork/609'                => 'ios',
        'cfnetwork/602'                => 'ios',
        'cfnetwork/596'                => 'mac os x',
        'cfnetwork/595'                => 'mac os x',
        'cfnetwork/561'                => 'mac os x',
        'cfnetwork/548'                => 'ios',
        'cfnetwork/520'                => 'mac os x',
        'cfnetwork/515'                => 'mac os x',
        'cfnetwork/485'                => 'ios',
        'cfnetwork/467'                => 'ios',
        'cfnetwork/459'                => 'ios',
        'cfnetwork/454'                => 'mac os x',
        'cfnetwork/438'                => 'mac os x',
        'cfnetwork/433'                => 'mac os x',
        'cfnetwork/422'                => 'mac os x',
        'cfnetwork/339'                => 'mac os x',
        'cfnetwork/330'                => 'mac os x',
        'cfnetwork/221'                => 'mac os x',
        'cfnetwork/220'                => 'mac os x',
        'cfnetwork/217'                => 'mac os x',
        'cfnetwork/129'                => 'mac os x',
        'cfnetwork/128'                => 'mac os x',
        'cfnetwork/4.0'                => 'mac os x',
        'cfnetwork/1.2'                => 'mac os x',
        'cfnetwork/1.1'                => 'mac os x',
    ];

    /**
     * @var string
     */
    private $genericPlatform = 'darwin';

    /**
     * @var \BrowserDetector\Loader\PlatformLoader
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\PlatformLoader $loader
     */
    public function __construct(PlatformLoader $loader)
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
        foreach ($this->platforms as $searchkey => $platfornKey) {
            if ($s->contains($searchkey, false)) {
                return $this->loader->load($platfornKey, $useragent);
            }
        }

        return $this->loader->load($this->genericPlatform, $useragent);
    }
}
