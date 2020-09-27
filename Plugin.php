<?php

namespace Xitara\Logger;

use Backend;
use Event;
use System\Classes\PluginBase;
use System\Models\LogSetting;

/**
 * Logger Plugin Information File.
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Logger',
            'description' => 'No description provided yet...',
            'author'      => 'Xitara',
            'icon'        => 'icon-leaf',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        LogSetting::extend(function ($model) {
            if (!$model instanceof LogSetting) {
                return;
            }

            Event::listen('backend.form.extendFields', function ($model) {
                if (!($model->model instanceof \System\Models\LogSetting)) {
                    return;
                }

                $model->addTabFields([
                    'log_custom' => [
                        'label'   => 'xitara.logger::lang.switch.custom',
                        'comment' => 'xitara.logger::lang.switch.comment.custom',
                        'type'    => 'switch',
                        'span'    => 'auto',
                        'tab'     => 'xitara.logger::lang.tab.custom_logging',
                    ],
                    'log_database' => [
                        'label'   => 'xitara.logger::lang.switch.database',
                        'comment' => 'xitara.logger::lang.switch.comment.database',
                        'type'    => 'switch',
                        'span'    => 'auto',
                        'tab'     => 'xitara.logger::lang.tab.custom_logging',
                    ],
                    'log_cli' => [
                        'label'   => 'xitara.logger::lang.switch.cli',
                        'comment' => 'xitara.logger::lang.switch.comment.cli',
                        'type'    => 'switch',
                        'span'    => 'auto',
                        'tab'     => 'xitara.logger::lang.tab.custom_logging',
                    ],
                    'log_custom_levels' => [
                        'label'   => 'xitara.logger::lang.checkboxlist.label',
                        'comment' => 'xitara.logger::lang.checkboxlist.comment',
                        'type'    => 'checkboxlist',
                        'span'    => 'auto',
                        'options' => [
                            'emergency' => 'Emergency',
                            'alert'     => 'Alert',
                            'critical'  => 'Critical',
                            'error'     => 'Error',
                            'warning'   => 'Warning',
                            'notice'    => 'Notice',
                            'info'      => 'Info',
                            'debug'     => 'Debug',
                        ],
                        'tab' => 'xitara.logger::lang.tab.custom_logging',
                    ],
                ]);
            });
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Xitara\Logger\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'xitara.logger.some_permission' => [
                'tab'   => 'Logger',
                'label' => 'Some permission',
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'logger' => [
                'label'       => 'Logger',
                'url'         => Backend::url('xitara/logger/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['xitara.logger.*'],
                'order'       => 500,
            ],
        ];
    }
}
