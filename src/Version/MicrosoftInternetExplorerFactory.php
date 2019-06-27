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

final class MicrosoftInternetExplorerFactory implements MicrosoftInternetExplorerFactoryInterface
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \BrowserDetector\Version\MicrosoftInternetExplorer
     */
    public function __invoke(LoggerInterface $logger): MicrosoftInternetExplorer
    {
        $versionFactory = new VersionFactory();

        return new MicrosoftInternetExplorer(
            $logger,
            $versionFactory,
            new Trident($logger, $versionFactory)
        );
    }
}
