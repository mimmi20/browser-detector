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

use BrowserDetector\Factory\FactoryInterface;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class LinuxFactory implements FactoryInterface
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
     * Gets the information about the platform by User Agent
     *
     * @param string $agent
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect($agent)
    {
        $s = new Stringy($agent);

        $platformCode = 'linux';

        if ($s->contains('Debian APT-HTTP')) {
            $platformCode = 'debian';
        } elseif ($s->contains('linux mint', false)) {
            $platformCode = 'linux mint';
        } elseif ($s->contains('kubuntu', false)) {
            $platformCode = 'kubuntu';
        } elseif ($s->contains('ubuntu', false)) {
            $platformCode = 'ubuntu';
        } elseif ($s->contains('fedora', false)) {
            $platformCode = 'fedora linux';
        } elseif ($s->containsAny(['redhat', 'red hat'], false)) {
            $platformCode = 'redhat linux';
        } elseif ($s->contains('kfreebsd', false)) {
            $platformCode = 'debian with freebsd kernel';
        } elseif (preg_match('/(de|rasp)bian/i', $agent)) {
            $platformCode = 'debian';
        } elseif ($s->contains('centos', false)) {
            $platformCode = 'cent os linux';
        } elseif ($s->contains('CrOS')) {
            $platformCode = 'chromeos';
        } elseif ($s->contains('Joli OS')) {
            $platformCode = 'joli os';
        } elseif ($s->contains('mandriva', false)) {
            $platformCode = 'mandriva linux';
        } elseif ($s->contains('suse', false)) {
            $platformCode = 'suse linux';
        } elseif ($s->contains('gentoo', false)) {
            $platformCode = 'gentoo linux';
        } elseif ($s->contains('slackware', false)) {
            $platformCode = 'slackware linux';
        } elseif ($s->contains('ventana', false)) {
            $platformCode = 'ventana linux';
        } elseif ($s->contains('moblin', false)) {
            $platformCode = 'moblin';
        } elseif ($s->contains('Zenwalk GNU')) {
            $platformCode = 'zenwalk gnu linux';
        }

        return $this->loader->load($platformCode, $agent);
    }
}
