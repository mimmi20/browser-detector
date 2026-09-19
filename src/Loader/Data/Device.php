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

use BrowserDetector\Iterator\FilterIterator;
use BrowserDetector\Loader\InitData\Device as DataDevice;
use Exception;
use Override;
use Psr\Log\LoggerInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use UaDeviceType\Type;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;
use UnexpectedValueException;

use function array_key_exists;
use function assert;
use function get_debug_type;
use function is_array;
use function is_bool;
use function is_float;
use function is_int;
use function is_string;
use function sprintf;
use function str_replace;

final class Device implements DataInterface
{
    private const string DATA_PATH = __DIR__ . '/../../../data/devices/';

    /** @var array<string, DataDevice> */
    private array $items      = [];
    private bool $initialized = false;

    /** @throws void */
    public function __construct(private readonly string $company, private readonly LoggerInterface $logger)
    {
        // nothing to do
    }

    /**
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[Override]
    public function init(): void
    {
        if ($this->initialized) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(self::DATA_PATH . $this->company),
        );
        $files    = new FilterIterator($iterator, 'yaml');

        foreach ($files as $file) {
            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            $fileData = null;

            try {
                $fileData = Yaml::parseFile(
                    $filepath,
                    Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE | Yaml::PARSE_EXCEPTION_ON_ALIAS,
                );
            } catch (ParseException $e) {
                $this->logger->error(
                    new Exception(
                        sprintf('    could not parse file %s', $filepath),
                        0,
                        $e,
                    ),
                );

                continue;
            }

            if (!is_array($fileData)) {
                $this->logger->error(
                    new Exception(
                        sprintf('    could not parse file %s', $filepath),
                    ),
                );

                continue;
            }

            if ($fileData === []) {
                continue;
            }

            foreach ($fileData as $key => $data) {
                $stringKey = (string) $key;

                if (array_key_exists($stringKey, $this->items)) {
                    continue;
                }

                if (!is_array($data)) {
                    continue;
                }

                assert(
                    is_string($data['deviceName']) || $data['deviceName'] === null,
                    get_debug_type($data['deviceName']),
                );
                assert(
                    is_string($data['marketingName']) || $data['marketingName'] === null,
                    get_debug_type($data['marketingName']),
                );
                assert(
                    is_string($data['manufacturer']) || $data['manufacturer'] === null,
                    get_debug_type($data['manufacturer']),
                );
                assert(
                    is_string($data['brand']) || $data['brand'] === null,
                    get_debug_type($data['brand']),
                );
                assert(
                    is_string($data['type']) || $data['type'] === null,
                    get_debug_type($data['type']),
                );
                assert(is_array($data['display']), get_debug_type($data['display']));
                assert(
                    is_int($data['display']['width']) || $data['display']['width'] === null,
                    get_debug_type($data['display']['width']),
                );
                assert(
                    is_int($data['display']['height']) || $data['display']['height'] === null,
                    get_debug_type($data['display']['height']),
                );
                assert(is_bool($data['display']['touch']), get_debug_type($data['display']['touch']));
                assert(
                    is_float($data['display']['size']) || is_int(
                        $data['display']['size'],
                    ) || $data['display']['size'] === null,
                    get_debug_type($data['display']['size']),
                );
                assert(
                    is_bool($data['dualOrientation']) || $data['dualOrientation'] === null,
                    get_debug_type($data['dualOrientation']),
                );
                assert(
                    is_int($data['simCount']) || $data['simCount'] === null,
                    get_debug_type($data['simCount']),
                );
                assert(
                    is_string($data['platform']) || $data['platform'] === null,
                    get_debug_type($data['platform']),
                );

                $dataArchitecture = array_key_exists('architecture', $data)
                    && is_string($data['architecture'])
                    ? $data['architecture']
                    : null;

                $dataBits = array_key_exists('bits', $data) && is_int($data['bits'])
                    ? $data['bits']
                    : null;

                $this->items[$stringKey] = new DataDevice(
                    architecture: Architecture::from($dataArchitecture ?? ''),
                    deviceName: $data['deviceName'],
                    marketingName: $data['marketingName'],
                    manufacturer: $data['manufacturer'],
                    brand: $data['brand'],
                    type: Type::from($data['type'] ?? ''),
                    display: $data['display'],
                    dualOrientation: $data['dualOrientation'],
                    simCount: $data['simCount'],
                    bits: Bits::from($dataBits ?? 0),
                    platform: $data['platform'],
                );
            }
        }

        $this->initialized = true;
    }

    /** @throws void */
    #[Override]
    public function getItem(string $stringKey): DataDevice | null
    {
        return $this->items[$stringKey] ?? null;
    }
}
