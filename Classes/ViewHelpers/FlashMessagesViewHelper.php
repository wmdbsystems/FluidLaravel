<?php
namespace FoT3\FluidLaravel\ViewHelpers;


use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class FlashMessagesViewHelper extends AbstractTagBasedViewHelper
{

    /**
     * @var string
     */
    protected $tagName = 'ul';

    /**
     * Initialize arguments
     *
     * @return void
     * @api
     */
    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();
    }

    /**
     * Renders flash messages that have been added to the FlashMessageContainer in previous request(s).
     *
     * @param string $as       The name of the current flashMessage variable for rendering inside
     * @param string $severity severity of the messages (One of the \TYPO3\Flow\Error\Message::SEVERITY_* constants)
     *
     * @return string rendered Flash Messages, if there are any.
     * @api
     */
    public function render($as = null, $severity = null)
    {
//        $flashMessages = $this->controllerContext->getFlashMessageContainer()->getMessagesAndFlush($severity);
        $flashMessages = array();
        if (count($flashMessages) < 1) {
            return '';
        }
        if ($as === null) {
            $content = $this->renderAsList($flashMessages);
        } else {
            $content = $this->renderFromTemplate($flashMessages, $as);
        }

        return $content;
    }

    /**
     * Render the flash messages as unsorted list. This is triggered if no "as" argument is given
     * to the ViewHelper.
     *
     * @param array <Message> $flashMessages
     *
     * @return string
     */
    protected function renderAsList(array $flashMessages)
    {
        $flashMessagesClass = $this->arguments['class'] !== null ? $this->arguments['class'] : 'flashmessages';
        $tagContent = '';
        /** @var $singleFlashMessage Message */
        foreach ($flashMessages as $singleFlashMessage) {
            $severityClass = sprintf('%s-%s', $flashMessagesClass, strtolower($singleFlashMessage->getSeverity()));
            $messageContent = htmlspecialchars($singleFlashMessage->render());
            if ($singleFlashMessage->getTitle() !== '') {
                $messageContent =
                    sprintf('<h3>%s</h3>', htmlspecialchars($singleFlashMessage->getTitle())) . $messageContent;
            }
            $tagContent .= sprintf('<li class="%s">%s</li>', htmlspecialchars($severityClass), $messageContent);
        }
        $this->tag->setContent($tagContent);
        $content = $this->tag->render();

        return $content;
    }

    /**
     * Defer the rendering of Flash Messages to the template. In this case,
     * the flash messages are stored in the template inside the variable specified
     * in "as".
     *
     * @param array  $flashMessages
     * @param string $as
     *
     * @return string
     */
    protected function renderFromTemplate(array $flashMessages, $as)
    {
        $templateVariableContainer = $this->renderingContext->getTemplateVariableContainer();
        $templateVariableContainer->add($as, $flashMessages);
        $content = $this->renderChildren();
        $templateVariableContainer->remove($as);

        return $content;
    }
}
