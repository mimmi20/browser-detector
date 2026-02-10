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
use BrowserDetector\Loader\InitData\Engine as DataEngine;
use Laminas\Hydrator\Strategy\StrategyInterface;
use Override;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use SplFileInfo;
use UnexpectedValueException;

use function array_key_exists;
use function assert;
use function file_get_contents;
use function is_array;
use function is_string;
use function sprintf;
use function str_replace;

/** @deprecated will be removed */
final class Engine implements DataInterface
{
    private const string DATA_PATH = __DIR__ . '/../../../data/engines';

    /** @var array<string, DataEngine> */
    private array $items      = [];
    private bool $initialized = false;

    /** @throws void */
    public function __construct(private readonly StrategyInterface $strategy)
    {
        // nothing to do
    }

    /** @throws RuntimeException */
    #[Override]
    public function init(): void
    {
        if ($this->initialized) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(self::DATA_PATH));
        $files    = new FilterIterator($iterator, 'json');

        foreach ($files as $file) {
            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            $content = @file_get_contents($filepath);

            assert($content === false || is_string($content));

            if ($content === false) {
                throw new RuntimeException(sprintf('could not read file "%s"', $file));
            }

            $fileData = $this->strategy->hydrate($content, []);

            assert(is_array($fileData));

            foreach ($fileData as $key => $data) {
                $stringKey = (string) $key;

                if (array_key_exists($stringKey, $this->items) || !$data instanceof DataEngine) {
                    continue;
                }

                $this->items[$stringKey] = $data;
            }
        }

        $this->initialized = true;
    }

    /** @throws void */
    #[Override]
    public function getItem(string $stringKey): DataEngine | null
    {
        if (array_key_exists($stringKey, $this->items)) {
            return $this->items[$stringKey];
        }

        try {
            $engine = \BrowserDetector\Data\Engine::fromName($stringKey);

            $data = new DataEngine(
                name: $engine->getName(),
                manufacturer: $engine->getManufacturer()->getBrandname(),
                version: (object) $engine->getVersion(),
            );

            $this->items[$stringKey] = $data;
        } catch (UnexpectedValueException) {
            // do nothing
        }

        return $this->items[$stringKey] ?? null;
    }
}
