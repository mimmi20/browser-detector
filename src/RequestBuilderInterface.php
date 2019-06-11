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
namespace BrowserDetector;

use Psr\Log\LoggerInterface;
use UaRequest\GenericRequest;

interface RequestBuilderInterface
{
    /**
     * @param \Psr\Log\LoggerInterface                                                  $logger
     * @param array|\Psr\Http\Message\MessageInterface|string|\UaRequest\GenericRequest $request
     *
     * @throws \UnexpectedValueException
     *
     * @return \UaRequest\GenericRequest
     */
    public function buildRequest(LoggerInterface $logger, $request): GenericRequest;
}
