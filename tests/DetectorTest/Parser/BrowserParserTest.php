<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\BrowserLoaderFactoryInterface;
use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Parser\BrowserParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UaBrowserType\TypeInterface;
use UaResult\Browser\BrowserInterface;
use UaResult\Company\CompanyInterface;
use UnexpectedValueException;

use function assert;

final class BrowserParserTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testInvoke(): void
    {
        $useragent = 'test-agent';
        $mode      = 'test-mode';
        $key       = 'test-key';

        $expectedBrowser = new class() implements BrowserInterface {
            public function getName(): ?string
            {
                return null;
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

            public function getModus(): ?string
            {
                return null;
            }

            public function getVersion(): VersionInterface
            {
                return new class() implements VersionInterface {
                    /**
                     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                     */
                    public function getVersion(int $mode = self::COMPLETE): ?string
                    {
                        return null;
                    }

                    /**
                     * @return array<string, string|null>
                     */
                    public function toArray(): array
                    {
                        return [];
                    }

                    public function getMajor(): ?string
                    {
                        return null;
                    }

                    public function getMinor(): ?string
                    {
                        return null;
                    }

                    public function getMicro(): ?string
                    {
                        return null;
                    }

                    public function getPatch(): ?string
                    {
                        return null;
                    }

                    public function getMicropatch(): ?string
                    {
                        return null;
                    }

                    public function getBuild(): ?string
                    {
                        return null;
                    }

                    public function getStability(): ?string
                    {
                        return null;
                    }

                    public function isAlpha(): ?bool
                    {
                        return false;
                    }

                    public function isBeta(): ?bool
                    {
                        return false;
                    }
                };
            }

            public function getBits(): ?int
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

                    public function isBot(): bool
                    {
                        return false;
                    }

                    public function isSyndicationReader(): bool
                    {
                        return false;
                    }

                    public function isTranscoder(): bool
                    {
                        return false;
                    }
                };
            }

            /**
             * @return array<string, int|string|null>
             */
            public function toArray(): array
            {
                return [];
            }
        };

        $expectedResult = [$expectedBrowser];

        $loader = $this->getMockBuilder(BrowserLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loader
            ->expects(self::once())
            ->method('load')
            ->with($key, $useragent)
            ->willReturn($expectedResult);

        $loaderFactory = $this->getMockBuilder(BrowserLoaderFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->willReturn($loader);

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(self::exactly(2))
            ->method('parseFile')
            ->willReturnOnConsecutiveCalls($mode, $key);

        assert($loaderFactory instanceof BrowserLoaderFactoryInterface);
        assert($fileParser instanceof RulefileParserInterface);
        $parser       = new BrowserParser($loaderFactory, $fileParser);
        $parserResult = $parser->parse($useragent);

        self::assertSame($expectedResult, $parserResult);
    }
}
