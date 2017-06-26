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
        'fiercexl'                 => 'alcatel fierce xl',
        '4024d'                    => 'alcatel ot-4024d',
        '4024x'                    => 'alcatel ot-4024x',
        '8008d'                    => 'ot-8008d',
        '8000d'                    => 'ot-8000d',
        '7049d'                    => 'ot-7049d',
        '7047d'                    => 'ot-7047d',
        '7041x'                    => 'ot-7041x',
        '7041d'                    => 'ot-7041d',
        '7040n'                    => 'alcatel ot-7040n',
        '7025d'                    => 'ot-7025d',
        '6050a'                    => 'ot-6050a',
        '6043d'                    => 'ot-6043d',
        '6040d'                    => 'ot-6040d',
        '6037y'                    => 'alcatel ot-6037y',
        '6036y'                    => 'ot-6036y',
        '6035r'                    => 'ot-6035r',
        '6034r'                    => 'ot-6034r',
        '4019a'                    => 'alcatel ot-4019a',
        '4010d'                    => 'alcatel ot-4010d',
        '4034d'                    => 'ot-4034d',
        '4033d'                    => 'alcatel ot-4033d',
        '6033x'                    => 'ot-6033x',
        '6032'                     => 'ot-6032',
        '6030x'                    => 'ot-6030x',
        '6030d'                    => 'ot-6030d',
        '6015x'                    => 'ot-6015x',
        '6012d'                    => 'ot-6012d',
        '6010x'                    => 'ot-6010x',
        '6010d'                    => 'ot-6010d',
        '5042d'                    => 'ot-5042d',
        '5042a'                    => 'alcatel ot-5042a',
        '5038x'                    => 'alcatel ot-5038x',
        '5036x'                    => 'alcatel ot-5036x',
        '5036d'                    => 'ot-5036d',
        '5035d'                    => 'ot-5035d',
        '5020d'                    => 'ot-5020d',
        '4037t'                    => 'ot-4037t',
        '4030a'                    => 'alcatel ot-4030a',
        '4030x'                    => 'ot-4030x',
        '4030d'                    => 'ot-4030d',
        '4015x'                    => 'ot-4015x',
        '4015d'                    => 'ot-4015d',
        '4012x'                    => 'ot-4012x',
        '4012a'                    => 'ot-4012a',
        '3075a'                    => 'ot-3075a',
        'one touch 997d'           => 'ot-997d',
        'one_touch_995'            => 'ot-995',
        'one touch 992d'           => 'ot-992d',
        'one touch 991t'           => 'ot-991t',
        'one touch 991d'           => 'ot-991d',
        'one touch 991'            => 'ot-991',
        'one_touch_990'            => 'ot-990',
        'one touch 985d'           => 'ot-985d',
        'one touch 980'            => 'ot-980',
        'one touch 918d'           => 'ot-918d',
        'one_touch_918'            => 'ot-918',
        'ot-908'                   => 'ot-908',
        'one_touch_908'            => 'ot-908',
        'one touch 903d'           => 'ot-903d',
        'one touch 890d'           => 'one touch 890d',
        'ot-890'                   => 'ot-890',
        'one_touch_890'            => 'ot-890',
        'ot871a'                   => 'ot-871a',
        'one_touch_818'            => 'ot-818',
        'ot-710d'                  => 'ot-710d',
        'ot510a'                   => 'alcatel ot-510a',
        'ot-216'                   => 'ot-216',
        'vodafone 975n'            => '975n',
        'vodafone 875'             => 'alcatel vodafone 875',
        'vodafone 785'             => 'alcatel vodafone 785',
        'v860'                     => 'v860',
        'vodafone smart ii'        => 'v860',
        'p321'                     => 'ot-p321',
        'p320x'                    => 'ot-p320x',
        'p310x'                    => 'ot-p310x',
        'p310a'                    => 'ot-p310a',
        'one touch tab 8hd'        => 'ot-tab8hd',
        'one touch tab 7hd'        => 'ot-tab7hd',
        'alcatel one touch fierce' => 'fierce',
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
