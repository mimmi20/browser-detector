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

namespace BrowserDetector\Parser\Header;

use BrowserDetector\Iterator\FilterIterator;
use CallbackFilterIterator;
use JsonException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;
use UnexpectedValueException;

use function array_filter;
use function array_key_exists;
use function assert;
use function explode;
use function file_exists;
use function file_put_contents;
use function is_array;
use function is_string;
use function sprintf;
use function str_contains;
use function str_replace;

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
trait AutoUpdateDeviceDataTrait
{
    /** @throws void */
    private function saveToMappingJson(string $devicecode, string $code): void
    {
        if ($code === 'A369i' || $code === 'test-device-code') {
            return;
        }

        [$company, $singleDeviceCode] = explode('=', $code, 2);

        if ($company === '') {
            return;
        }

        $file = sprintf(__DIR__ . '/../../../data/device-mapping/%s.yaml', $company);

        $devicesFromMappingFile = [];

        if (file_exists($file)) {
            $devicesFromMappingFile = Yaml::parseFile($file);
        }

        if (!is_array($devicesFromMappingFile)) {
            $this->logger->debug(sprintf('Could not decode mapping file %s', $file));

            return;
        }

        if (array_key_exists($devicecode, $devicesFromMappingFile)) {
            $this->deleteFromFactories($company, $code, $singleDeviceCode);

            return;
        }

        $devicesFromMappingFile[$devicecode] = $code;

        file_put_contents(
            $file,
            Yaml::dump(
                $devicesFromMappingFile,
                4,
                2,
            ),
        );

        $this->deleteFromFactories($company, $code, $singleDeviceCode);
    }

    /** @throws void */
    private function deleteFromFactories(string $company, string $code, string $singleDeviceCode): void
    {
        try {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(__DIR__ . '/../../../data/factories'),
            );
        } catch (UnexpectedValueException) {
            $this->logger->debug('Could not find factories');

            return;
        }

        $this->logger->debug('start rewriting factories');

        $files = new FilterIterator($iterator, 'yaml');
        $files = new CallbackFilterIterator(
            $files,
            static fn (SplFileInfo $current): bool => str_contains(
                $current->getPathname(),
                $company,
            ),
        );

        foreach ($files as $file) {
            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            $this->logger->debug(sprintf('start rewriting factory %s', $filepath));
            $this->logger->debug(sprintf('Read factory file %s to remove code "%s"', $filepath, $code));

            $fileData = Yaml::parseFile($filepath);

            assert(is_array($fileData));

            $filteredRules = array_filter(
                is_array($fileData)
                && array_key_exists('rules', $fileData)
                && is_array($fileData['rules'])
                    ? $fileData['rules']
                    : [],
                static fn (mixed $v): bool => is_string($v) && $v !== $singleDeviceCode,
            );

            $newFileData = [
                'rules' => $filteredRules,
                'generic' => $fileData['generic'],
            ];

            try {
                file_put_contents(
                    $filepath,
                    Yaml::dump($newFileData, 4, 2),
                );
                $this->logger->debug(sprintf('Encoded and rewrote factory file %s', $filepath));
            } catch (JsonException) {
                $this->logger->debug(
                    sprintf('<error>Could not encode or rewrite factory file %s</error>', $filepath),
                );
            }

            $this->logger->debug(
                sprintf('finished rewriting factory %s to remove code "%s"', $filepath, $code),
            );
        }

        $this->logger->debug('finished rewriting factories');
    }
}
