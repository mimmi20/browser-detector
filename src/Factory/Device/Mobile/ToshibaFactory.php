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
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class ToshibaFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'at10pe-a'          => 'toshiba at10pe-a',
        'at10le-a'          => 'toshiba at10le-a',
        'toshiba/tg01'      => 'toshiba tg01',
        'toshiba-tg01'      => 'toshiba tg01',
        'folio_and_a'       => 'toshiba folio 100',
        'toshiba_ac_and_az' => 'toshiba folio 100',
        'folio100'          => 'toshiba folio 100',
        'at300se'           => 'toshiba at300se',
        'at300'             => 'toshiba at300',
        'at200'             => 'toshiba at200',
        'at100'             => 'toshiba at100',
        'at10-a'            => 'toshiba at10-a',
    ];

    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface|null
     */
    private $loader = null;

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
    public function detect(string $useragent, Stringy $s = null): array
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general toshiba device', $useragent);
    }
}
