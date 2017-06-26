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
        'mi 5'           => 'xiaomitech mi 5',
        'redmi note 4'   => 'xiaomitech redmi note 4',
        'mi note pro'    => 'xiaomitech mi note pro',
        'mi max'         => 'mi max',
        'mi 4s'          => 'xiaomitech mi 4s',
        'mi 4w'          => 'mi 4w',
        'mi 4lte'        => 'mi 4 lte',
        'mi 3w'          => 'mi 3w',
        'mi pad'         => 'mi pad',
        'mipad'          => 'mi pad',
        'mi 2a'          => 'mi 2a',
        'mi 2s'          => 'mi 2s',
        'mi 2'           => 'mi 2',
        'redmi 3s'       => 'redmi 3s',
        'redmi 3'        => 'redmi 3',
        'redmi_note_3'   => 'redmi note 3',
        'redmi note 3'   => 'redmi note 3',
        'redmi note 2'   => 'redmi note 2',
        'hm note 1w'     => 'hm note 1w',
        'hm note 1s'     => 'hm note 1s',
        'hm note 1ltetd' => 'hm note 1lte td',
        'hm note 1lte'   => 'hm note 1lte',
        'hm_1sw'         => 'hm 1sw',
        'hm 1sw'         => 'hm 1sw',
        'hm 1sc'         => 'hm 1sc',
        'hm 1s'          => 'hm 1s',
        '2014813'        => 'xiaomitech hongmi 2 4g',
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
    public function detect($useragent, Stringy $s = null)
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general xiaomi device', $useragent);
    }
}
