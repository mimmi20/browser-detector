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
class DigmaFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'vox s502 3g' => 'digma vox s502 3g',
        'ps1043mg'    => 'digma ps1043mg',
        'tt7026mw'    => 'digma tt7026mw',
        'idxd7'       => 'digma idxd7 3g',
        'idxd4'       => 'digma idxd4 3g',
        'idsd7'       => 'digma idsd7 3g',
        'idnd7'       => 'digma idnd7',
        'idjd7'       => 'digma idjd7',
        'idrq10'      => 'digma idrq10 3g',
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

        return $this->loader->load('general digma device', $useragent);
    }
}
