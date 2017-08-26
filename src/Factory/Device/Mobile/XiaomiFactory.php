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
use BrowserDetector\Loader\LoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class XiaomiFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'redmi 4x'       => 'xiaomitech redmi 4x',
        'redmi 4'        => 'xiaomitech redmi 4',
        'mi 5s'          => 'xiaomitech mi 5s',
        'mi 5'           => 'xiaomitech mi 5',
        'redmi note 4x'  => 'xiaomitech redmi note 4x',
        'note 4'         => 'xiaomitech redmi note 4',
        'redmi 3s'       => 'xiaomitech redmi 3s',
        'redmi 3'        => 'xiaomitech redmi 3',
        'redmi_note_3'   => 'xiaomitech redmi note 3',
        'redmi note 3'   => 'xiaomitech redmi note 3',
        'redmi note 2'   => 'xiaomitech redmi note 2',
        'mi note pro'    => 'xiaomitech mi note pro',
        'mi note'        => 'xiaomitech mi note',
        'mi max'         => 'xiaomitech mi max',
        'mi 4s'          => 'xiaomitech mi 4s',
        'mi 4w'          => 'xiaomitech mi 4w',
        'mi 4lte'        => 'xiaomitech mi 4 lte',
        'mi 3w'          => 'xiaomitech mi 3w',
        'mi pad'         => 'xiaomitech mi pad',
        'mipad'          => 'xiaomitech mi pad',
        'mi 2a'          => 'xiaomitech mi 2a',
        'mi 2sc'         => 'xiaomitech mi 2sc',
        'mi 2s'          => 'xiaomitech mi 2s',
        'mi 2'           => 'xiaomitech mi 2',
        'hm note 1w'     => 'xiaomitech hm note 1w',
        'hm note 1s'     => 'xiaomitech hm note 1s',
        'hm note 1ltetd' => 'xiaomitech hm note 1lte td',
        'hm note 1lte'   => 'xiaomitech hm note 1lte',
        'hm_1sw'         => 'xiaomitech hm 1sw',
        'hm 1sw'         => 'xiaomitech hm 1sw',
        'hm 1sc'         => 'xiaomitech hm 1sc',
        'hm 1s'          => 'xiaomitech hm 1s',
        '2015562'        => 'xiaomitech mi 4c',
        '2014813'        => 'xiaomitech hongmi 2 4g',
        '2014011'        => 'xiaomitech hongmi 1s',
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

        return $this->loader->load('general xiaomi device', $useragent);
    }
}
