<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Factory;

use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Factory\Device\Desktop\AppleFactory
 */
trait DeviceTestDetectTrait
{
    /**
     * @dataProvider providerDetect
     *
     * @param string      $agent
     * @param string      $deviceName
     * @param string      $marketingName
     * @param string      $manufacturer
     * @param string      $brand
     * @param string      $deviceType
     * @param bool        $dualOrientation
     * @param string|null $pointingMethod
     * @param int|null    $width
     * @param int|null    $height
     * @param int|null    $colors
     */
    public function testDetect($agent, $deviceName, $marketingName, $manufacturer, $brand, $deviceType, $dualOrientation, $pointingMethod, $width, $height, $colors)
    {
        $s = new Stringy($agent);

        /** @var \UaResult\Device\DeviceInterface $result */
        list($result) = $this->object->detect($agent, $s);

        self::assertInstanceOf('\UaResult\Device\DeviceInterface', $result);

        self::assertSame(
            $deviceName,
            $result->getDeviceName(),
            'Expected device name to be "' . $deviceName . '" (was "' . $result->getDeviceName() . '")'
        );
        self::assertSame(
            $marketingName,
            $result->getMarketingName(),
            'Expected marketing name to be "' . $marketingName . '" (was "' . $result->getMarketingName() . '")'
        );
        self::assertSame(
            $manufacturer,
            $result->getManufacturer()->getName(),
            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer()->getName() . '")'
        );
        self::assertSame(
            $brand,
            $result->getBrand()->getBrandName(),
            'Expected brand name to be "' . $brand . '" (was "' . $result->getBrand()->getBrandName() . '")'
        );
        self::assertSame(
            $deviceType,
            $result->getType()->getName(),
            'Expected device type to be "' . $deviceType . '" (was "' . $result->getType()->getName() . '")'
        );
        self::assertSame(
            $dualOrientation,
            $result->getDualOrientation(),
            'Expected dual orientation to be "' . $dualOrientation . '" (was "' . $result->getDualOrientation() . '")'
        );
        self::assertSame(
            $pointingMethod,
            $result->getPointingMethod(),
            'Expected pointing method to be "' . $pointingMethod . '" (was "' . $result->getPointingMethod() . '")'
        );

        if (null !== $width) {
            self::assertSame(
                $width,
                $result->getResolutionWidth(),
                'Expected display width to be "' . $width . '" (was "' . $result->getResolutionWidth() . '")'
            );
        }

        if (null !== $height) {
            self::assertSame(
                $height,
                $result->getResolutionHeight(),
                'Expected display height to be "' . $height . '" (was "' . $result->getResolutionHeight() . '")'
            );
        }
        /*
        // @todo: add colors to result
        self::assertSame(
            $colors,
            $result->col(),
            'Expected pointing method to be "' . $colors . '" (was "' . $result->getPointingMethod() . '")'
        );
        /**/
    }
}
