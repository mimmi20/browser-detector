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
     * @var array
     */
    private $platforms = [
        'debian apt-http' => 'debian',
        'linux mint'      => 'linux mint',
        'kubuntu'         => 'kubuntu',
        'ubuntu'          => 'ubuntu',
        'fedora'          => 'fedora linux',
        'redhat'          => 'redhat linux',
        'red hat'         => 'redhat linux',
        'debian'          => 'debian',
        'raspbian'        => 'debian',
        'centos'          => 'cent os linux',
        'cros'            => 'chromeos',
        'joli os'         => 'joli os',
        'mandriva'        => 'mandriva linux',
        'suse'            => 'suse linux',
        'gentoo'          => 'gentoo linux',
        'slackware'       => 'slackware linux',
        'ventana'         => 'ventana linux',
        'moblin'          => 'moblin',
        'zenwalk gnu'     => 'zenwalk gnu linux',
        'linux arm'       => 'linux smartphone os (maemo)',
        'linux/x2/r1'     => 'linux smartphone os (maemo)',
        'startos'         => 'startos',
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
     * Gets the information about the platform by User Agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect($useragent, Stringy $s = null)
    {
        foreach ($this->platforms as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('linux', $useragent);
    }
}
