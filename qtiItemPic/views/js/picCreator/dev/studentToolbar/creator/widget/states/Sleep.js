/*
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
 * Copyright (c) 2016 (original work) Open Assessment Technologies SA;
 *
 */
define([
    'lodash',
    'jquery',
    'taoQtiItem/qtiCreator/widgets/states/factory',
    'taoQtiItem/qtiCreator/widgets/states/Sleep'
], function(_, $, stateFactory, SleepState){
    'use strict';

    return stateFactory.extend(SleepState, function(){

        var _widget = this.widget;
        var item = this.widget.element.getRelatedItem();

        _widget.$container.on('click.qti-widget.sleep', function(e){

            var $tool = $(e.target).closest('.sts-button[data-typeidentifier]');

            e.stopPropagation();

            if($tool.length){
                //find the student tool hosted in the toolbar and trigger the active state on it
                var infoControl = _.find(item.getElements('infoControl'), {typeIdentifier : $tool.data('typeidentifier')});
                infoControl.data('widget').changeState('active');
            }
        });

    }, function(){

        this.widget.$container.off('.sleep');
    });
});
