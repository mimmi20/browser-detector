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

use BrowserDetector\Factory\DeviceFactoryInterface;
use BrowserDetector\Loader\DeviceLoaderFactory;
use Psr\Log\LoggerInterface;

/**
 * Browser detection class
 */
class DarwinFactory implements DeviceFactoryInterface
{
    private $factories = [
        '/cfnetwork\/.*\((x86_64|i386)\)/i' => 'desktop',
        '/cfnetwork\/(97[14]|96[92]|95[85]|948|90[21]|89[743]|88[79]|811|808|790|75[78]|711|709|672|60[29]|548|485|467|459)/i' => 'mobile',
    ];

    /**
     * @var \BrowserDetector\Loader\DeviceLoaderFactory
     */
    private $loaderFactory;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->loaderFactory = new DeviceLoaderFactory($logger);
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return array
     */
    public function __invoke(string $useragent): array
    {
        $loaderFactory = $this->loaderFactory;

        foreach ($this->factories as $rule => $mode) {
            if (preg_match($rule, $useragent)) {
                $loader = $loaderFactory('apple', $mode);

                return $loader($useragent);
            }
        }

        $loader = $loaderFactory('apple', 'desktop');

        return $loader($useragent);
    }
}
