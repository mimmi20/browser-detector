<?php


namespace BrowserDetector\Detector;

use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Factory\Regex\NoMatchException;
use BrowserDetector\Factory\RegexFactory;
use BrowserDetector\Loader\NotFoundException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use UaResult\Os\Os;

/**
 * Browser Detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Device
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
     * @var \BrowserDetector\Factory\DeviceFactory
     */
    private $deviceFactory = null;

    /**
     * sets the cache used to make the detection faster
     *
     * @param \Psr\Cache\CacheItemPoolInterface      $cache
     * @param \Psr\Log\LoggerInterface               $logger
     * @param \BrowserDetector\Factory\RegexFactory  $regexFactory
     * @param \BrowserDetector\Factory\DeviceFactory $deviceDactory
     */
    public function __construct(
        CacheItemPoolInterface $cache,
        LoggerInterface $logger,
        RegexFactory $regexFactory,
        DeviceFactory $deviceDactory
    ) {
        $this->cache         = $cache;
        $this->logger        = $logger;
        $this->regexFactory  = $regexFactory;
        $this->deviceFactory = $deviceDactory;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $deviceUa
     *
     * @return array
     */
    public function detect($deviceUa)
    {
        /** @var \UaResult\Device\DeviceInterface $device */
        /** @var \UaResult\Os\OsInterface $platform */
        try {
            $this->regexFactory->detect($deviceUa);

            return $this->regexFactory->getDevice();
        } catch (NotFoundException $e) {
            $this->logger->info($e);
            $device   = null;
            $platform = null;
        } catch (NoMatchException $e) {
            $device   = null;
            $platform = null;
        } catch (\InvalidArgumentException $e) {
            $this->logger->error($e);
            $device   = null;
            $platform = null;
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $device   = null;
            $platform = null;
        }

        $this->logger->debug('device not detected via regexes');

        try {
            return $this->deviceFactory->detect($deviceUa);
        } catch (NotFoundException $e) {
            $this->logger->info($e);
        }

        return [
            new \UaResult\Device\Device(null, null),
            new Os(null, null),
        ];
    }
}
