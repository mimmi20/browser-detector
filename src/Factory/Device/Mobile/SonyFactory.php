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
class SonyFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'e5653'                => 'sony e5653',
        'd5322'                => 'sony d5322',
        'e5633'                => 'sony e5633',
        'f8331'                => 'sony f8331',
        'f8332'                => 'sony f8332',
        'g3121'                => 'sony g3121',
        'g3112'                => 'sony g3112',
        'g3125'                => 'sony g3125',
        'g3116'                => 'sony g3116',
        'g3123'                => 'sony g3123',
        'xperia m2'            => 'sony xperia m2',
        'f5321'                => 'sony f5321',
        'f5121'                => 'sony f5121',
        'f3311'                => 'sony f3311',
        'f3111'                => 'f3111',
        'e6853'                => 'e6853',
        'e6653'                => 'e6653',
        'e6553'                => 'e6553',
        'e5823'                => 'e5823',
        'e5603'                => 'e5603',
        'e2303'                => 'e2303',
        'e2105'                => 'e2105',
        'e2003'                => 'e2003',
        'c5502'                => 'c5502',
        'c5303'                => 'c5303',
        'c5302'                => 'c5302',
        'xperia s'             => 'xperia s',
        'c6902'                => 'c6902',
        'l36h'                 => 'l36h',
        'xperia z1'            => 'c6903',
        'c6903'                => 'c6903',
        'c6833'                => 'c6833',
        'c6606'                => 'c6606',
        'c6602'                => 'c6602',
        'xperia z'             => 'c6603',
        'c6603'                => 'c6603',
        'c6503'                => 'c6503',
        'c2305'                => 'c2305',
        'c2105'                => 'c2105',
        'c2005'                => 'c2005',
        'c1905'                => 'c1905',
        'c1904'                => 'c1904',
        'c1605'                => 'c1605',
        'c1505'                => 'c1505',
        'd5803'                => 'd5803',
        'd6633'                => 'd6633',
        'd6603'                => 'd6603',
        'l50u'                 => 'l50u',
        'd6503'                => 'd6503',
        'd5833'                => 'd5833',
        'd5503'                => 'd5503',
        'd5303'                => 'd5303',
        'd5103'                => 'd5103',
        'd2403'                => 'd2403',
        'd2306'                => 'd2306',
        'd2303'                => 'd2303',
        'd2302'                => 'd2302',
        'd2212'                => 'sony d2212',
        'd2203'                => 'd2203',
        'd2202'                => 'sony d2202',
        'd2105'                => 'd2105',
        'd2005'                => 'd2005',
        'sgpt13'               => 'sgpt13',
        'sgpt12'               => 'sgpt12',
        'sgp771'               => 'sgp771',
        'sgp712'               => 'sgp712',
        'sgp621'               => 'sgp621',
        'sgp611'               => 'sgp611',
        'SGP521'               => 'sgp521',
        'sgp512'               => 'sgp512',
        'sgp511'               => 'sgp511',
        'sgp412'               => 'sgp412',
        'sgp321'               => 'sgp321',
        'sgp312'               => 'sgp312',
        'sgp311'               => 'sgp311',
        'st26i'                => 'st26i',
        'st26a'                => 'st26a',
        'st23i'                => 'st23i',
        'st21iv'               => 'st21iv',
        'st21i2'               => 'st21i2',
        'st21i'                => 'st21i',
        'lt30p'                => 'lt30p',
        'xperia t'             => 'lt30p',
        'lt29i'                => 'lt29i',
        'lt26w'                => 'lt26w',
        'lt25i'                => 'lt25i',
        'x10iv'                => 'x10iv',
        'x10i'                 => 'x10i',
        'x10a'                 => 'x10a',
        'x10'                  => 'sonyericsson x10',
        'u20iv'                => 'u20iv',
        'u20i'                 => 'u20i',
        'u20a'                 => 'u20a',
        'st27i'                => 'st27i',
        'st25iv'               => 'st25iv',
        'st25i'                => 'st25i',
        'st25a'                => 'st25a',
        'st18iv'               => 'st18iv',
        'st18i'                => 'st18i',
        'st17i'                => 'st17i',
        'st15i'                => 'st15i',
        'so-01g'               => 'sony so-01g',
        'so-05d'               => 'so-05d',
        'so-03e'               => 'so-03e',
        'so-03c'               => 'so-03c',
        'so-02e'               => 'so-02e',
        'so-02d'               => 'so-02d',
        'so-02c'               => 'so-02c',
        'sk17iv'               => 'sk17iv',
        'sk17i'                => 'sk17i',
        'r800iv'               => 'r800iv',
        'r800i'                => 'r800i',
        'r800a'                => 'r800a',
        'mt27i'                => 'mt27i',
        'mt15iv'               => 'mt15iv',
        'mt15i'                => 'mt15i',
        'mt15a'                => 'mt15a',
        'mt11i'                => 'mt11i',
        'mk16i'                => 'mk16i',
        'mk16a'                => 'mk16a',
        'lt28h'                => 'lt28h',
        'lt28at'               => 'lt28at',
        'lt26ii'               => 'lt26ii',
        'lt26i'                => 'lt26i',
        'lt22i'                => 'lt22i',
        'lt18iv'               => 'lt18iv',
        'lt18i'                => 'lt18i',
        'lt18a'                => 'lt18a',
        'lt18'                 => 'lt18',
        'lt15iv'               => 'lt15iv',
        'lt15i'                => 'lt15i',
        'e15iv'                => 'e15iv',
        'e15i'                 => 'e15i',
        'e15av'                => 'e15av',
        'e15a'                 => 'e15a',
        'e10iv'                => 'e10iv',
        'e10i'                 => 'e10i',
        'tablet s'             => 'tablet s',
        'tablet p'             => 'sgpt211',
        'netbox'               => 'netbox',
        'xst2'                 => 'xst2',
        'x2'                   => 'sonyericsson x2',
        'x1i'                  => 'x1i',
        'wt19iv'               => 'wt19iv',
        'wt19i'                => 'wt19i',
        'wt19a'                => 'wt19a',
        'wt13i'                => 'wt13i',
        'w995'                 => 'w995',
        'w910i'                => 'w910i',
        'W890i'                => 'w890i',
        'w760i'                => 'w760i',
        'w715v'                => 'w715v',
        'w595'                 => 'w595',
        'w580i'                => 'w580i',
        'w508a'                => 'w508a',
        'w200i'                => 'w200i',
        'w150i'                => 'w150i',
        'w20i'                 => 'w20i',
        'u10i'                 => 'u10i',
        'u8i'                  => 'u8i',
        'u5i'                  => 'u5i',
        'u1iv'                 => 'u1iv',
        'u1i'                  => 'u1i',
        'u1'                   => 'sonyericsson u1',
        'so-01e'               => 'so-01e',
        'so-01d'               => 'so-01d',
        'so-01c'               => 'so-01c',
        'so-01b'               => 'so-01b',
        's500i'                => 's500i',
        's312'                 => 's312',
        'r800x'                => 'r800x',
        'k810i'                => 'k810i',
        'k800i'                => 'k800i',
        'k790i'                => 'k790i',
        'k770i'                => 'k770i',
        'j300'                 => 'j300',
        'j108i'                => 'j108i',
        'j20i'                 => 'j20i',
        'j10i2'                => 'j10i2',
        'g700'                 => 'g700',
        'ck15i'                => 'ck15i',
        'c905'                 => 'c905',
        'c902'                 => 'c902',
        'a5000'                => 'a5000',
        'ebrd1201'             => 'prst1',
        'ebrd1101'             => 'prst1',
        'playstation vita'     => 'playstation vita',
        'playstation portable' => 'playstation portable',
        'psp'                  => 'playstation portable',
        'playstation 4'        => 'playstation 4',
        'playstation 3'        => 'playstation 3',
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

        return $this->loader->load('general sonyericsson device', $useragent);
    }
}
