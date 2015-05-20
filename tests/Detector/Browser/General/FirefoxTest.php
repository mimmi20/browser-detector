<?php
namespace BrowserDetectorTest\Detector\Browser\General;

use BrowserDetector\Detector\Browser\General\Firefox;

/**
 * Test class for \BrowserDetector\Detector\Browser\General\Firefox
 */
class FirefoxTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Detector\Browser\General\Firefox
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new Firefox();
    }

    /**
     * @dataProvider providerCanHandlePositive
     * @param string $agent
     */
    public function testCanHandlePositive($agent)
    {
        self::markTestSkipped('need user agent');

        $this->object->setUserAgent($agent);

        self::assertTrue($this->object->canHandle());
    }

    public function providerCanHandlePositive()
    {
        return array(
            array('Mozilla/5.0 (Android; Tablet; rv:15.0) Gecko/15.0 Firefox/15.0.1'),
            array('Mozilla/5.0 (Android; Mobile; rv:15.0) Gecko/15.0 Firefox/15.0'),
            array('Mozilla/5.0 (Android; Tablet; rv:23.0) Gecko/23.0 Firefox/23.0'),
            array('Mozilla/5.0 (Android; Mobile; rv:16.0) Gecko/16.0 Firefox/16.0'),
            array('Mozilla/5.0 (Android; Tablet; rv:24.0) Gecko/24.0 Firefox/24.0'),
            array('Mozilla/5.0 (Mobile; ALCATELOneTouch4012X/SVN 01010B; rv:18.1) Gecko/18.1 Firefox/18.1'),
        );
    }

    /**
     * @dataProvider providerCanHandleNegative
     * @param string $agent
     */
    public function testCanHandleNegative($agent)
    {
        $this->object->setUserAgent($agent);

        self::assertFalse($this->object->canHandle());
    }

    public function providerCanHandleNegative()
    {
        return array(
            array('Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Mobile'),
            array('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/538.1 (KHTML, like Gecko) crawler Safari/538.1'),
            array('Mozilla/5.0 (compatible; Exabot/3.0; +http://www.exabot.com/go/robot)'),
        );
    }

    /**
     * tests that a integer is returned
     */
    public function testGetWeight()
    {
        self::assertInternalType('integer', $this->object->getWeight());
    }
}
