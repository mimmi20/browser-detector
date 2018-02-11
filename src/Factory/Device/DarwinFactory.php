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
namespace BrowserDetector\Factory\Device;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

/**
 * Browser detection class
 */
class DarwinFactory implements Factory\FactoryInterface
{
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
        $appleMobileFactory  = new Mobile\AppleFactory($this->loader);
        $appleDesktopFactory = new Desktop\AppleFactory($this->loader);

        $mobileCodes = [
            'cfnetwork/808',
            'cfnetwork/758',
            'cfnetwork/757',
            'cfnetwork/711',
            'cfnetwork/709',
            'cfnetwork/672',
            'cfnetwork/609',
            'cfnetwork/602',
            'cfnetwork/548',
            'cfnetwork/485',
            'cfnetwork/467',
            'cfnetwork/459',
        ];

        if ($s->containsAny($mobileCodes, false)) {
            return $appleMobileFactory->detect($useragent, $s);
        }

        return $appleDesktopFactory->detect($useragent, $s);
    }
}
