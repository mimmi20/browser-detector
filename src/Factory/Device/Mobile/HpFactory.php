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
class HpFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'slate 21'           => 'hp slate 21',
        'slatebook 10 x2 pc' => 'hp slatebook 10 x2 pc',
        '7 plus'             => 'hp slate 7 plus',
        'ipaqhw6900'         => 'hp ipaq 6900',
        'slate 17'           => 'hp slate 17',
        'slate 10 hd'        => 'hp slate 10',
        'slate 6 voice'      => 'hp slate 6 voice',
        'touchpad'           => 'hp touchpad',
        'cm_tenderloin'      => 'hp touchpad',
        'palm-d050'          => 'palm tx',
        'pre/'               => 'hp pre',
        'pixi/'              => 'palm pixi',
        'blazer'             => 'palm blazer',
        'p160u'              => 'hp p160u',
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

        return $this->loader->load('general hp device', $useragent);
    }
}
