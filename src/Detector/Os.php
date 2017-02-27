<?php


namespace BrowserDetector\Detector;

use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Factory\Regex\NoMatchException;
use BrowserDetector\Factory\RegexFactory;
use BrowserDetector\Loader\NotFoundException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

/**
 * Browser Detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Os
{
    /**
     * a cache object
     *
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    private $cache = null;

    /**
     * an logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger = null;

    /**
     * @var \BrowserDetector\Factory\RegexFactory
     */
    private $regexFactory = null;

    /**
     * @var \BrowserDetector\Factory\PlatformFactory
     */
    private $platformFactory = null;

    /**
     * sets the cache used to make the detection faster
     *
     * @param \Psr\Cache\CacheItemPoolInterface        $cache
     * @param \Psr\Log\LoggerInterface                 $logger
     * @param \BrowserDetector\Factory\RegexFactory    $regexFactory
     * @param \BrowserDetector\Factory\PlatformFactory $platformFactory
     */
    public function __construct(
        CacheItemPoolInterface $cache,
        LoggerInterface $logger,
        RegexFactory $regexFactory,
        PlatformFactory $platformFactory
    ) {
        $this->cache           = $cache;
        $this->logger          = $logger;
        $this->regexFactory    = $regexFactory;
        $this->platformFactory = $platformFactory;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $browserUa
     *
     * @return \UaResult\Os\OsInterface
     */
    public function detect($browserUa)
    {
        $this->logger->debug('platform not detected from the device');

        try {
            $platform = $this->regexFactory->getPlatform();
        } catch (NotFoundException $e) {
            $this->logger->info($e);
            $platform = null;
        } catch (NoMatchException $e) {
            $platform = null;
        } catch (\InvalidArgumentException $e) {
            $this->logger->error($e);
            $platform = null;
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $platform = null;
        }

        if (null === $platform || in_array($platform->getName(), [null, 'unknown'])) {
            $this->logger->debug('platform not detected from the device nor from regex');

            try {
                $platform = $this->platformFactory->detect($browserUa);
            } catch (NotFoundException $e) {
                $this->logger->info($e);
                $platform = new \UaResult\Os\Os(null, null);
            }
        }

        return $platform;
    }
}
