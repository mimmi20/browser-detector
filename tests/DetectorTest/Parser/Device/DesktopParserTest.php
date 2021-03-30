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

namespace BrowserDetectorTest\Parser\Device;

use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Loader\DeviceLoaderInterface;
use BrowserDetector\Parser\Device\DesktopParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UaDeviceType\TypeInterface;
use UaResult\Company\CompanyInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Device\DisplayInterface;
use UnexpectedValueException;

use function assert;

final class DesktopParserTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testInvoke(): void
    {
        $useragent    = 'test-useragent';
        $expectedMode = 'test-mode';

        $expectedDevice = new class() implements DeviceInterface {
            public function getDeviceName(): ?string
            {
                return null;
            }

            public function getBrand(): CompanyInterface
            {
                return new class() implements CompanyInterface {
                    public function getType(): string
                    {
                        return '';
                    }

                    public function getName(): ?string
                    {
                        return null;
                    }

                    public function getBrandName(): ?string
                    {
                        return null;
                    }
                };
            }

            public function getManufacturer(): CompanyInterface
            {
                return new class() implements CompanyInterface {
                    public function getType(): string
                    {
                        return '';
                    }

                    public function getName(): ?string
                    {
                        return null;
                    }

                    public function getBrandName(): ?string
                    {
                        return null;
                    }
                };
            }

            public function getMarketingName(): ?string
            {
                return null;
            }

            public function getDisplay(): ?DisplayInterface
            {
                return null;
            }

            public function getType(): TypeInterface
            {
                return new class() implements TypeInterface {
                    public function getType(): string
                    {
                        return '';
                    }

                    public function getName(): ?string
                    {
                        return null;
                    }

                    public function isMobile(): bool
                    {
                        return false;
                    }

                    public function isDesktop(): bool
                    {
                        return false;
                    }

                    public function isConsole(): bool
                    {
                        return false;
                    }

                    public function isTv(): bool
                    {
                        return false;
                    }

                    public function isPhone(): bool
                    {
                        return false;
                    }

                    public function isTablet(): bool
                    {
                        return false;
                    }

                    public function getDescription(): string
                    {
                        return '';
                    }
                };
            }

            /**
             * @return array<string, array<string, bool|float|int>|string|null>
             */
            public function toArray(): array
            {
                return [];
            }
        };

        $expectedResult = [$expectedDevice];
        $genericMode    = 'genericMode';

        $mockLoader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoader
            ->expects(self::once())
            ->method('load')
            ->with($expectedMode, $useragent)
            ->willReturn($expectedResult);

        $mockLoaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($genericMode)
            ->willReturn($mockLoader);

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(self::exactly(2))
            ->method('parseFile')
            ->willReturnOnConsecutiveCalls($genericMode, $expectedMode);

        assert($fileParser instanceof RulefileParserInterface);
        assert($mockLoaderFactory instanceof DeviceLoaderFactoryInterface);
        $object = new DesktopParser($fileParser, $mockLoaderFactory);

        self::assertSame($expectedResult, $object->parse($useragent));
    }
}
