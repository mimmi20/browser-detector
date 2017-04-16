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
class MotorolaFactory implements Factory\FactoryInterface
{
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
        if ($s->contains('motog3', false)) {
            return $this->loader->load('motog3', $useragent);
        }

        if ($s->contains('xt1080', false)) {
            return $this->loader->load('xt1080', $useragent);
        }

        if ($s->contains('xt1068', false)) {
            return $this->loader->load('xt1068', $useragent);
        }

        if ($s->contains('xt1058', false)) {
            return $this->loader->load('xt1058', $useragent);
        }

        if ($s->contains('xt1052', false)) {
            return $this->loader->load('xt1052', $useragent);
        }

        if ($s->contains('xt1039', false)) {
            return $this->loader->load('xt1039', $useragent);
        }

        if ($s->contains('xt1033', false)) {
            return $this->loader->load('xt1033', $useragent);
        }

        if ($s->contains('xt1032', false)) {
            return $this->loader->load('xt1032', $useragent);
        }

        if ($s->contains('xt1021', false)) {
            return $this->loader->load('xt1021', $useragent);
        }

        if ($s->contains('xt926', false)) {
            return $this->loader->load('xt926', $useragent);
        }

        if ($s->contains('xt925', false)) {
            return $this->loader->load('xt925', $useragent);
        }

        if ($s->contains('droid razr hd', false)) {
            return $this->loader->load('xt923', $useragent);
        }

        if ($s->contains('xt910', false)) {
            return $this->loader->load('xt910', $useragent);
        }

        if ($s->contains('xt907', false)) {
            return $this->loader->load('xt907', $useragent);
        }

        if ($s->contains('xt890', false)) {
            return $this->loader->load('xt890', $useragent);
        }

        if ($s->containsAny(['xt875', 'droid bionic 4g'], false)) {
            return $this->loader->load('xt875', $useragent);
        }

        if ($s->contains('xt720', false)) {
            return $this->loader->load('milestone xt720', $useragent);
        }

        if ($s->contains('xt702', false)) {
            return $this->loader->load('xt702', $useragent);
        }

        if ($s->contains('xt615', false)) {
            return $this->loader->load('xt615', $useragent);
        }

        if ($s->contains('xt610', false)) {
            return $this->loader->load('xt610', $useragent);
        }

        if ($s->contains('xt530', false)) {
            return $this->loader->load('xt530', $useragent);
        }

        if ($s->contains('xt389', false)) {
            return $this->loader->load('xt389', $useragent);
        }

        if ($s->contains('xt320', false)) {
            return $this->loader->load('xt320', $useragent);
        }

        if ($s->contains('xt316', false)) {
            return $this->loader->load('xt316', $useragent);
        }

        if ($s->contains('xt311', false)) {
            return $this->loader->load('xt311', $useragent);
        }

        if ($s->contains('Xoom', true)) {
            return $this->loader->load('xoom', $useragent);
        }

        if ($s->contains('wx308', false)) {
            return $this->loader->load('wx308', $useragent);
        }

        if ($s->contains('t720', false)) {
            return $this->loader->load('t720', $useragent);
        }

        if ($s->contains('RAZRV3x', false)) {
            return $this->loader->load('razrv3x', $useragent);
        }

        if ($s->contains('MOT-V3i', true)) {
            return $this->loader->load('razr v3i', $useragent);
        }

        if ($s->contains('nexus 6', false)) {
            return $this->loader->load('nexus 6', $useragent);
        }

        if ($s->contains('mz608', false)) {
            return $this->loader->load('mz608', $useragent);
        }

        if ($s->containsAny(['mz607', 'xoom 2 me'], false)) {
            return $this->loader->load('mz607', $useragent);
        }

        if ($s->contains('mz615', false)) {
            return $this->loader->load('mz615', $useragent);
        }

        if ($s->containsAny(['mz616', 'xoom 2'], false)) {
            return $this->loader->load('mz616', $useragent);
        }

        if ($s->contains('mz604', false)) {
            return $this->loader->load('mz604', $useragent);
        }

        if ($s->contains('mz601', false)) {
            return $this->loader->load('mz601', $useragent);
        }

        if ($s->contains('milestone x', false)) {
            return $this->loader->load('milestone x', $useragent);
        }

        if ($s->contains('milestone', false)) {
            return $this->loader->load('milestone', $useragent);
        }

        if ($s->contains('me860', false)) {
            return $this->loader->load('me860', $useragent);
        }

        if ($s->contains('me600', false)) {
            return $this->loader->load('me600', $useragent);
        }

        if ($s->contains('me525', false)) {
            return $this->loader->load('me525', $useragent);
        }

        if ($s->contains('me511', false)) {
            return $this->loader->load('me511', $useragent);
        }

        if ($s->contains('mb860', false)) {
            return $this->loader->load('mb860', $useragent);
        }

        if ($s->contains('mb632', false)) {
            return $this->loader->load('mb632', $useragent);
        }

        if ($s->contains('mb612', false)) {
            return $this->loader->load('mb612', $useragent);
        }

        if ($s->contains('mb526', false)) {
            return $this->loader->load('mb526', $useragent);
        }

        if ($s->contains('mb525', false)) {
            return $this->loader->load('mb525', $useragent);
        }

        if ($s->contains('mb511', false)) {
            return $this->loader->load('mb511', $useragent);
        }

        if ($s->contains('mb300', false)) {
            return $this->loader->load('mb300', $useragent);
        }

        if ($s->contains('mb200', false)) {
            return $this->loader->load('mb200', $useragent);
        }

        if ($s->contains('es405b', false)) {
            return $this->loader->load('es405b', $useragent);
        }

        if ($s->contains('e1000', false)) {
            return $this->loader->load('e1000', $useragent);
        }

        if ($s->contains('DROID X2', false)) {
            return $this->loader->load('droid x2', $useragent);
        }

        if ($s->contains('DROIDX', false)) {
            return $this->loader->load('droidx', $useragent);
        }

        if ($s->contains('DROID RAZR 4G', false)) {
            return $this->loader->load('xt912b', $useragent);
        }

        if ($s->contains('DROID RAZR', false)) {
            return $this->loader->load('razr', $useragent);
        }

        if ($s->contains('DROID Pro', false)) {
            return $this->loader->load('droid pro', $useragent);
        }

        if ($s->containsAny(['droid-bionic', 'droid bionic'], false)) {
            return $this->loader->load('droid bionic', $useragent);
        }

        if ($s->contains('DROID2', true)) {
            return $this->loader->load('droid2', $useragent);
        }

        if ($s->contains('Droid', true)) {
            return $this->loader->load('droid', $useragent);
        }

        if ($s->contains('MotoA953', true)) {
            return $this->loader->load('a953', $useragent);
        }

        if ($s->contains('MotoQ9c', true)) {
            return $this->loader->load('q9c', $useragent);
        }

        if ($s->contains('L7', true)) {
            return $this->loader->load('slvr l7', $useragent);
        }

        return $this->loader->load('general motorola device', $useragent);
    }
}
