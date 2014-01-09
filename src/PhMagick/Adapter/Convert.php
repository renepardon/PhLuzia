<?php

namespace PhMagick\Adapter;

use PhMagick\PhMagick;

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
class Convert extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Convert';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'convert',
        );
    }

    /**
     * Converts from one format to another.
     *
     * Use the convert program to convert between image formats as well as
     * resize an image, blur, crop, despeckle, dither, draw on, flip, join,
     * re-sample, and much more. See Command Line Processing for advice on how
     * to structure your convert command or see below for example usages of
     * the command.
     *
     * @param PhMagick $p
     *
     * @return PhMagick
     */
    public function convert(PhMagick $p)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -quality ' . $p->getImageQuality();
        $cmd .= ' "' . $p->getSource() . '"  "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }
}
