<?php
namespace FoT3\FluidLaravel\ViewHelpers\Link;


use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class ActionViewHelper extends AbstractTagBasedViewHelper
{

    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * Initialize arguments
     *
     * @return void
     * @api
     */
    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('name', 'string', 'Specifies the name of an anchor');
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');
        $this->registerTagAttribute('rev', 'string', 'Specifies the relationship between the linked document and the current document');
        $this->registerTagAttribute('target', 'string', 'Specifies where to open the linked document');
        $this->registerTagAttribute('action', 'string', 'Specifies the action');
        $this->registerTagAttribute('controller', 'string', 'Specifies the controller');
        $this->registerTagAttribute('arguments', 'array', 'GET parameters');
    }

    /**
     * Render the link.
     *
     * @return string The rendered link
     * @api
     */
    public function render() {
        $action = 'index';
        if (isset($this->arguments['action'])) {
            $action = $this->arguments['action'];
        }
        try {
            $uri = action(ucfirst($this->arguments['controller']) . 'Controller@get' . ucfirst($action));
        } catch (\InvalidArgumentException $e) {
            $uri = '#noYetDefined';
        }
        $this->tag->addAttribute('href', $uri);
        $this->tag->setContent($this->renderChildren());
        $this->tag->forceClosingTag(true);
        return $this->tag->render();
    }
}
