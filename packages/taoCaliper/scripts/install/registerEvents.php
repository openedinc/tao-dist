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
 * Copyright (c) 2015 (original work) Open Assessment Technologies SA;
 *
 *
 */

use oat\oatbox\event\EventManager;
use oat\oatbox\service\ServiceManager;
use oat\taoCaliper\models\testSession\TestSessionProcessor;

$eventManager = ServiceManager::getServiceManager()->get(EventManager::SERVICE_ID);

$eventManager->attach(
    'oat\\taoCaliper\\models\\events\\AssessmentItemEvent',
    array(TestSessionProcessor::class, 'catchMove')
);

$eventManager->attach(
    'oat\\taoCaliper\\models\\events\\AssessmentEvent',
    array(TestSessionProcessor::class, 'catchFinished')
);

$eventManager->attach(
    'oat\\taoQtiTest\\models\\event\\RestImportTestBeforeSaveItems',
    array(TestSessionProcessor::class, 'catchImport')
);

ServiceManager::getServiceManager()->register(EventManager::SERVICE_ID , $eventManager);
