<?php

namespace PhMagick\Adapter;

use PhMagick\PhMagick;
use PhMagick\TextObject;

/**
 * Image manipulation library.
 *
 * This library can be used for easy image manipulation with
 * Image Magick/Graphics Magick.
 *
 * PHP version 5
 *
 * LICENSE: GPL-3.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    PhMagick/Adapter
 * @author     Christoph, René Pardon <christoph@renepardon.de>
 * @copyright  2014 by Christoph, René Pardon
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt
 * @version    1.0
 * @link       http://www.francodacosta.com/phmagick
 * @since      2013-01-09
 */
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
