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
namespace BrowserDetector\Factory\Platform;

use BrowserDetector\Factory;
use BrowserDetector\Loader\PlatformLoader;
use Stringy\Stringy;

/**
 * Browser detection class
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class DarwinFactory implements Factory\FactoryInterface
{
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
        if ($s->contains('cfnetwork/887', false) && $s->contains('(x86_64)', false)) {
            return $this->loader->load('mac os x', $useragent, '10.13');
        }

        if ($s->contains('cfnetwork/887', false)) {
            return $this->loader->load('ios', $useragent, '11.0');
        }

        if ($s->contains('cfnetwork/808.2', false)) {
            return $this->loader->load('ios', $useragent, '10.2');
        }

        if ($s->contains('cfnetwork/808.1', false)) {
            return $this->loader->load('ios', $useragent, '10.1');
        }

        if ($s->contains('cfnetwork/808', false)) {
            return $this->loader->load('ios', $useragent, '10.0');
        }

        if ($s->containsAny(['cfnetwork/811', 'cfnetwork/807', 'cfnetwork/802', 'cfnetwork/798', 'cfnetwork/796'], false)) {
            return $this->loader->load('mac os x', $useragent, '10.12');
        }

        if ($s->contains('cfnetwork/790', false)) {
            return $this->loader->load('ios', $useragent, '10.0');
        }

        if ($s->contains('cfnetwork/760', false)) {
            return $this->loader->load('mac os x', $useragent, '10.11');
        }

        if ($s->contains('cfnetwork/758', false)) {
            return $this->loader->load('ios', $useragent, '9.0');
        }

        if ($s->contains('cfnetwork/757', false)) {
            return $this->loader->load('ios', $useragent, '9.0');
        }

        if ($s->containsAny(['cfnetwork/720', 'cfnetwork/718', 'cfnetwork/714', 'cfnetwork/709', 'cfnetwork/708', 'cfnetwork/705', 'cfnetwork/699', 'cfnetwork/696'], false)) {
            return $this->loader->load('mac os x', $useragent, '10.10');
        }

        if ($s->contains('cfnetwork/711.5', false)) {
            return $this->loader->load('ios', $useragent, '8.4');
        }

        if ($s->contains('cfnetwork/711.4', false)) {
            return $this->loader->load('ios', $useragent, '8.4');
        }

        if ($s->contains('cfnetwork/711.3', false)) {
            return $this->loader->load('ios', $useragent, '8.3');
        }

        if ($s->contains('cfnetwork/711.2', false)) {
            return $this->loader->load('ios', $useragent, '8.2');
        }

        if ($s->contains('cfnetwork/711.1', false)) {
            return $this->loader->load('ios', $useragent, '8.1');
        }

        if ($s->contains('cfnetwork/711.0', false)) {
            return $this->loader->load('ios', $useragent, '8.0');
        }

        if ($s->containsAny(['cfnetwork/673', 'cfnetwork/647'], false)) {
            return $this->loader->load('mac os x', $useragent, '10.9');
        }

        if ($s->contains('cfnetwork/672.1', false)) {
            return $this->loader->load('ios', $useragent, '7.1');
        }

        if ($s->contains('cfnetwork/672.0', false)) {
            return $this->loader->load('ios', $useragent, '7.0');
        }

        if ($s->contains('cfnetwork/609.1', false)) {
            return $this->loader->load('ios', $useragent, '6.1');
        }

        if ($s->contains('cfnetwork/609', false)) {
            return $this->loader->load('ios', $useragent, '6.0');
        }

        if ($s->contains('cfnetwork/602', false)) {
            return $this->loader->load('ios', $useragent, '6.0');
        }

        if ($s->containsAny(['cfnetwork/596', 'cfnetwork/595', 'cfnetwork/561'], false)) {
            return $this->loader->load('mac os x', $useragent, '10.8');
        }

        if ($s->contains('cfnetwork/548.1', false)) {
            return $this->loader->load('ios', $useragent, '5.1');
        }

        if ($s->contains('cfnetwork/548.0', false)) {
            return $this->loader->load('ios', $useragent, '5.0');
        }

        if ($s->containsAny(['cfnetwork/520', 'cfnetwork/515'], false)) {
            return $this->loader->load('mac os x', $useragent, '10.7');
        }

        if ($s->contains('cfnetwork/485.13', false)) {
            return $this->loader->load('ios', $useragent, '4.3');
        }

        if ($s->contains('cfnetwork/485.12', false)) {
            return $this->loader->load('ios', $useragent, '4.2');
        }

        if ($s->contains('cfnetwork/485.10', false)) {
            return $this->loader->load('ios', $useragent, '4.1');
        }

        if ($s->contains('cfnetwork/485.2', false)) {
            return $this->loader->load('ios', $useragent, '4.0');
        }

        if ($s->contains('cfnetwork/467.12', false)) {
            return $this->loader->load('ios', $useragent, '3.2');
        }

        if ($s->contains('cfnetwork/459', false)) {
            return $this->loader->load('ios', $useragent, '3.1');
        }

        if ($s->contains('cfnetwork/454', false)) {
            return $this->loader->load('mac os x', $useragent, '10.6');
        }

        if ($s->containsAny(['cfnetwork/438', 'cfnetwork/433', 'cfnetwork/422', 'cfnetwork/339', 'cfnetwork/330', 'cfnetwork/221', 'cfnetwork/220', 'cfnetwork/217'], false)) {
            return $this->loader->load('mac os x', $useragent, '10.5');
        }

        if ($s->containsAny(['cfnetwork/129', 'cfnetwork/128'], false)) {
            return $this->loader->load('mac os x', $useragent, '10.4');
        }

        if ($s->containsAny(['cfnetwork/4.0', 'cfnetwork/1.2', 'cfnetwork/1.1'], false)) {
            return $this->loader->load('mac os x', $useragent, '10.3');
        }

        return $this->loader->load('darwin', $useragent);
    }
}
