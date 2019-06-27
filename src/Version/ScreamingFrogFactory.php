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
namespace BrowserDetector\Version;

use Psr\Log\LoggerInterface;

final class ScreamingFrogFactory implements ScreamingFrogFactoryInterface
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \BrowserDetector\Version\ScreamingFrog
     */
    public function __invoke(LoggerInterface $logger): ScreamingFrog
    {
        return new ScreamingFrog(
            $logger,
            new VersionFactory()
        );
    }
}
