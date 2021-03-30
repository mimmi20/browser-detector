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

namespace BrowserDetector\Factory;

use Psr\Log\LoggerInterface;
use UaResult\Device\Display;
use UaResult\Device\DisplayInterface;

use function array_key_exists;
use function assert;
use function gettype;
use function is_bool;
use function is_float;
use function is_int;
use function sprintf;

final class DisplayFactory implements DisplayFactoryInterface
{
    /**
     * @param array<string, (int|bool|float|null)> $data
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function fromArray(LoggerInterface $logger, array $data): DisplayInterface
    {
        assert(array_key_exists('width', $data), '"width" property is required');
        assert(array_key_exists('height', $data), '"height" property is required');
        assert(array_key_exists('touch', $data), '"touch" property is required');
        assert(array_key_exists('size', $data), '"size" property is required');

        $width  = $data['width'];
        $height = $data['height'];
        $touch  = $data['touch'];
        $size   = $data['size'];

        assert(is_int($width) || null === $width);
        assert(is_int($height) || null === $height);
        assert(is_bool($touch) || null === $touch);
        assert(
            is_float($size) || is_int($size) || null === $size,
            sprintf('"size" property is expecting a float or null, but got %s', gettype($size))
        );

        if (null !== $size) {
            $size = (float) $size;
        }

        return new Display($width, $height, $touch, $size);
    }
}
