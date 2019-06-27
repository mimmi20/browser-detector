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

final class FirefoxOsFactory implements FirefoxOsFactoryInterface
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \BrowserDetector\Version\FirefoxOs
     */
    public function __invoke(LoggerInterface $logger): FirefoxOs
    {
        return new FirefoxOs(
            $logger,
            new VersionFactory()
        );
    }
}
