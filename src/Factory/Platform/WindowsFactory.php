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
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class WindowsFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $platforms = [
        'windows iot 10'      => 'windows iot 10.0',
        'windows nt 10'       => 'windows nt 10.0',
        'windows 10'          => 'windows nt 10.0',
        'windows nt 6.4'      => 'windows nt 6.4',
        'windows 6.4'         => 'windows nt 6.4',
        'windows nt 6.3; arm' => 'windows nt 6.3; arm',
        'windows nt 6.3'      => 'windows nt 6.3',
        'windows 6.3'         => 'windows nt 6.3',
        'windows 8.1'         => 'windows nt 6.3',
        'windows nt 6.2; arm' => 'windows nt 6.2; arm',
        'windows nt 6.2'      => 'windows nt 6.2',
        'windows 6.2'         => 'windows nt 6.2',
        'windows 8'           => 'windows nt 6.2',
        'winnt 6.2'           => 'windows nt 6.2',
        'windows nt 6.1'      => 'windows nt 6.1',
        'windows 6.1'         => 'windows nt 6.1',
        'windows 7'           => 'windows nt 6.1',
        'windows nt 6.0'      => 'windows nt 6.0',
        'windows 6.0'         => 'windows nt 6.0',
        'windows vista'       => 'windows nt 6.0',
        'windows 2003'        => 'windows 2003',
        'windows nt 5.3'      => 'windows nt 5.3',
        'windows 5.3'         => 'windows nt 5.3',
        'windows nt 5.2'      => 'windows nt 5.2',
        'windows 5.2'         => 'windows nt 5.2',
        'win9x/nt 4.90'       => 'windows me',
        'win 9x 4.90'         => 'windows me',
        'win 9x4.90'          => 'windows me',
        'windows me'          => 'windows me',
        'windows nt 5.1'      => 'windows nt 5.1',
        'windows 5.1'         => 'windows nt 5.1',
        'windows xp'          => 'windows nt 5.1',
        'windows nt 5.01'     => 'windows nt 5.01',
        'windows 5.01'        => 'windows nt 5.01',
        'windows nt 5.0'      => 'windows nt 5.0',
        'windows nt5.0'       => 'windows nt 5.0',
        'windows 5.0'         => 'windows nt 5.0',
        'windows 2000'        => 'windows nt 5.0',
        'win98'               => 'windows 98',
        'windows 98'          => 'windows 98',
        'win95'               => 'windows 95',
        'windows 95'          => 'windows 95',
        'windows nt 4.10'     => 'windows nt 4.10',
        'windows 4.10'        => 'windows nt 4.10',
        'windows nt 4.1'      => 'windows nt 4.1',
        'windows 4.1'         => 'windows nt 4.1',
        'windows nt 4.0'      => 'windows nt 4.0',
        'windows nt4.0'       => 'windows nt 4.0',
        'windows 4.0'         => 'windows nt 4.0',
        'winnt4.0'            => 'windows nt 4.0',
        'windows nt 3.51'     => 'windows nt 3.51',
        'windows 3.51'        => 'windows nt 3.51',
        'winnt3.51'           => 'windows nt 3.51',
        'windows nt 3.5'      => 'windows nt 3.5',
        'windows 3.5'         => 'windows nt 3.5',
        'winnt3.5'            => 'windows nt 3.5',
        'windows nt 3.1'      => 'windows nt 3.1',
        'windows nt'          => 'windows nt',
        'winnt'               => 'windows nt',
        'windows 3.11'        => 'windows 3.11',
        'windows 3.1'         => 'windows 3.1',
    ];

    /**
     * @var string
     */
    private $genericPlatform = 'windows';

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
     * Gets the information about the platform by User Agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect(string $useragent, Stringy $s)
    {
        foreach ($this->platforms as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load($this->genericPlatform, $useragent);
    }
}
