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
namespace BrowserDetector\Parser;

use BrowserDetector\Loader\EngineLoaderFactory;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;
use UaResult\Engine\EngineInterface;

final class EngineParser implements EngineParserInterface
{
    /**
     * @var \BrowserDetector\Loader\EngineLoaderFactory
     */
    private $loaderFactory;

    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    private const GENERIC_FILE = '/../../data/factories/engines.json';

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param \JsonClass\JsonInterface $jsonParser
     */
    public function __construct(LoggerInterface $logger, JsonInterface $jsonParser)
    {
        $this->loaderFactory = new EngineLoaderFactory($logger, $jsonParser);
        $this->jsonParser    = $jsonParser;
    }

    /**
     * Gets the information about the engine by User Agent
     *
     * @param string $useragent
     *
     * @throws \ExceptionalJSON\DecodeErrorException
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function __invoke(string $useragent): EngineInterface
    {
        $specFactories = $this->jsonParser->decode(
            (string) file_get_contents(__DIR__ . self::GENERIC_FILE),
            true
        );
        $key = $specFactories['generic'];

        foreach (array_keys($specFactories['rules']) as $rule) {
            if (preg_match($rule, $useragent)) {
                $key = $specFactories['rules'][$rule];
                break;
            }
        }

        return $this->load($key, $useragent);
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return EngineInterface
     */
    public function load(string $key, string $useragent = ''): EngineInterface
    {
        $loaderFactory = $this->loaderFactory;

        /** @var \BrowserDetector\Loader\EngineLoader $loader */
        $loader = $loaderFactory();

        return $loader($key, $useragent);
    }
}
