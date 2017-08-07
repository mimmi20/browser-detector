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
class AlcatelFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        '8050d'                    => 'alcatel ot-8050d',
        '8030y'                    => 'alcatel ot-8030y',
        '8008d'                    => 'alcatel ot-8008d',
        '8000d'                    => 'alcatel ot-8000d',
        '7070x'                    => 'alcatel ot-7070x',
        '7049d'                    => 'alcatel ot-7049d',
        '7047d'                    => 'alcatel ot-7047d',
        '7041x'                    => 'alcatel ot-7041x',
        '7041d'                    => 'alcatel ot-7041d',
        '7040n'                    => 'alcatel ot-7040n',
        '7040f'                    => 'alcatel ot-7040f',
        '7040e'                    => 'alcatel ot-7040e',
        '7040d'                    => 'alcatel ot-7040d',
        '7040a'                    => 'alcatel ot-7040a',
        '7025d'                    => 'alcatel ot-7025d',
        '6050a'                    => 'alcatel ot-6050a',
        '6045y'                    => 'alcatel ot-6045y',
        '6043d'                    => 'alcatel ot-6043d',
        '6040d'                    => 'alcatel ot-6040d',
        '6039y'                    => 'alcatel ot-6039y',
        '6037y'                    => 'alcatel ot-6037y',
        '6036y'                    => 'alcatel ot-6036y',
        '6035r'                    => 'alcatel ot-6035r',
        '6034r'                    => 'alcatel ot-6034r',
        '6034y'                    => 'alcatel ot-6034y',
        '6034m'                    => 'alcatel ot-6034m',
        '6033x'                    => 'alcatel ot-6033x',
        '6032'                     => 'alcatel ot-6032',
        '6030x'                    => 'alcatel ot-6030x',
        '6030d'                    => 'alcatel ot-6030d',
        '6016x'                    => 'alcatel ot-6016x',
        '6016d'                    => 'alcatel ot-6016d',
        '6015x'                    => 'alcatel ot-6015x',
        '6012w'                    => 'alcatel ot-6012w',
        '6012e'                    => 'alcatel ot-6012e',
        '6012d'                    => 'alcatel ot-6012d',
        '6012a'                    => 'alcatel ot-6012a',
        '6010x'                    => 'alcatel ot-6010x',
        '6010d'                    => 'alcatel ot-6010d',
        '5070d'                    => 'alcatel ot-5070d',
        '5070x'                    => 'alcatel ot-5070x',
        '5045d'                    => 'alcatel ot-5045d',
        '5042d'                    => 'alcatel ot-5042d',
        '5042a'                    => 'alcatel ot-5042a',
        '5038x'                    => 'alcatel ot-5038x',
        '5036x'                    => 'alcatel ot-5036x',
        '5036d'                    => 'alcatel ot-5036d',
        '5035y'                    => 'alcatel ot-5035y',
        '5035e'                    => 'alcatel ot-5035e',
        '5035d'                    => 'alcatel ot-5035d',
        '5020w'                    => 'alcatel ot-5020w',
        '5020e'                    => 'alcatel ot-5020e',
        '5020d'                    => 'alcatel ot-5020d',
        '5010d'                    => 'alcatel ot-5010d',
        '5025d'                    => 'alcatel ot-5025d',
        '5022x'                    => 'alcatel ot-5022x',
        '5022d'                    => 'alcatel ot-5022d',
        '4037t'                    => 'alcatel ot-4037t',
        '4034d'                    => 'alcatel ot-4034d',
        '4033d'                    => 'alcatel ot-4033d',
        '4030y'                    => 'alcatel ot-4030y',
        '4030x'                    => 'alcatel ot-4030x',
        '4030d'                    => 'alcatel ot-4030d',
        '4030a'                    => 'alcatel ot-4030a',
        '4027d'                    => 'alcatel ot-4027d',
        '4024x'                    => 'alcatel ot-4024x',
        '4024d'                    => 'alcatel ot-4024d',
        '4019a'                    => 'alcatel ot-4019a',
        '4015x'                    => 'alcatel ot-4015x',
        '4015d'                    => 'alcatel ot-4015d',
        '4012x'                    => 'alcatel ot-4012x',
        '4012a'                    => 'alcatel ot-4012a',
        '4010d'                    => 'alcatel ot-4010d',
        '3075a'                    => 'alcatel ot-3075a',
        'vf-895n'                  => 'alcatel vf-895n',
        'vf-795'                   => 'alcatel vf-795',
        'fiercexl'                 => 'alcatel fierce xl',
        'one touch 997d'           => 'alcatel ot-997d',
        'one_touch_995'            => 'alcatel ot-995',
        'ot-995'                   => 'alcatel ot-995',
        'one touch 992d'           => 'alcatel ot-992d',
        'one touch 991t'           => 'alcatel ot-991t',
        'one touch 991d'           => 'alcatel ot-991d',
        'one touch 991'            => 'alcatel ot-991',
        'one_touch_990'            => 'alcatel ot-990',
        'one touch 985d'           => 'alcatel ot-985d',
        'one touch 980'            => 'alcatel ot-980',
        'one touch 918d'           => 'alcatel ot-918d',
        'one_touch_918'            => 'alcatel ot-918',
        'ot-908'                   => 'alcatel ot-908',
        'one_touch_908'            => 'alcatel ot-908',
        'one touch 903d'           => 'alcatel ot-903d',
        'one touch 903'            => 'alcatel ot-903',
        'one touch 890d'           => 'alcatel one touch 890d',
        'ot-890'                   => 'alcatel ot-890',
        'one_touch_890'            => 'alcatel ot-890',
        'ot871a'                   => 'alcatel ot-871a',
        'one_touch_818'            => 'alcatel ot-818',
        'ot-710d'                  => 'alcatel ot-710d',
        'ot510a'                   => 'alcatel ot-510a',
        'ot-216'                   => 'alcatel ot-216',
        'vodafone 975n'            => 'alcatel 975n',
        'vodafone 875'             => 'alcatel vodafone 875',
        'vodafone 785'             => 'alcatel vodafone 785',
        'v860'                     => 'alcatel v860',
        'vodafone smart ii'        => 'alcatel v860',
        'p321'                     => 'alcatel ot-p321',
        'p320x'                    => 'alcatel ot-p320x',
        'p310x'                    => 'alcatel ot-p310x',
        'p310a'                    => 'alcatel ot-p310a',
        'one touch tab 8hd'        => 'alcatel ot-tab8hd',
        'one touch tab 7hd'        => 'alcatel ot-tab7hd',
        'alcatel one touch fierce' => 'alcatel fierce',
        'alcatel-oh5'              => 'alcatel oh5',
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

        return $this->loader->load('general alcatel device', $useragent);
    }
}
