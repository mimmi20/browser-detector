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
namespace BrowserDetector\Factory\Device;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class TvFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'xbox one'                    => 'xbox one',
        'xbox'                        => 'xbox 360',
        'dlink.dsm380'                => 'dsm 380',
        'idl-6651n'                   => 'idl-6651n',
        'sl32x'                       => 'sl32x',
        'sl121'                       => 'sl121',
        'sl150'                       => 'sl150',
        'lf1v464'                     => 'lf1v464',
        'lf1v401'                     => 'lf1v401',
        'lf1v394'                     => 'lf1v394',
        'lf1v373'                     => 'lf1v373',
        'lf1v325'                     => 'lf1v325',
        'lf1v307'                     => 'lf1v307',
        'netrangemmh'                 => 'netrangemmh',
        'viera'                       => 'viera tv',
        'avm-2012'                    => 'blueray player',
        'technisat digicorder isio s' => 'digicorder isio s',
        'technisat digit isio s'      => 'digit isio s',
        'technisat multyvision isio'  => 'multyvision isio',
        'cx919'                       => 'cx919',
        'gxt_dongle_3188'             => 'cx919',
        '(; Philips; ; ; ; )'         => 'general philips tv',
        'mxl661l32'                   => 'samsung smart tv',
        'smart-tv'                    => 'samsung smart tv',
        'apple tv'                    => 'appletv',
        'netbox'                      => 'sony netbox',
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
        if (preg_match('/KDL\d{2}/', $useragent)) {
            return (new Tv\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['nsz-gs7/gx70', 'sonydtv'], false)) {
            return (new Tv\SonyFactory($this->loader))->detect($useragent, $s);
        }

        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general tv device', $useragent);
    }
}
