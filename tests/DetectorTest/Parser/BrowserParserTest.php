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

namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\BrowserLoaderFactoryInterface;
use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Parser\BrowserParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaBrowserType\TypeInterface;
use UaResult\Browser\BrowserInterface;
use UaResult\Company\CompanyInterface;
use UnexpectedValueException;

use function assert;

final class BrowserParserTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     */
    public function testInvoke(): void
    {
        $useragent = 'test-agent';
        $mode      = 'test-mode';
        $key       = 'test-key';

        $expectedBrowser = new class () implements BrowserInterface {
            /** @throws void */
            public function getName(): string | null
            {
                return null;
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
            public function getModus(): string | null
            {
                return null;
            }

            /** @throws void */
            public function getVersion(): VersionInterface
            {
                return new class () implements VersionInterface {
                    /**
                     * @throws void
                     *
                     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                     */
                    public function getVersion(int $mode = self::COMPLETE): string | null
                    {
                        return null;
                    }

                    /**
                     * @return array<string, string|null>
                     *
                     * @throws void
                     */
                    public function toArray(): array
                    {
                        return [];
                    }

                    /** @throws void */
                    public function getMajor(): string | null
                    {
                        return null;
                    }

                    /** @throws void */
                    public function getMinor(): string | null
                    {
                        return null;
                    }

                    /** @throws void */
                    public function getMicro(): string | null
                    {
                        return null;
                    }

                    /** @throws void */
                    public function getPatch(): string | null
                    {
                        return null;
                    }

                    /** @throws void */
                    public function getMicropatch(): string | null
                    {
                        return null;
                    }

                    /** @throws void */
                    public function getBuild(): string | null
                    {
                        return null;
                    }

                    /** @throws void */
                    public function getStability(): string | null
                    {
                        return null;
                    }

                    /** @throws void */
                    public function isAlpha(): bool | null
                    {
                        return false;
                    }

                    /** @throws void */
                    public function isBeta(): bool | null
                    {
                        return false;
                    }
                };
            }

            /** @throws void */
            public function getBits(): int | null
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
                    public function isBot(): bool
                    {
                        return false;
                    }

                    /** @throws void */
                    public function isSyndicationReader(): bool
                    {
                        return false;
                    }

                    /** @throws void */
                    public function isTranscoder(): bool
                    {
                        return false;
                    }
                };
            }

            /**
             * @return array<string, int|string|null>
             *
             * @throws void
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
            ->willReturn($mode, $key);

        assert($loaderFactory instanceof BrowserLoaderFactoryInterface);
        assert($fileParser instanceof RulefileParserInterface);
        $parser       = new BrowserParser($loaderFactory, $fileParser);
        $parserResult = $parser->parse($useragent);

        self::assertSame($expectedResult, $parserResult);
    }
}
