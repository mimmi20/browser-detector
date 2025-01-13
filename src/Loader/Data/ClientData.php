<?php

declare(strict_types = 1);

namespace BrowserDetector\Loader\Data;

use UaLoader\Data\ClientDataInterface;
use UaResult\Browser\BrowserInterface;

class ClientData implements ClientDataInterface
{
    private BrowserInterface $client;
    private string|null $engine;

    /**
     * @param BrowserInterface $client
     * @param string|null $engine
     * @throws void
     */
    public function __construct(BrowserInterface $client, ?string $engine)
    {
        $this->client = $client;
        $this->engine = $engine;
    }

    /**
     * @return BrowserInterface
     * @throws void
     */
    public function getClient(): BrowserInterface
    {
        return $this->client;
    }

    /**
     * @return string|null
     * @throws void
     */
    public function getEngine(): string|null
    {
        return $this->engine;
    }

}