<?php
/**
 * @package     Joomla.UnitTest
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

require_once JPATH_PLATFORM . '/legacy/error/error.php';
require_once JPATH_PLATFORM . '/legacy/exception/exception.php';
require_once __DIR__ . '/JErrorInspector.php';

/**
 * Test class for JError.
 * Generated by PHPUnit on 2011-10-26 at 19:34:13.
 */
class JErrorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var JError
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers  JError::getError
     */
    public function testGetError()
    {
		JErrorInspector::manipulateStack(array());

		$this->assertThat(
			JError::getError(),
			$this->isFalse(),
			'There was no error on the error stack but getError did not return false'
		);

		// we normally couldn't have strings, but this is only a test
		JErrorInspector::manipulateStack(array('Error1', 'Error2'));

		$this->assertThat(
			JError::getError(),
			$this->equalTo('Error1'),
			'We did not get the proper value back from getError - it should have returned our fake error'
		);

		$this->assertThat(
			JErrorInspector::inspectStack(),
			$this->equalTo(array('Error1', 'Error2')),
			'The stack was changed by getError even though unset was false'
		);

		$this->assertThat(
			JError::getError(true),
			$this->equalTo('Error1'),
			'We did not get the proper value back from getError - it should have returned our fake error'
		);

		$this->assertThat(
			JErrorInspector::inspectStack(),
			$this->equalTo(array('Error2')),
			'The stack was either not changed or changed the wrong way by getError (with  unset true)'
		);

		// here we remove any junk left on the error stack
		JErrorInspector::manipulateStack(array());
    }

    /**
     * @covers  JError::getErrors
     */
    public function testGetErrors()
    {
		JErrorInspector::manipulateStack(array('value1', 'value2', 'value3'));

		$this->assertThat(
			JError::getErrors(),
			$this->equalTo(array('value1', 'value2', 'value3')),
			'Somehow a basic getter did not manage to return the static value'
		);

		JErrorInspector::manipulateStack(array());
    }

    /**
     * @covers  JError::addToStack
     */
    public function testAddToStack()
    {
        // Remove the following lines when the framework is fixed.
		//$this->markTestSkipped('The framework is currently broken.  Skipping this test.');

		JErrorInspector::manipulateStack(array('value1', 'value2', 'value3'));

		$exception = new JException('This is the error message', 1056, 'error');

		JError::addToStack($exception);

		$stack = JErrorInspector::inspectStack();

		$this->assertThat(
			$stack[3],
			$this->identicalTo($exception),
			'The exception did not get properly added to the stack'
		);

		JErrorInspector::manipulateStack(array());
    }

    /**
     * @todo Implement testRaise().
     */
    public function testRaise()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testThrowError().
     */
    public function testThrowError()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testRaiseError().
     */
    public function testRaiseError()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testRaiseWarning().
     */
    public function testRaiseWarning()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testRaiseNotice().
     */
    public function testRaiseNotice()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetErrorHandling().
     */
    public function testGetErrorHandling()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

	/**
	 * @covers JError::setErrorHandling
	 */
	public function testSetErrorHandling()
	{
		JErrorInspector::manipulateLevels(
			array(
				E_NOTICE => 'Notice',
				E_WARNING => 'Warning',
				E_ERROR => 'Error'
			)
		);
		$errorHandling = JErrorInspector::inspectHandlers();

		$this->assertThat(
			JError::setErrorHandling(E_NOTICE, 'message'),
			$this->isTrue(),
			'Setting a message error handler failed'
		);

		$handlers = JErrorInspector::inspectHandlers();

		$this->assertThat(
			$handlers[E_NOTICE],
			$this->equalTo(array('mode' => 'message')),
			'The error handler did not get set to message'
		);

		$this->assertThat(
			JError::setErrorHandling(E_NOTICE, 'callback', array($this, 'callbackHandler')),
			$this->isTrue(),
			'Setting a message error handler failed'
		);

		$handlers = JErrorInspector::inspectHandlers();

		$this->assertThat(
			$handlers[E_NOTICE],
			$this->equalTo(array('mode' => 'callback', 'options' => array($this, 'callbackHandler'))),
			'The error handler did not get set to callback'
		);

		JErrorInspector::manipulateHandlers($errorHandling);
    }

	/**
	 * Callback for testSetErrorHandling
	 */
	public function callbackHandler()
	{
		return;
	}

    /**
     * @todo Implement testAttachHandler().
     */
    public function testAttachHandler()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testDetachHandler().
     */
    public function testDetachHandler()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testRegisterErrorLevel().
     */
    public function testRegisterErrorLevel()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testTranslateErrorLevel().
     */
    public function testTranslateErrorLevel()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testHandleIgnore().
     */
    public function testHandleIgnore()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testHandleEcho().
     */
    public function testHandleEcho()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testHandleVerbose().
     */
    public function testHandleVerbose()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testHandleDie().
     */
    public function testHandleDie()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testHandleMessage().
     */
    public function testHandleMessage()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testHandleLog().
     */
    public function testHandleLog()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testHandleCallback().
     */
    public function testHandleCallback() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testCustomErrorPage().
     */
    public function testCustomErrorPage() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testCustomErrorHandler().
     */
    public function testCustomErrorHandler() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testRenderBacktrace().
     */
    public function testRenderBacktrace() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}
