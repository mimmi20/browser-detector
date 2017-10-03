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
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
trait DeviceTestDetectTrait
{
    /**
     * @dataProvider providerDetect
     *
     * @param string      $agent
     * @param string|null $deviceName
     * @param string|null $marketingName
     * @param string|null $manufacturer
     * @param string|null $brand
     * @param string|null $deviceType
     * @param bool|null   $dualOrientation
     * @param string|null $pointingMethod
     * @param int|null    $width
     * @param int|null    $height
     * @param int|null    $colors
     *
     * @return void
     */
    public function testDetect(string $agent, ?string $deviceName, ?string $marketingName, ? string $manufacturer, ?string $brand, ?string $deviceType, ?bool $dualOrientation, ?string $pointingMethod, ?int $width, ?int $height, ?int $colors): void
    {
        $s = new Stringy($agent);

        /* @var \UaResult\Device\DeviceInterface $result */
        [$result] = $this->object->detect($agent, $s);

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

        if ($result->getType()->isDesktop() || $result->getType()->isTv()) {
            self::assertFalse(
                $result->getDualOrientation(),
                'Expected dual orientation to be "false" (was "' . $result->getDualOrientation() . '")'
            );

            self::assertSame(
                $dualOrientation,
                $result->getDualOrientation(),
                'Expected dual orientation to be "' . $dualOrientation . '" (was "' . $result->getDualOrientation() . '")'
            );
        } else {
            self::assertSame(
                $dualOrientation,
                $result->getDualOrientation(),
                'Expected dual orientation to be "' . $dualOrientation . '" (was "' . $result->getDualOrientation() . '")'
            );
        }

        if ($result->getType()->isDesktop()) {
            self::assertSame(
                'mouse',
                $result->getPointingMethod(),
                'Expected pointing method to be "mouse" (was "' . $result->getPointingMethod() . '")'
            );

            self::assertSame(
                $pointingMethod,
                $result->getPointingMethod(),
                'Expected pointing method to be "' . $pointingMethod . '" (was "' . $result->getPointingMethod() . '")'
            );
        } elseif ($result->getType()->isTv()) {
            self::assertNull(
                $result->getPointingMethod(),
                'Expected pointing method to be "null" (was "' . $result->getPointingMethod() . '")'
            );

            self::assertSame(
                $pointingMethod,
                $result->getPointingMethod(),
                'Expected pointing method to be "' . $pointingMethod . '" (was "' . $result->getPointingMethod() . '")'
            );
        } elseif (in_array($result->getType()->getName(), ['Tablet', 'FonePad', 'Smartphone'])) {
            self::assertSame(
                'touchscreen',
                $result->getPointingMethod(),
                'Expected pointing method to be "mouse" (was "' . $result->getPointingMethod() . '")'
            );

            self::assertSame(
                $pointingMethod,
                $result->getPointingMethod(),
                'Expected pointing method to be "' . $pointingMethod . '" (was "' . $result->getPointingMethod() . '")'
            );
        } else {
            self::assertSame(
                $pointingMethod,
                $result->getPointingMethod(),
                'Expected pointing method to be "' . $pointingMethod . '" (was "' . $result->getPointingMethod() . '")'
            );
        }

        if ($result->getType()->isDesktop() || $result->getType()->isTv() || false !== mb_stripos((string) $result->getDeviceName(), 'general')) {
            self::assertNull(
                $result->getResolutionWidth(),
                'Expected display width to be "null" for general or desktop/tv devices (was "' . $result->getResolutionWidth() . '")'
            );

            self::assertSame(
                $width,
                $result->getResolutionWidth(),
                'Expected display width to be "' . $width . '" (was "' . $result->getResolutionWidth() . '")'
            );
        } elseif (null !== $width) {
            self::assertSame(
                $width,
                $result->getResolutionWidth(),
                'Expected display width to be "' . $width . '" (was "' . $result->getResolutionWidth() . '")'
            );
        }

        if ($result->getType()->isDesktop() || $result->getType()->isTv() || false !== mb_stripos((string) $result->getDeviceName(), 'general')) {
            self::assertNull(
                $result->getResolutionHeight(),
                'Expected display height to be "null" for general or desktop/tv devices (was "' . $result->getResolutionHeight() . '")'
            );

            self::assertSame(
                $height,
                $result->getResolutionHeight(),
                'Expected display height to be "' . $height . '" (was "' . $result->getResolutionHeight() . '")'
            );
        } elseif (null !== $height) {
            self::assertSame(
                $height,
                $result->getResolutionHeight(),
                'Expected display height to be "' . $height . '" (was "' . $result->getResolutionHeight() . '")'
            );
        }
    }
}
