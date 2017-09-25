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
class BlackBerryFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'bbb100-2'    => 'blackberry bbb100-2',
        'bba100-2'    => 'blackberry bba100-2',
        'stv100-4'    => 'blackberry stv100-4',
        'bb10; kbd'   => 'blackberry kbd',
        'bb10; touch' => 'blackberry z10',
        'bb10;touch'  => 'blackberry z10',
        'playbook'    => 'rim playbook',
        '9981'        => 'blackberry 9981',
        '9930'        => 'blackberry 9930',
        '9900'        => 'blackberry bold touch 9900',
        '9860'        => 'blackberry torch 9860',
        '9810'        => 'blackberry 9810',
        '9800'        => 'blackberry 9800',
        '9790'        => 'blackberry 9790',
        '9780'        => 'blackberry 9780',
        '9720'        => 'blackberry 9720',
        '9700'        => 'blackberry 9700',
        '9670'        => 'blackberry 9670',
        '9630'        => 'blackberry 9630',
        '9550'        => 'blackberry 9550',
        '9520'        => 'blackberry 9520',
        '9500'        => 'blackberry 9500',
        '9380'        => 'blackberry 9380',
        '9360'        => 'blackberry 9360',
        '9320'        => 'blackberry 9320',
        '9300'        => 'blackberry 9300',
        '9220'        => 'blackberry 9220',
        '9105'        => 'blackberry 9105',
        '9000'        => 'blackberry 9000',
        '8900'        => 'blackberry 8900',
        '8830'        => 'blackberry 8830',
        '8800'        => 'blackberry 8800',
        '8700'        => 'blackberry 8700',
        '8530'        => 'blackberry 8530',
        '8520'        => 'blackberry 8520',
        '8350i'       => 'blackberry 8350i',
        '8310'        => 'blackberry 8310',
        '8230'        => 'blackberry 8230',
        '8110'        => 'blackberry 8110',
        '8100'        => 'blackberry 8100',
        '7520'        => 'blackberry 7520',
        '7130'        => 'blackberry 7130',
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

        return $this->loader->load('general blackberry device', $useragent);
    }
}
