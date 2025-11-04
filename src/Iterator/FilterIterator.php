<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Iterator;

use Iterator;
use Override;
use SplFileInfo;

use function assert;

/** @phpstan-extends \FilterIterator<int|string, SplFileInfo, Iterator<SplFileInfo>> */
final class FilterIterator extends \FilterIterator
{
    /**
     * @param Iterator<SplFileInfo> $iterator
     *
     * @throws void
     */
    public function __construct(Iterator $iterator, private readonly string $extension)
    {
        parent::__construct($iterator);
    }

    /** @throws void */
    #[Override]
    public function accept(): bool
    {
        $file = $this->getInnerIterator()->current();

        assert($file instanceof SplFileInfo);

        return $file->isFile() && $file->getExtension() === $this->extension;
    }
}
