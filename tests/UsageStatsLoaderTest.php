<?php

/**
 * @file plugins/generic/usageStats/tests/UsageStatsLoaderTest.php
 *
 * Copyright (c) 2013-2018 Simon Fraser University
 * Copyright (c) 2003-2018 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class UsageStatsLoaderTest
 * @ingroup plugins_generic_usagestats_tests
 * @see UsageStatsLoader
 *
 * @brief Test class for the UsageStatsLoader class
 */

import('lib.pkp.tests.PKPTestCase');
import('plugins.generic.usageStats.UsageStatsLoader');

class UsageStatsLoaderTest extends PKPTestCase {

        //
        // Implementing protected template methods from PKPTestCase
        //
        /**
         * @see PKPTestCase::setUp()
         */
        protected function setUp() {
			parent::setUp();

			// Instantiate the class for testing.
			// disable the original constructor and mock the abstract getMetricType()
			$this->loader = $this->getMockBuilder('UsageStatsLoader')
			->setMethods(array('__construct', 'getMetricType'))
			->setConstructorArgs(array())
			->disableOriginalConstructor()
			->getMock();
        }

	//
	// Unit tests
	//
	/**
	 * @covers UsageStatsLoader::getCounterRobotListFile()
	 */
	public function testGetCounterRobotListFile() {

		// The getCounterRobotListFile() method will call $this->_plugin->getPluginPath()
		// Mock this cal
		$this->mockPlugin = $this->getMockBuilder('UsageStatsPlugin')
			->setMethods(array('getPluginPath'))
			->getMock();
		$this->mockPlugin
			->expects($this->once())
			->method('getPluginPath')
			->will($this->returnValue('plugins/generic/usageStats'));
		$this->loader->_plugin = $this->mockPlugin;

		// assert bot list filename is present and readable
		$filename = $this->loader->getCounterRobotListFile();
		$foundFile = $filename && is_readable($filename);
		self::assertTrue($foundFile, 'getCounterRobotListFile() did not return a readable filename');
	}
}

