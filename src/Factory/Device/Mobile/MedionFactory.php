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
class MedionFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'p1035x'          => 'medion p1035x',
        's1035x'          => 'medion s1035x',
        'p1040x'          => 'medion p1040x',
        'p1050x'          => 'medion p1050x',
        'p1032x'          => 'medion p1032x',
        'x6001'           => 'medion x6001',
        'e691x'           => 'medion e691x',
        'e4004'           => 'medion e4004',
        'medion e5001'    => 'medion life e5001',
        'medion e4502'    => 'medion life e4502',
        'medion e4504'    => 'medion life e4504',
        'medion e4503'    => 'medion life e4503',
        'medion e4506'    => 'medion life e4506',
        'medion e4005'    => 'medion life e4005',
        'x5020'           => 'medion life x5020',
        'x5004'           => 'medion x5004',
        'x4701'           => 'medion x4701',
        'p850x'           => 'medion p850x',
        'p5001'           => 'medion life p5001',
        'p5004'           => 'medion life p5004',
        'p5005'           => 'medion life p5005',
        's5004'           => 'medion life s5004',
        'lifetab_p1034x'  => 'medion lifetab p1034x',
        'lifetab_p733x'   => 'medion lifetab p733x',
        'lifetab_s9714'   => 'medion lifetab s9714',
        'lifetab_s9512'   => 'medion lifetab s9512',
        'lifetab_s1036x'  => 'lenovo lifetab s1036x',
        'lifetab_s1034x'  => 'medion lifetab s1034x',
        'lifetab_s1033x'  => 'lenovo lifetab s1033x',
        'lifetab_s831x'   => 'lenovo lifetab s831x',
        'lifetab_s785x'   => 'lenovo lifetab s785x',
        'lifetab_s732x'   => 'medion lifetab s732x',
        'lifetab_p9516'   => 'medion lifetab p9516',
        'lifetab_p9514'   => 'medion lifetab p9514',
        'lifetab_p891x'   => 'medion lifetab p891x',
        'lifetab_p831x.2' => 'medion lifetab p831x.2',
        'lifetab_p831x'   => 'medion lifetab p831x',
        'lifetab_e10320'  => 'medion lifetab e10320',
        'lifetab_e10316'  => 'medion lifetab e10316',
        'lifetab_e10312'  => 'medion e10312',
        'lifetab_e10310'  => 'medion lifetab e10310',
        'lifetab_e7316'   => 'medion lifetab e7316',
        'lifetab_e7313'   => 'medion lifetab e7313',
        'lifetab_e7312'   => 'medion lifetab e7312',
        'lifetab_e733x'   => 'medion lifetab e733x',
        'lifetab_e723x'   => 'medion lifetab e723x',
        'p4501'           => 'medion md 98428',
        'p4502'           => 'medion life p4502',
        'life p4310'      => 'medion life p4310',
        'p4013'           => 'medion life p4013',
        'life p4012'      => 'medion lifetab p4012',
        'life e3501'      => 'medion life e3501',
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
    public function detect(string $useragent, Stringy $s = null): array
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general medion device', $useragent);
    }
}
