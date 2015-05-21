<?php
namespace BrowserDetectorTest\Detector\Os;

use BrowserDetector\Detector\Os\FirefoxOs;

/**
 * Test class for \BrowserDetector\Detector\Os\FirefoxOs
 */
class FirefoxOsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Detector\Os\FirefoxOs
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new FirefoxOs();
    }

    /**
     * @dataProvider providerCanHandlePositive
     * @param string $agent
     */
    public function testCanHandlePositive($agent)
    {
        $this->object->setUserAgent($agent);

        self::assertTrue($this->object->canHandle());
    }

    public function providerCanHandlePositive()
    {
        return array(
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
            array('Mozilla/5.0 (Linux; U; Android 4.3; de-de; SAMSUNG GT-I9305/I9305XXUEMKC Build/JSS15J) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'),
            array('Mozilla/5.0 (Android; Tablet; rv:15.0) Gecko/15.0 Firefox/15.0.1'),
            array('Mozilla/5.0 (Android; Mobile; rv:15.0) Gecko/15.0 Firefox/15.0'),
            array('Mozilla/5.0 (Android; Tablet; rv:23.0) Gecko/23.0 Firefox/23.0'),
            array('Mozilla/5.0 (Android; Mobile; rv:16.0) Gecko/16.0 Firefox/16.0'),
            array('Mozilla/5.0 (Android; Tablet; rv:24.0) Gecko/24.0 Firefox/24.0'),
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
