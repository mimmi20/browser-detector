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

class TexetFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'x-pad ix 7 3g'      => 'texet tm-7068',
        'x-pad lite 7.1'     => 'texet tm-7066',
        'tm-7058hd'          => 'texet tm-7058hd',
        'tm-7058'            => 'texet tm-7058',
        'x-pad style 7.1 3g' => 'texet tm-7058',
        'x-navi'             => 'texet tm-4672',
        'tm-3204r'           => 'texet tm-3204r',
        'tm-7055hd'          => 'texet tm-7055hd',
        'tm-5204'            => 'texet tm-5204',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general texet device';

    use Factory\DeviceFactoryTrait;
}
