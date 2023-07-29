<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Parser\Device;

use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Loader\DeviceLoaderInterface;
use BrowserDetector\Parser\Device\MobileParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaDeviceType\TypeInterface;
use UaResult\Company\CompanyInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Device\DisplayInterface;
use UnexpectedValueException;

use function assert;

final class MobileParserTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testInvoke(): void
    {
        $useragent    = 'test-useragent';
        $expectedMode = 'test-mode';

        $expectedDevice = new class () implements DeviceInterface {
            /** @throws void */
            public function getDeviceName(): string | null
            {
                return null;
            }

            /** @throws void */
            public function getBrand(): CompanyInterface
            {
                return new class () implements CompanyInterface {
                    /** @throws void */
                    public function getType(): string
                    {
                        return '';
                    }

                    /** @throws void */
                    public function getName(): string | null
                    {
                        return null;
                    }

                    /** @throws void */
                    public function getBrandName(): string | null
                    {
                        return null;
                    }
                };
            }

            /** @throws void */
            public function getManufacturer(): CompanyInterface
            {
                return new class () implements CompanyInterface {
                    /** @throws void */
                    public function getType(): string
                    {
                        return '';
                    }

                    /** @throws void */
                    public function getName(): string | null
                    {
                        return null;
                    }

                    /** @throws void */
                    public function getBrandName(): string | null
                    {
                        return null;
                    }
                };
            }

            /** @throws void */
            public function getMarketingName(): string | null
            {
                return null;
            }

            /** @throws void */
            public function getDisplay(): DisplayInterface | null
            {
                return null;
            }

            /** @throws void */
            public function getType(): TypeInterface
            {
                return new class () implements TypeInterface {
                    /** @throws void */
                    public function getType(): string
                    {
                        return '';
                    }

                    /** @throws void */
                    public function getName(): string | null
                    {
                        return null;
                    }

                    /** @throws void */
                    public function isMobile(): bool
                    {
                        return false;
                    }

                    /** @throws void */
                    public function isDesktop(): bool
                    {
                        return false;
                    }

                    /** @throws void */
                    public function isConsole(): bool
                    {
                        return false;
                    }

                    /** @throws void */
                    public function isTv(): bool
                    {
                        return false;
                    }

                    /** @throws void */
                    public function isPhone(): bool
                    {
                        return false;
                    }

                    /** @throws void */
                    public function isTablet(): bool
                    {
                        return false;
                    }

                    /** @throws void */
                    public function getDescription(): string
                    {
                        return '';
                    }
                };
            }

            /**
             * @return array<string, array<string, bool|float|int>|string|null>
             *
             * @throws void
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
        $object = new MobileParser($fileParser, $mockLoaderFactory);

        self::assertSame($expectedResult, $object->parse($useragent));
    }
}
