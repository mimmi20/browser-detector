<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class IntexFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'aqua n11'        => 'intex aqua n11',
        'aqua trend'      => 'intex aqua trend',
        'aqua.active'     => 'intex aqua active',
        'aqua power+'     => 'intex aqua power+',
        'aqua_lifeiii'    => 'intex aqua life iii',
        'aqua life ii'    => 'intex aqua life ii',
        'aqua star ii hd' => 'intex aqua star ii hd',
        'aqua star ii'    => 'intex aqua star ii',
        'aqua star 4g'    => 'intex aqua star 4g',
        'aqua star'       => 'intex aqua star',
        'aqua_star'       => 'intex aqua star',
        'aqua_y2+'        => 'intex aqua y2+',
        'aqua y2'         => 'intex aqua y2',
        'aqua_y2'         => 'intex aqua y2',
        'aqua style'      => 'intex aqua style',
        'aqua_3g'         => 'intex aqua 3g',
        'aqua_i-4+'       => 'intex aqua i-4+',
        'aqua glory'      => 'intex aqua glory',
        'aqua marvel'     => 'intex aqua marvel',
        'aqua_sx'         => 'intex aqua sx',
        'cloud y4'        => 'intex cloud y4',
        'cloud_y4'        => 'intex cloud y4',
        'cloud y2'        => 'intex cloud y2',
        'cloud_y2'        => 'intex cloud y2',
        'cloud x11'       => 'intex cloud x11',
        'cloud_x5'        => 'intex cloud x5',
        'cloud x5'        => 'intex cloud x5',
        'cloud_x4'        => 'intex cloud x4',
        'cloud x4'        => 'intex cloud x4',
        'cloud_x2'        => 'intex cloud x2',
        'cloud x2'        => 'intex cloud x2',
        'cloud_x1'        => 'intex cloud x1',
        'cloud x1'        => 'intex cloud x1',
        'cloud_m5_ii'     => 'intex cloud m5 ii',
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
        $matches = [];

        if (preg_match('/((?:aqua|cloud)[_ \.][0-9a-z\-+_ ]+(?: (hd|4g))?)[; )]/i', $useragent, $matches)) {
            $key = 'intex ' . mb_strtolower(str_replace(['_', '.'], ' ', $matches[1]));

            if ($this->loader->has($key)) {
                return $this->loader->load($key, $useragent);
            }
        }

        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general intex device', $useragent);
    }
}
