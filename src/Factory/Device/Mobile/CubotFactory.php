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

/**
 * @author Thomas Müller <mimmi20@live.de>
 */
class CubotFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'z100 pro'  => 'cubot z100 pro',
        'one'       => 'cubot one',
        ' cheetah ' => 'cubot cheetah',
        ' h1 '      => 'cubot h1',
        'note_s'    => 'cubot note s',
        'x12'       => 'cubot x12',
        's600'      => 'cubot s600',
        's550'      => 'cubot s550',
        's208'      => 'cubot s208',
        'p9'        => 'cubot p9',
        'gt99'      => 'cubot gt99',
        'c11'       => 'cubot c11',
        'c7'        => 'cubot c7',
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

        return $this->loader->load('general cubot device', $useragent);
    }
}
