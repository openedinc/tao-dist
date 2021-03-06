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
 * Copyright (c) 2014 (original work) Open Assessment Technologies SA;
 * 
 */

namespace oat\generis\model\data\permission;

use oat\generis\model\data\permission\implementation\NoAccess;
use common_ext_ExtensionsManager;
use common_Logger;
use oat\generis\model\data\event\ResourceCreated;
use oat\oatbox\event\Event;
use oat\oatbox\service\ServiceManager;
use oat\oatbox\service\ServiceNotFoundException;

/**
 * Proxy for the permission implementation
 * 
 * @author Joel Bout <joel@taotesting.com>
 */
class PermissionManager
{
    const CONFIG_KEY = 'permissions';
    
    /**
     * @return PermissionInterface
     */
    public static function getPermissionModel() {
        try {
            return ServiceManager::getServiceManager()->get(PermissionInterface::SERVICE_ID);
        } catch (ServiceNotFoundException $e) {
            common_Logger::w('No permission implementation found');
            return new NoAccess();
        }
    }
    
    /**
     * @param core_kernel_persistence_RdfsDriver $model
     */
    public static function setPermissionModel(PermissionInterface $model) {
        common_ext_ExtensionsManager::singleton()->getExtensionById('generis')->setConfig(self::CONFIG_KEY, $model);
    }
    
    public static function catchEvent(Event $event)
    {
        if ($event instanceof ResourceCreated) {
            self::getPermissionModel()->onResourceCreated($event->getResource());
        }
    }
}