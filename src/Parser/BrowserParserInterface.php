<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser;

use BrowserDetector\Loader\NotFoundException;
use UaResult\Browser\BrowserInterface;
use UaResult\Engine\EngineInterface;
use UnexpectedValueException;

interface BrowserParserInterface
{
    /**
     * Gets the information about the browser by User Agent
     *
     * @return array<int, BrowserInterface|EngineInterface|null>
     * @phpstan-return array(0: BrowserInterface, 1: EngineInterface|null)
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function parse(string $useragent): array;

    /**
     * @return array<int, BrowserInterface|EngineInterface|null>
     * @phpstan-return array(0: BrowserInterface, 1: EngineInterface|null)
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function load(string $key, string $useragent = ''): array;
}
