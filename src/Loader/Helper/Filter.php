<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader\Helper;

use Iterator;
use RecursiveCallbackFilterIterator;
use RecursiveDirectoryIterator;
use RecursiveIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use UnexpectedValueException;

final class Filter implements FilterInterface
{
    /**
     * @return Iterator<SplFileInfo>
     *
     * @throws UnexpectedValueException
     */
    public function __invoke(string $path, string $extension): Iterator
    {
        $directory = new RecursiveDirectoryIterator($path);
        $filter    = new RecursiveCallbackFilterIterator(
            $directory,
            /**
             * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
            static function (SplFileInfo $current, $key, RecursiveIterator $iterator) use ($extension): bool {
                // Allow recursion
                if ($iterator->hasChildren()) {
                    return true;
                }

                // Skip hidden files and directories.
                if ('.' === $current->getFilename()[0]) {
                    return false;
                }

                return $current->getExtension() === $extension;
            }
        );

        return new RecursiveIteratorIterator($filter);
    }
}
