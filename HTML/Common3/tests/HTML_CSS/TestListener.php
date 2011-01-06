<?php
/**
 * Test listener for HTML_CSS if you used PEAR_TestListener
 *
 * PHP version 5
 *
 * @category HTML
 * @package  HTML_CSS
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @version  CVS: $Id$
 * @link     http://pear.php.net/package/HTML_CSS
 * @link     http://pear.laurent-laville.org/pepr/PEAR_TestListener/
 * @since    File available since Release 1.5.4
 */

require_once 'PEAR/TestListener.php';

/**
 * This class allow to listen additional information provided by Event_Dispatcher
 * into bugs tests suite (HTML_CSS_TestSuite_Bugs.php),
 * only when level is set to PEAR_LOG_DEBUG
 *
 * PHP version 5
 *
 * @category HTML
 * @package  HTML_CSS
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD
 * @version  Release: 1.5.4
 * @link     http://pear.php.net/package/HTML_CSS
 * @link     http://pear.laurent-laville.org/pepr/PEAR_TestListener/
 * @since    Class available since Release 1.5.4
 */

class HTML_CSS_TestListener extends PEAR_TestListener
{
    public function __construct(Log_composite $logger, Event_Dispatcher $dispatcher = null)
    {
        /* don't forget to call parent class constructor if you want to attach
           the SplObserver Interface => PEAR_TestListener::update
         */
        parent::__construct($logger, $dispatcher);
    }

    public function update($subject)
    {
        try {
            list ($notifyName, $notifyInfo, $notifyObj)
                = $this->splSubjectAdapter($subject);
        }
        catch (InvalidArgumentException $e) {
            return;
        }

        switch ($notifyName) {
        case 'startTest' :
            $this->logger->log(
                sprintf(
                    "Parsing data %s %s", PHP_EOL, var_export($notifyInfo, true)
                ),
                PEAR_LOG_DEBUG
            );
            break;
        case 'endTest' :
            $this->logger->log(
                sprintf(
                    "Parsing results %s %s", PHP_EOL, var_export($notifyInfo, true)
                ),
                PEAR_LOG_DEBUG
            );
            break;
        case 'endTestSuite' :
            parent::update($subject);
            break;
        }
    }
}
?>