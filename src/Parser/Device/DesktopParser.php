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
namespace BrowserDetector\Parser\Device;

use BrowserDetector\Loader\DeviceLoaderFactory;
use BrowserDetector\Parser\CascadedParserTrait;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\Json;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;

final class DesktopParser implements DeviceParserInterface
{
    /**
     * @var \BrowserDetector\Loader\DeviceLoaderFactory
     */
    private $loaderFactory;

    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    private const GENERIC_FILE = '/../../../data/factories/devices/desktop.json';
    private const SPECIFIC_FILE = '/../../../data/factories/devices/desktop/%s.json';

    /**
     * @param \Psr\Log\LoggerInterface                        $logger
     * @param \JsonClass\JsonInterface                                 $jsonParser
     * @param \BrowserDetector\Parser\PlatformParserInterface $platformParser
     */
    public function __construct(LoggerInterface $logger, JsonInterface $jsonParser, PlatformParserInterface $platformParser)
    {
        $this->loaderFactory = new DeviceLoaderFactory($logger, $jsonParser, $platformParser);
        $this->jsonParser    = $jsonParser;
    }

    use CascadedParserTrait;

    /**
     * @param string $company
     * @param string $key
     * @param string $useragent
     *
     * @return array
     */
    public function load(string $company, string $key, string $useragent = ''): array
    {
        $loaderFactory = $this->loaderFactory;

        /** @var \BrowserDetector\Loader\DeviceLoader $loader */
        $loader = $loaderFactory($company);

        return $loader($key, $useragent);
    }
}
