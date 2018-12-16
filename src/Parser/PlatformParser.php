<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Parser;

use BrowserDetector\Helper;
use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\PlatformLoaderFactory;
use JsonClass\Json;
use JsonClass\JsonInterface;
use Psr\Log\LoggerInterface;
use Stringy\Stringy;
use UaResult\Os\OsInterface;

final class PlatformParser implements PlatformParserInterface
{
    /**
     * @var \BrowserDetector\Loader\PlatformLoaderFactory
     */
    private $loaderFactory;

    /**
     * @var \JsonClass\JsonInterface
     */
    private $jsonParser;

    private const GENERIC_FILE  = '/../../data/factories/platforms.json';
    private const SPECIFIC_FILE = '/../../data/factories/platforms/%s.json';

    /**
     * @param \Psr\Log\LoggerInterface              $logger
     * @param \JsonClass\JsonInterface              $jsonParser
     * @param \BrowserDetector\Loader\CompanyLoader $companyLoader
     */
    public function __construct(
        LoggerInterface $logger,
        JsonInterface $jsonParser,
        CompanyLoader $companyLoader
    ) {
        $this->loaderFactory = new PlatformLoaderFactory($logger, $jsonParser, $companyLoader);
        $this->jsonParser    = $jsonParser;
    }

    use CascadedParserTrait;

//    /**
//     * Gets the information about the platform by User Agent
//     *
//     * @param string $useragent
//     *
//     * @throws \ExceptionalJSON\DecodeErrorException
//     *
//     * @return \UaResult\Os\OsInterface
//     */
//    public function __invoke(string $useragent): OsInterface
//    {
//        $factories = $this->jsonParser->decode(
//            (string) file_get_contents(__DIR__ . '/../../data/factories/platforms.json'),
//            true
//        );
//        $mode      = $factories['generic'];
//
//        foreach (array_keys($factories['rules']) as $rule) {
//            if (preg_match($rule, $useragent)) {
//                $mode = $factories['rules'][$rule];
//                break;
//            }
//        }
//
//        $specFactories = $this->jsonParser->decode(
//            (string) file_get_contents(__DIR__ . sprintf('/../../data/factories/platforms/%s.json', $mode)),
//            true
//        );
//        $key           = $specFactories['generic'];
//
//        foreach (array_keys($specFactories['rules']) as $rule) {
//            if (preg_match($rule, $useragent)) {
//                $key = $specFactories['rules'][$rule];
//                break;
//            }
//        }
//
//        return $this->load($key, $useragent);

//        $s             = new Stringy($useragent);
//        $windowsHelper = new Helper\Windows($s);
//        $loaderFactory = $this->loaderFactory;
//
//        if ($windowsHelper->isMobileWindows()) {
//            $loader = $loaderFactory('windowsmobile');
//
//            return $loader($useragent);
//        }
//
//        if ($windowsHelper->isWindows()) {
//            $loader = $loaderFactory('windows');
//
//            return $loader($useragent);
//        }
//
//        if (preg_match('/MIUI/', $useragent)
//            || preg_match('/yunos|tizen/i', $useragent)
//            || (new Helper\AndroidOs($s))->isAndroid()
//        ) {
//            $loader = $loaderFactory('android');
//
//            return $loader($useragent);
//        }
//
//        if ((new Helper\Linux($s))->isLinux()) {
//            $loader = $loaderFactory('linux');
//
//            return $loader($useragent);
//        }
//
//        if ((new Helper\FirefoxOs($s))->isFirefoxOs()) {
//            $loader = $loaderFactory('firefoxos');
//
//            return $loader($useragent);
//        }
//
//        if ((new Helper\Ios($s))->isIos()) {
//            $loader = $loaderFactory('ios');
//
//            return $loader($useragent);
//        }
//
//        $loader = $loaderFactory('unknown');
//
//        return $loader($useragent);
//    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return OsInterface
     */
    public function load(string $key, string $useragent = ''): OsInterface
    {
        $loaderFactory = $this->loaderFactory;

        /** @var \BrowserDetector\Loader\PlatformLoader $loader */
        $loader = $loaderFactory();

        return $loader($key, $useragent);
    }
}
