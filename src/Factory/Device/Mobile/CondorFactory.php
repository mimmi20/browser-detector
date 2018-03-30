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

class CondorFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'ctab785r16-3g' => 'condor ctab785r16-3g',
        'pgn608'        => 'condor pgn-608',
        'pgn-509'       => 'condor pgn-509',
        'pgn-506'       => 'condor pgn-506',
        'pgn-505'       => 'condor pgn-505',
        'pkt-301'       => 'condor pkt-301',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general condor device';

    use Factory\DeviceFactoryTrait;
}
