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
 * Copyright (c) 2016 (original work) Opened;
 *
 */

namespace oat\taoCaliper\models\testSession;

use oat\taoCaliper\models\classes\EventManager;
use oat\taoCaliper\models\events\AssessmentEvent;
use oat\taoCaliper\models\events\AssessmentItemEvent;

/**
 * Class TestSessionProcessor
 * @package oat\taoCaliper\models\testSession
 * @author Luis Silvera
 */
class TestSessionProcessor
{
    /**
     * @param AssessmentItemEvent $event
     */
    public static function catchMove(AssessmentItemEvent $event)
    {
        EventManager::itemResponded($event);
    }

    /**
     * @param AssessmentEvent $event
     */
    public static function catchFinished(AssessmentEvent $event)
    {
        EventManager::sessionSubmitted($event);
    }

    /**
     * @param RestImportTestBeforeSaveItems $event
     */
    public static function catchImport($event)
    {
        $externalIdProperty = new \core_kernel_classes_Property('http://www.tao.lu/Ontologies/TAOTest.rdf#ExternalId');
        foreach($event->getTestClass()->getInstances() as $testInstance){
            $externalIdPropertyValue = $testInstance->getPropertyValues($externalIdProperty);
            if (count($externalIdPropertyValue) > 0 && $event->getTestIdentifier() === $externalIdPropertyValue[0]){
                $testInstance->delete(true);
            }
        }
        $event->getNewTest()->editPropertyValues($externalIdProperty, $event->getTestIdentifier());
    }
}
