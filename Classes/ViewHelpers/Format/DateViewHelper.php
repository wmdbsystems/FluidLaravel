<?php
namespace FoT3\FluidLaravel\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class DateViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments
     *
     * @return void
     * @api
     */
    public function initializeArguments()
    {
        $this->registerArgument('date', 'DateTime', '');
        $this->registerArgument('format', 'string', '');
    }

    /**
     * @var boolean
     */
    protected $escapingInterceptorEnabled = false;

    /**
     * Render the supplied DateTime object as a formatted date.
     *
     * @param mixed  $date               either a \DateTime object or a string that is accepted by \DateTime
     *                                   constructor
     * @param string $format             Format String which is taken to format the Date/Time
     *
     * @return string Formatted date
     * @throws \Exception
     * @api
     */
    public function render($date = null, $format = 'Y-m-d')
    {
        if ($date === null) {
            $date = $this->renderChildren();
            if ($date === null) {
                return '';
            }
        }
        if (!$date instanceof \DateTime) {
            try {
                $date = new \DateTime($date);
            } catch (\Exception $exception) {
                throw new \Exception(
                    '"' . $date . '" could not be parsed by \DateTime constructor.',
                    1241722579,
                    $exception
                );
            }
        }
        $output = $date->format($format);
        return $output;
    }
}
