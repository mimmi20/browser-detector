<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader\Data;

use Override;
use UaLoader\Data\ClientDataInterface;
use UaResult\Browser\BrowserInterface;

final readonly class ClientData implements ClientDataInterface
{
    /** @throws void */
    public function __construct(private BrowserInterface $client, private string | null $engine)
    {
    }

    /** @throws void */
    #[Override]
    public function getClient(): BrowserInterface
    {
        return $this->client;
    }

    /** @throws void */
    #[Override]
    public function getEngine(): string | null
    {
        return $this->engine;
    }
}
