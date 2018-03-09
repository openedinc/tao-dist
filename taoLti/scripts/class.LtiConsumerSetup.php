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
 * Copyright (c) 2017 Koombea Inc contracted by ACT;
 *
 *
 */

/**
 * This Script class aims at providing tools to manage Tao LTI consumers.
 * Class LtiConsumerSetup
 * @access public
 * @package oat\taoLti\scripts
 * @author Luis Silvera, <luis.silvera@koombea.com>
 */
class tao_LtiConsumerSetup
    extends tao_scripts_Runner
{
    const CLASS_URI = 'http://www.tao.lu/Ontologies/TAOLTI.rdf#LTIConsumer';
    const OAUTH_URI = 'http://www.tao.lu/Ontologies/TAO.rdf#OauthConsumer';
    const KEY_URI = 'http://www.tao.lu/Ontologies/TAO.rdf#OauthKey';
    const SECRET_URI = 'http://www.tao.lu/Ontologies/TAO.rdf#OauthSecret';

    public function run(){
        $ltiName = $this->parameters[1];
        $ltiConsumerClass = new \core_kernel_classes_Class(static::CLASS_URI);
        $propertiesValues = array(
            RDFS_LABEL => $ltiName,
            RDFS_COMMENT => $ltiName
        );
        $ltiConsumer = $ltiConsumerClass->createInstanceWithProperties($propertiesValues);

        $keyProperty = new core_kernel_classes_Property(static::KEY_URI);
        $ltiConsumer->editPropertyValues($keyProperty, $this->parameters[2]);

        $secretProperty = new core_kernel_classes_Property(static::SECRET_URI);
        $ltiConsumer->editPropertyValues($secretProperty, $this->parameters[3]);
    }
}
