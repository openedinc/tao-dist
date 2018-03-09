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
 * Copyright (c) 2015 (original work) Opened;
 *
 */

namespace oat\taoCaliper\models\classes;

use oat\taoCaliper\models\events\AssessmentEvent;
use oat\taoCaliper\models\events\AssessmentItemEvent;

/**
 *
 */
class EventManager
{
    /**
     * Send request to the LTI provider
     */
    public static function itemResponded(AssessmentItemEvent $event)
    {
        static::request("POST", $event->getCustomURL(), $event->getRequestSignatureHeader(), $event->getOutput());
    }

    /**
     * Send request to the LTI provider
     */
    public static function sessionSubmitted(AssessmentEvent $event)
    {
        static::request("POST", $event->getCustomURL(), $event->getRequestSignatureHeader(), $event->getOutput());
    }

    public static function request($type, $url, $headers, $body)
    {
        $client = new \GuzzleHttp\Client();
        $client->request($type, $url, [
            'headers' => $headers,
            'json' => [
                'caliper_event' => $body
            ]
        ]);
    }
}
