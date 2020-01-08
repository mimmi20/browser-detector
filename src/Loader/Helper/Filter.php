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
namespace BrowserDetector\Loader\Helper;

final class Filter implements FilterInterface
{
    /**
     * @param string $path
     * @param string $extension
     *
     * @return \Iterator
     */
    public function __invoke(string $path, string $extension): \Iterator
    {
        $directory = new \RecursiveDirectoryIterator($path);
        $filter    = new \RecursiveCallbackFilterIterator(
            $directory,
            static function (\SplFileInfo $current, $key, \RecursiveIterator $iterator) use ($extension): bool {
                // Allow recursion
                if ($iterator->hasChildren()) {
                    return true;
                }

                // Skip hidden files and directories.
                if ('.' === $current->getFilename()[0]) {
                    return false;
                }

                if ($current->getExtension() !== $extension) {
                    return false;
                }

                return true;
            }
        );

        return new \RecursiveIteratorIterator($filter);
    }
}
