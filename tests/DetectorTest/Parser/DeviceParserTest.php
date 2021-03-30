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

namespace BrowserDetectorTest\Parser;

use BrowserDetector\Helper\DesktopInterface;
use BrowserDetector\Helper\MobileDeviceInterface;
use BrowserDetector\Helper\TvInterface;
use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Loader\DeviceLoaderInterface;
use BrowserDetector\Parser\Device\DarwinParserInterface;
use BrowserDetector\Parser\Device\DesktopParserInterface;
use BrowserDetector\Parser\Device\MobileParserInterface;
use BrowserDetector\Parser\Device\TvParserInterface;
use BrowserDetector\Parser\DeviceParser;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UaDeviceType\TypeInterface;
use UaResult\Company\CompanyInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Device\DisplayInterface;
use UnexpectedValueException;

use function assert;

final class DeviceParserTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testInvokeUnknown(): void
    {
        $company   = 'unknown';
        $key       = 'unknown';
        $useragent = '<device-test>';

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::once())
            ->method('load')
            ->with($key, $useragent)
            ->willReturn($expectedResult);

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($company)
            ->willReturn($loader);

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::never())
            ->method('isMobile');

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::never())
            ->method('isTvDevice');

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        assert($darwinParser instanceof DarwinParserInterface);
        assert($mobileParser instanceof MobileParserInterface);
        assert($tvParser instanceof TvParserInterface);
        assert($desktopParser instanceof DesktopParserInterface);
        assert($loaderFactory instanceof DeviceLoaderFactoryInterface);
        assert($mobileDevice instanceof MobileDeviceInterface);
        assert($tvDevice instanceof TvInterface);
        assert($desktopDevice instanceof DesktopInterface);
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($expectedResult, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testInvokeUnknown2(): void
    {
        $company   = 'unknown';
        $key       = 'unknown';
        $useragent = 'Mozilla/5.0 (compatible; Zollard; Linux)';

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::once())
            ->method('load')
            ->with($key, $useragent)
            ->willReturn($expectedResult);

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($company)
            ->willReturn($loader);

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::never())
            ->method('isMobile');

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::never())
            ->method('isTvDevice');

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        assert($darwinParser instanceof DarwinParserInterface);
        assert($mobileParser instanceof MobileParserInterface);
        assert($tvParser instanceof TvParserInterface);
        assert($desktopParser instanceof DesktopParserInterface);
        assert($loaderFactory instanceof DeviceLoaderFactoryInterface);
        assert($mobileDevice instanceof MobileDeviceInterface);
        assert($tvDevice instanceof TvInterface);
        assert($desktopDevice instanceof DesktopInterface);
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($expectedResult, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testInvokeDarwin(): void
    {
        $useragent = 'test-darwin';

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($expectedResult);

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::never())
            ->method('load');

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::never())
            ->method('__invoke');

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::never())
            ->method('isMobile');

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::never())
            ->method('isTvDevice');

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        assert($darwinParser instanceof DarwinParserInterface);
        assert($mobileParser instanceof MobileParserInterface);
        assert($tvParser instanceof TvParserInterface);
        assert($desktopParser instanceof DesktopParserInterface);
        assert($loaderFactory instanceof DeviceLoaderFactoryInterface);
        assert($mobileDevice instanceof MobileDeviceInterface);
        assert($tvDevice instanceof TvInterface);
        assert($desktopDevice instanceof DesktopInterface);
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($expectedResult, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testInvokeMobile(): void
    {
        $useragent = 'test-device';

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($expectedResult);

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::never())
            ->method('load');

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::never())
            ->method('__invoke');

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::once())
            ->method('isMobile')
            ->willReturn(true);

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::never())
            ->method('isTvDevice');

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        assert($darwinParser instanceof DarwinParserInterface);
        assert($mobileParser instanceof MobileParserInterface);
        assert($tvParser instanceof TvParserInterface);
        assert($desktopParser instanceof DesktopParserInterface);
        assert($loaderFactory instanceof DeviceLoaderFactoryInterface);
        assert($mobileDevice instanceof MobileDeviceInterface);
        assert($tvDevice instanceof TvInterface);
        assert($desktopDevice instanceof DesktopInterface);
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($expectedResult, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testInvokeTv(): void
    {
        $useragent = 'test-device';

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($expectedResult);

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::never())
            ->method('load');

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::never())
            ->method('__invoke');

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::once())
            ->method('isMobile')
            ->willReturn(false);

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::once())
            ->method('isTvDevice')
            ->willReturn(true);

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::never())
            ->method('isDesktopDevice');

        assert($darwinParser instanceof DarwinParserInterface);
        assert($mobileParser instanceof MobileParserInterface);
        assert($tvParser instanceof TvParserInterface);
        assert($desktopParser instanceof DesktopParserInterface);
        assert($loaderFactory instanceof DeviceLoaderFactoryInterface);
        assert($mobileDevice instanceof MobileDeviceInterface);
        assert($tvDevice instanceof TvInterface);
        assert($desktopDevice instanceof DesktopInterface);
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($expectedResult, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testInvokeDesktop(): void
    {
        $useragent = 'test-device';

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::once())
            ->method('parse')
            ->with($useragent)
            ->willReturn($expectedResult);

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::never())
            ->method('load');

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::never())
            ->method('__invoke');

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::once())
            ->method('isMobile')
            ->willReturn(false);

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::once())
            ->method('isTvDevice')
            ->willReturn(false);

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::once())
            ->method('isDesktopDevice')
            ->willReturn(true);

        assert($darwinParser instanceof DarwinParserInterface);
        assert($mobileParser instanceof MobileParserInterface);
        assert($tvParser instanceof TvParserInterface);
        assert($desktopParser instanceof DesktopParserInterface);
        assert($loaderFactory instanceof DeviceLoaderFactoryInterface);
        assert($mobileDevice instanceof MobileDeviceInterface);
        assert($tvDevice instanceof TvInterface);
        assert($desktopDevice instanceof DesktopInterface);
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($expectedResult, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testInvokeFallback(): void
    {
        $company   = 'unknown';
        $key       = 'unknown';
        $useragent = 'test-device';

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

        $darwinParser = $this->getMockBuilder(DarwinParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $darwinParser
            ->expects(self::never())
            ->method('parse');

        $mobileParser = $this->getMockBuilder(MobileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileParser
            ->expects(self::never())
            ->method('parse');

        $tvParser = $this->getMockBuilder(TvParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvParser
            ->expects(self::never())
            ->method('parse');

        $desktopParser = $this->getMockBuilder(DesktopParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopParser
            ->expects(self::never())
            ->method('parse');

        $loader = $this->getMockBuilder(DeviceLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::once())
            ->method('load')
            ->with($key, $useragent)
            ->willReturn($expectedResult);

        $loaderFactory = $this->getMockBuilder(DeviceLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($company)
            ->willReturn($loader);

        $mobileDevice = $this->getMockBuilder(MobileDeviceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mobileDevice
            ->expects(self::once())
            ->method('isMobile')
            ->willReturn(false);

        $tvDevice = $this->getMockBuilder(TvInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tvDevice
            ->expects(self::once())
            ->method('isTvDevice')
            ->willReturn(false);

        $desktopDevice = $this->getMockBuilder(DesktopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $desktopDevice
            ->expects(self::once())
            ->method('isDesktopDevice')
            ->willReturn(false);

        assert($darwinParser instanceof DarwinParserInterface);
        assert($mobileParser instanceof MobileParserInterface);
        assert($tvParser instanceof TvParserInterface);
        assert($desktopParser instanceof DesktopParserInterface);
        assert($loaderFactory instanceof DeviceLoaderFactoryInterface);
        assert($mobileDevice instanceof MobileDeviceInterface);
        assert($tvDevice instanceof TvInterface);
        assert($desktopDevice instanceof DesktopInterface);
        $object = new DeviceParser($darwinParser, $mobileParser, $tvParser, $desktopParser, $loaderFactory, $mobileDevice, $tvDevice, $desktopDevice);
        $result = $object->parse($useragent);

        self::assertSame($expectedResult, $result);
    }
}
