<?php

/**
 * This file is part of the FluidLaravel package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoT3\FluidLaravel;

use Illuminate\View\ViewServiceProvider;

/**
 * Bootstrap Laravel FluidAdapter.
 *
 * You need to include this `ServiceProvider` in your app.php file:
 *
 * <code>
 *     'providers' => [
 *         'FoT3\FluidLaravel\ServiceProvider'
 *     ];
 * </code>
 */
class ServiceProvider extends ViewServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->registerCommands();
        $this->registerOptions();
        $this->registerLoaders();
        $this->registerEngine();
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->loadConfiguration();
        $this->registerExtension();
    }

    /**
     * Load the configuration files and allow them to be published.
     *
     * @return void
     */
    protected function loadConfiguration()
    {
        $configPath = __DIR__ . '/../config/fluidlaravel.php';

        $this->mergeConfigFrom($configPath, 'fluidlaravel');
    }

    /**
     * Register the Fluid extension in the Laravel View component.
     *
     * @return void
     */
    protected function registerExtension()
    {
        $this->app['view']->addExtension(
            $this->app['fluid.extension'],
            'fluid',
            function () {
                return $this->app['fluid.engine'];
            }
        );
    }

    /**
     * Register console command bindings.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->app->bindIf('command.fluid.clean', function () {
            return new Command\Clean();
        });
    }

    /**
     * Register Fluid config option bindings.
     *
     * @return void
     */
    protected function registerOptions()
    {
        $this->app->bindIf('fluid.extension', function () {
            return $this->app['config']->get('fluidlaravel.fluid.extension');
        });

        $this->app->bindIf('fluid.options', function () {
            $options = $this->app['config']->get('fluidlaravel.fluid.environment', []);

            // Check whether we have the cache path set
            if (!isset($options['cache']) || is_null($options['cache'])) {
                // No cache path set for Fluid, lets set to the Laravel views storage folder
                $options['cache'] = storage_path('framework/views/fluid');
            }

            return $options;
        });
    }

    /**
     * Register Fluid loader bindings.
     *
     * @return void
     */
    protected function registerLoaders()
    {
    }

    /**
     * Register Fluid engine bindings.
     *
     * @return void
     */
    protected function registerEngine()
    {
        $this->app->bindIf(
            'fluid',
            function () {
                $fluid = new Adapter(
                    $this->app['fluid.options'],
                    $this->app
                );
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.fluid',
            'command.fluid.clean',
            'fluid.extension',
            'fluid.options',
            'fluid.templates',
            'fluid',
            'fluid.compiler',
            'fluid.engine',
        ];
    }
}