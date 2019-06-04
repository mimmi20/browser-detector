<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Parser;

use UaResult\Engine\EngineInterface;

interface EngineParserInterface
{
    /**
     * Gets the information about the engine by User Agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function parse(string $useragent): EngineInterface;

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function load(string $key, string $useragent = ''): EngineInterface;
}
