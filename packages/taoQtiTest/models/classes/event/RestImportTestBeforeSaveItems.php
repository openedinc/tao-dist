<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2017 Opened.
 *
 */

namespace oat\taoQtiTest\models\event;

use qtism\runtime\tests\AssessmentTestSession;
use oat\oatbox\event\Event;

/**
 *
 */
class RestImportTestBeforeSaveItems implements Event
{

    const EVENT_NAME = __CLASS__;

    /**
     * @return string
     */
    public function getName()
    {
        return static::EVENT_NAME;
    }
    /**
     * RestImportTestBeforeSaveItems constructor.
     */
    public function __construct($testClass, $testIdentifier, $newTest)
    {
        $this->testClass = $testClass;
        $this->testIdentifier = $testIdentifier;
        $this->newTest = $newTest;
    }

    /**
     * Return the Test class resource
     */
    public function getTestClass()
    {
        return $this->testClass;
    }

    /**
     * @return string
     */
    public function getTestIdentifier()
    {
        return $this->testIdentifier;
    }

    /**
     * Return the new Test class instance
     */
    public function getNewTest()
    {
        return $this->newTest;
    }
}