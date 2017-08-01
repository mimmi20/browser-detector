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
        'vs5013ml'    => 'digma vs5013ml',
        'vox s502 3g' => 'digma vox s502 3g',
        'ps1043mg'    => 'digma ps1043mg',
        'ps604m'      => 'digma ps604m',
        'ps474s'      => 'digma ps474s',
        'tt7026mw'    => 'digma tt7026mw',
        'pt452e'      => 'digma pt452e',
        'lt5001pg'    => 'digma lt5001pg',
        'lt4001pg'    => 'digma lt4001pg',
        'idxd7'       => 'digma idxd7 3g',
        'idxd4'       => 'digma idxd4 3g',
        'idxd5'       => 'digma idxd5',
        'idsd7'       => 'digma idsd7 3g',
        'idnd7'       => 'digma idnd7',
        'idjd7'       => 'digma idjd7',
        'idrq10'      => 'digma idrq10 3g',
        'idx5'        => 'digma idx5',
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
