<?php
namespace BrowserDetectorTest\Detector\Browser;

use BrowserDetector\Detector\Browser\AdbeatBot;

/**
 * Test class for \BrowserDetector\Detector\Browser\AdbeatBot
 */
class AdbeatBotTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Detector\Browser\AdbeatBot
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new AdbeatBot();
    }

    /**
     * tests that a integer is returned
     */
    public function testGetWeight()
    {
        self::assertInternalType('integer', $this->object->getWeight());
    }
}
