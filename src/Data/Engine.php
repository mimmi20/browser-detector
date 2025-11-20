<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Data;

use BrowserDetector\Version\GeckoFactory;
use BrowserDetector\Version\GoannaFactory;
use BrowserDetector\Version\TridentFactory;
use BrowserDetector\Version\VersionBuilderFactory;
use Override;
use UnexpectedValueException;

use function mb_strtolower;
use function sprintf;

enum Engine: string implements EngineInterface
{
    case unknown = 'unknown';

    case blackberry = 'black-berry';

    case blink = 'Blink';

    case clecko = 'Clecko';

    case edge = 'Edge';

    case gecko = 'Gecko';

    case webkit = 'WebKit';

    case trident = 'Trident';

    case khtml = 'KHTML';

    case netfront = 'NetFront';

    case presto = 'Presto';

    case servo = 'Servo';

    case t5 = 'T5';

    case t7 = 'T7';

    case tasman = 'Tasman';

    case u2 = 'U2';

    case u3 = 'U3';

    case u4 = 'U4';

    case elektra = 'Elektra';

    case goanna = 'Goanna';

    case teleca = 'Teleca';

    case treco = 'Treco';

    /**
     * @throws UnexpectedValueException
     *
     * @api
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function fromName(string $name): self
    {
        // the last one
        return match (mb_strtolower($name)) {
            'unknown', '' => self::unknown,
            'black-berry', 'blackberry' => self::blackberry,
            'blink' => self::blink,
            'clecko' => self::clecko,
            'edge' => self::edge,
            'gecko' => self::gecko,
            'webkit' => self::webkit,
            'trident' => self::trident,
            'khtml' => self::khtml,
            'netfront' => self::netfront,
            'presto' => self::presto,
            'servo' => self::servo,
            't5' => self::t5,
            't7' => self::t7,
            'tasman' => self::tasman,
            'u2' => self::u2,
            'u3' => self::u3,
            'u4' => self::u4,
            'elektra' => self::elektra,
            'goanna' => self::goanna,
            'teleca' => self::teleca,
            'treco' => self::treco,
            default => throw new UnexpectedValueException(
                sprintf('the engine "%s" is unknown', $name),
            ),
        };
    }

    /** @throws void */
    #[Override]
    public function getName(): string | null
    {
        return match ($this) {
            self::unknown => null,
            default => $this->value,
        };
    }

    /** @throws void */
    #[Override]
    public function getManufacturer(): Company
    {
        return match ($this) {
            self::blackberry => Company::rim,
            self::blink => Company::google,
            self::edge, self::trident => Company::microsoft,
            self::gecko, self::servo => Company::mozilla,
            self::webkit, self::tasman => Company::apple,
            self::netfront => Company::access,
            self::presto => Company::opera,
            self::t5, self::t7 => Company::baidu,
            self::u2, self::u3, self::u4 => Company::ucweb,
            self::goanna => Company::moonchild,
            self::teleca => Company::obigo,
            self::treco => Company::arsslensoft,
            default => Company::unknown,
        };
    }

    /**
     * @return array{factory: class-string|null, search: array<int, string>|null, value?: float|int|string}
     *
     * @throws void
     */
    #[Override]
    public function getVersion(): array
    {
        return match ($this) {
            self::blink => ['factory' => VersionBuilderFactory::class, 'search' => ['Chrome', 'Cronet']],
            self::clecko, self::treco => ['factory' => VersionBuilderFactory::class, 'search' => ['rv:']],
            self::edge => ['factory' => VersionBuilderFactory::class, 'search' => ['Edge']],
            self::webkit => ['factory' => VersionBuilderFactory::class, 'search' => ['AppleWebKit', 'WebKit', 'CFNetwork', 'Browser\\/AppleWebKit']],
            self::khtml => ['factory' => VersionBuilderFactory::class, 'search' => ['KHTML']],
            self::presto => ['factory' => VersionBuilderFactory::class, 'search' => ['Presto']],
            self::servo => ['factory' => VersionBuilderFactory::class, 'search' => ['Servo']],
            self::t5 => ['factory' => VersionBuilderFactory::class, 'search' => ['T5']],
            self::t7 => ['factory' => VersionBuilderFactory::class, 'search' => ['T7']],
            self::u2 => ['factory' => VersionBuilderFactory::class, 'search' => ['U2']],
            self::u3 => ['factory' => VersionBuilderFactory::class, 'search' => ['U3']],
            self::u4 => ['factory' => VersionBuilderFactory::class, 'search' => ['U4']],
            self::gecko => ['factory' => GeckoFactory::class, 'search' => null],
            self::trident => ['factory' => TridentFactory::class, 'search' => null],
            self::goanna => ['factory' => GoannaFactory::class, 'search' => null],
            default => ['factory' => null, 'search' => null],
        };
    }

    /** @throws void */
    #[Override]
    public function getKey(): string
    {
        return $this->name;
    }
}
