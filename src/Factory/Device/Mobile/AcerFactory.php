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
class AcerFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'a3-a40'       => 'acer a3-a40',
        'a1-841'       => 'acer a1-841',
        ' t08 '        => 'acer t08',
        'a1-840fhd'    => 'acer a1-840fhd',
        'a1-840'       => 'acer a1-840',
        'e380'         => 'acer e380',
        'v370'         => 'v370',
        'stream-s110'  => 'stream s110',
        's500'         => 's500',
        'liquid mt'    => 's120',
        'liquid metal' => 's120',
        'z500'         => 'acer z500',
        'z200'         => 'acer z200',
        'z150'         => 'z150',
        'liquid'       => 's100',
        'b1-770'       => 'b1-770',
        'b1-730hd'     => 'b1-730hd',
        'b1-721'       => 'b1-721',
        'b1-711'       => 'b1-711',
        'b1-710'       => 'b1-710',
        'b1-a71'       => 'b1-a71',
        'a1-830'       => 'a1-830',
        'a1-811'       => 'a1-811',
        'a1-810'       => 'a1-810',
        'a701'         => 'a701',
        'a700'         => 'a700',
        'a511'         => 'a511',
        'a510'         => 'a510',
        'a501'         => 'a501',
        'a500'         => 'a500',
        'a211'         => 'a211',
        'a210'         => 'a210',
        'a200'         => 'a200',
        'a101c'        => 'a101c',
        'a101'         => 'a101',
        'a100'         => 'a100',
        'a3-a20fhd'    => 'acer a3-a20fhd',
        'a3-a20'       => 'a3-a20',
        'a3-a11'       => 'a3-a11',
        'a3-a10'       => 'a3-a10',
        'g100w'        => 'g100w',
        'e320'         => 'e320',
        'e310'         => 'e310',
        'e140'         => 'e140',
        'da241hl'      => 'da241hl',
        'allegro'      => 'allegro',
        'tm01'         => 'tm01',
        'm220'         => 'm220',
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

        return $this->loader->load('general acer device', $useragent);
    }
}
