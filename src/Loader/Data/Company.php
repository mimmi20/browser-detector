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

use Exception;
use Override;
use Psr\Log\LoggerInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

use function array_key_exists;
use function assert;
use function get_debug_type;
use function is_array;
use function is_string;
use function sprintf;

final class Company implements DataInterface
{
    private const string DATA_PATH = __DIR__ . '/../../../data/companies/companies.yaml';

    /** @var array<string, \UaResult\Company\Company> */
    private array $items      = [];
    private bool $initialized = false;

    /** @throws void */
    public function __construct(private readonly LoggerInterface $logger)
    {
        // nothing to do
    }

    /** @throws void */
    #[Override]
    public function init(): void
    {
        if ($this->initialized) {
            return;
        }

        try {
            $fileData = Yaml::parseFile(self::DATA_PATH);
        } catch (ParseException $e) {
            $this->logger->error(
                new Exception(
                    sprintf('could not parse file %s', self::DATA_PATH),
                    0,
                    $e,
                ),
            );

            return;
        }

        if (!is_array($fileData)) {
            return;
        }

        foreach ($fileData as $key => $data) {
            $stringKey = (string) $key;

            if (array_key_exists($stringKey, $this->items) || !is_array($data)) {
                continue;
            }

            assert(
                is_string($data['name']) || $data['name'] === null,
                get_debug_type($data['name']),
            );
            assert(
                is_string($data['brandname']) || $data['brandname'] === null,
                get_debug_type($data['brandname']),
            );

            $this->items[$stringKey] = new \UaResult\Company\Company(
                type: $stringKey,
                name: $data['name'],
                brandname: $data['brandname'],
            );
        }

        $this->initialized = true;
    }

    /** @throws void */
    #[Override]
    public function getItem(string $stringKey): \UaResult\Company\Company | null
    {
        if (array_key_exists($stringKey, $this->items)) {
            return $this->items[$stringKey];
        }

        return null;
    }
}
