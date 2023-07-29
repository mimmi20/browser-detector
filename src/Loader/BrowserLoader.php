<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader;

use BrowserDetector\Bits\Browser;
use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use stdClass;
use UaBrowserType\TypeLoader;
use UaResult\Browser\BrowserInterface;
use UaResult\Engine\EngineInterface;
use UnexpectedValueException;

use function assert;

final class BrowserLoader implements BrowserLoaderInterface
{
    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly DataInterface $initData,
        private readonly CompanyLoaderInterface $companyLoader,
        private readonly EngineParserInterface $engineParser,
    ) {
        $initData();
    }

    /**
     * @return array<int, (BrowserInterface|EngineInterface|null)>
     * @phpstan-return array{0: BrowserInterface, 1: EngineInterface|null}
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $key, string $useragent = ''): array
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        $browserData = $this->initData->getItem($key);

        if ($browserData === null) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        assert($browserData instanceof stdClass);

        $browserData->bits  = (new Browser())->getBits($useragent);
        $browserData->modus = null;

        $engineKey = $browserData->engine;
        $engine    = null;

        if ($engineKey !== null) {
            try {
                $engine = $this->engineParser->load($engineKey, $useragent);
            } catch (UnexpectedValueException $e) {
                $this->logger->warning($e);
            }
        }

        $browser = (new BrowserFactory(
            $this->companyLoader,
            new VersionFactory(),
            new TypeLoader(),
            $this->logger,
        ))->fromArray((array) $browserData, $useragent);

        return [$browser, $engine];
    }
}
