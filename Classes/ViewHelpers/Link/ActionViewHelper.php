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
        $this->registerTagAttribute('rel', 'string', 'Relationship between current document and the linked document');
        $this->registerTagAttribute('rev', 'string', 'Relationship between linked document and the current document');
        $this->registerTagAttribute('target', 'string', 'Specifies where to open the linked document');
        $this->registerTagAttribute('action', 'string', 'Specifies the action');
        $this->registerTagAttribute('controller', 'string', 'Specifies the controller');
        $this->registerArgument('arguments', 'array', 'GET parameters');
        $this->registerArgument('data', 'array', 'GET parameters');
    }

    /**
     * Render the link.
     *
     * @return string The rendered link
     * @api
     */
    public function render()
    {
        $action = 'index';
        if (isset($this->arguments['action'])) {
            $action = $this->arguments['action'];
        }
        // Resolve Controller if not explicitly given
        if (!isset($this->arguments['controller'])) {
            $this->arguments['controller'] = $this->renderingContext->getControllerName();
        }
        try {
            $uri = action(ucfirst($this->arguments['controller']) . 'Controller@get' . ucfirst($action));
        } catch (\InvalidArgumentException $e) {
            var_dump('No route found for ' . ucfirst($this->arguments['controller']) . 'Controller@get' . ucfirst($action));
            $uri = '';
        }
        if (isset($this->arguments['arguments'])) {
            $uri .= $this->addArgumentsToUri($this->arguments['arguments']);
        }
        $this->tag->addAttribute('href', $uri);
        $this->tag->setContent($this->renderChildren());
        $this->tag->forceClosingTag(true);
        return $this->tag->render();
    }

    protected function addArgumentsToUri(array $arguments)
    {
        $argumentsToAddToQueryString = [];
        foreach ($arguments as $index => $argument) {
            if ($argument !== null) {
                if (is_array($argument)) {
                    $argumentsToAddToQueryString[] = $this->implodeArrayForUrl($index, $argument);
                } else {
                    $argumentsToAddToQueryString[] = '&' . $index . '=' . $argument;
                }
            }
        }
        return '?' . implode($argumentsToAddToQueryString);
    }

    /**
     * Implodes a multidimensional-array into GET-parameters (eg. &param[key][key2]=value2&param[key][key3]=value3)
     *
     * @param string $name Name prefix for entries. Set to blank if you wish none.
     * @param array $theArray The (multidimensional) array to implode
     * @param string $str (keep blank)
     * @param bool $skipBlank If set, parameters which were blank strings would be removed.
     * @return string Imploded result, fx. &param[key][key2]=value2&param[key][key3]=value3
     */
    protected function implodeArrayForUrl($name, array $theArray, $str = '', $skipBlank = false)
    {
        foreach ($theArray as $Akey => $AVal) {
            $thisKeyName = $name ? $name . '[' . $Akey . ']' : $Akey;
            if (is_array($AVal)) {
                $str = $this->implodeArrayForUrl($thisKeyName, $AVal, $str, $skipBlank);
            } else {
                if (!$skipBlank || (string)$AVal !== '') {
                    $str .= '&' . $thisKeyName . '=' . rawurlencode($AVal);
                }
            }
        }
        return $str;
    }
}
