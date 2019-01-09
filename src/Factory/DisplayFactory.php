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
namespace BrowserDetector\Factory;

use BrowserDetector\Loader\NotFoundException;
use Psr\Log\LoggerInterface;
use UaDisplaySize\TypeLoaderInterface;
use UaDisplaySize\Unknown;
use UaResult\Device\Display;
use UaResult\Device\DisplayInterface;

final class DisplayFactory implements DisplayFactoryInterface
{
    /**
     * @var TypeLoaderInterface
     */
    private $typeLoader;

    /**
     * DisplayFactory constructor.
     *
     * @param \UaDisplaySize\TypeLoaderInterface $typeLoader
     */
    public function __construct(TypeLoaderInterface $typeLoader)
    {
        $this->typeLoader = $typeLoader;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Device\DisplayInterface
     */
    public function fromArray(LoggerInterface $logger, array $data): DisplayInterface
    {
        $width  = array_key_exists('width', $data) ? $data['width'] : null;
        $height = array_key_exists('height', $data) ? $data['height'] : null;
        $touch  = array_key_exists('touch', $data) ? $data['touch'] : null;
        $size   = array_key_exists('size', $data) ? $data['size'] : null;

        try {
            $type = $this->typeLoader->loadByDiemsions($height, $width);
        } catch (NotFoundException $e) {
            $logger->info($e);

            $type = new Unknown();
        }

        return new Display($touch, $type, $size);
    }
}
