<?php
namespace FoT3\FluidLaravel\ViewHelpers\Uri;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class ResourceViewHelper extends AbstractViewHelper
{
    protected $appPath = 'tempname_until_we_fix_fluid';

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('path', 'string', 'The Path', true, null);
        $this->registerArgument('package', 'string', 'The Package', false, null);
    }

    /**
     * @return string
     */
    public function render()
    {
        $path = '/' . $this->arguments['path'];
        return $path;
    }
}
