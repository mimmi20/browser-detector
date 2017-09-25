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
class LyfFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'ls-6001' => 'lyf ls-6001',
        'ls-5506' => 'lyf ls-5506',
        'ls-5505' => 'lyf ls-5505',
        'ls-5504' => 'lyf ls-5504',
        'ls-5503' => 'lyf ls-5503',
        'ls-5502' => 'lyf ls-5502',
        'ls-5501' => 'lyf ls-5501',
        'ls-5201' => 'lyf ls-5201',
        'ls-5021' => 'lyf ls-5021',
        'ls-5020' => 'lyf ls-5020',
        'ls-5018' => 'lyf ls-5018',
        'ls-5017' => 'lyf ls-5017',
        'ls-5016' => 'lyf ls-5016',
        'ls-5015' => 'lyf ls-5015',
        'ls-5014' => 'lyf ls-5014',
        'ls-5013' => 'lyf ls-5013',
        'ls-5010' => 'lyf ls-5010',
        'ls-5009' => 'lyf ls-5009',
        'ls-5008' => 'lyf ls-5008',
        'ls-5006' => 'lyf ls-5006',
        'ls-5005' => 'lyf ls-5005',
        'ls-5002' => 'lyf ls-5002',
        'ls-4505' => 'lyf ls-4505',
        'ls-4503' => 'lyf ls-4503',
        'ls-4008' => 'lyf ls-4008',
        'ls-4006' => 'lyf ls-4006',
        'ls-4005' => 'lyf ls-4005',
        'ls-4004' => 'lyf ls-4004',
        'ls-4003' => 'lyf ls-4003',
        'ls-4002' => 'lyf ls-4002',
        'ls-4001' => 'lyf ls-4001',
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

        return $this->loader->load('general lyf device', $useragent);
    }
}
