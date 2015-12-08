<?php

/**
 * This file is part of the FluidLaravel package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoT3\FluidLaravel;


use Illuminate\Contracts\Foundation\Application;
use TYPO3Fluid\Fluid\View\TemplatePaths;
use TYPO3Fluid\Fluid\View\TemplateView;

/**
 * Adapter functions between Laravel & Fluid
 */
class Adapter
{
    /**
     * @var string version
     */
    const VERSION = '1.0.0';

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * {@inheritdoc}
     */
    public function __construct($options = [], Application $app = null)
    {
        $templatePaths = new TemplatePaths;
        $this->app = $app;
        $templatePaths->setTemplateRootPaths(array(
            base_path() . '/resources/Private/Templates/'
        ));
        $templatePaths->setLayoutRootPaths(array(
            base_path() . '/resources/Private/Layouts/'
        ));
        $templatePaths->setPartialRootPaths(array(
            base_path() . '/resources/Private/Partials/'
        ));
        $this->view = new TemplateView($templatePaths);
        $context = $this->view->getRenderingContext();
        $context->setControllerName($this->determineControllerName());
        $this->view->setRenderingContext($context);
    }

    /**
     * Determines the current controller name and passes it to Fluid
     *
     * @return mixed
     */
    protected function determineControllerName()
    {
        $className = get_class($this);
        $namespaceParts = explode('\\', $className);
        $fullControllerName = array_pop($namespaceParts);
        $controllerName = str_replace('Controller', '', $fullControllerName);
        return $controllerName;
    }

    /**
     * Get the Laravel app.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function getApplication()
    {
        return $this->app;
    }

    /**
     * Set the Laravel app.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function setApplication(Application $app)
    {
        $this->app = $app;
    }
}