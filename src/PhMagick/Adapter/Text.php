<?php
namespace PhMagick\Adapter;

use PhMagick\PhMagick;
use PhMagick\TextObject;

class Text extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Text';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'fromString',
        );
    }

    /**
     * Draws an image with the submitted string. Useful for watermarks.
     *
     * @param PhMagick $p
     * @param string $text       The text to draw an image from
     * @param TextObject $format The text configuration
     *
     * @return PhMagick
     */
    public function fromString(PhMagick $p, $text = '', TextObject $format = null)
    {
        if (is_null($format)) {
            $format = new TextObject();
        }

        $cmd = $p->getBinary('convert');

        if ($format->getBackground() !== false) {
            $cmd .= ' -background "' . $format->getBackground() . '"';
        }

        if ($format->getColor() !== false) {
            $cmd .= ' -fill "' . $format->getColor() . '"';
        }

        if ($format->getFont() !== false) {
            $cmd .= ' -font ' . $format->getFont();
        }

        if ($format->getFontSize() !== false) {
            $cmd .= ' -pointsize ' . $format->getFontSize();
        }

        if (($format->getText() != '') && ($text = '')) {
            $text = $format->getText();
        }

        $cmd .= ' label:"' . $text . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }
}
