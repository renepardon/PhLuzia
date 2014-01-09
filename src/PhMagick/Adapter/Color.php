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
class Color extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Color';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'darken',
            'brighten',
            'toGreyScale',
            'invertColors',
            'sepia',
            'autoLevels',
        );
    }

    /**
     * Makes current image darker.
     *
     * @param PhMagick $p
     * @param int $alphaValue
     *
     * @return PhMagick
     */
    function darken(PhMagick $p, $alphaValue = 50)
    {
        $percent = 100 - (int)$alphaValue;

        // Get original file dimensions.
        list ($width, $height) = $p->getInfo();

        $cmd = $p->getBinary('composite');
        $cmd .= ' -blend  ' . $percent . ' ';
        $cmd .= '"' . $p->getSource() . '"';
        $cmd .= ' -size ' . $width . 'x' . $height . ' xc:black ';
        $cmd .= '-matte "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Brightens current image, default: 50%.
     *
     * 100%: white , 0%: original color (no change)
     *
     * @param PhMagick $p
     * @param int $alphaValue
     *
     * @return PhMagick
     */
    function brighten(PhMagick $p, $alphaValue = 50)
    {
        $percent = 100 - (int)$alphaValue;

        // Get original file dimensions.
        list ($width, $height) = $p->getInfo();

        $cmd = $p->getBinary('composite');
        $cmd .= ' -blend  ' . $percent . ' ';
        $cmd .= '"' . $p->getSource() . '"';
        $cmd .= ' -size ' . $width . 'x' . $height . ' xc:white ';
        $cmd .= '-matte "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Convert current image to grey scale.
     *
     * @param PhMagick $p
     * @param int $enhance
     *
     * @return PhMagick
     */
    function toGreyScale(PhMagick $p, $enhance = 2)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -modulate 100,0 ';
        $cmd .= ' -sigmoidal-contrast ' . $enhance . 'x50%';
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Inverts the image colors.
     *
     * @param PhMagick $p
     *
     * @return PhMagick
     */
    function invertColors(PhMagick $p)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' "' . $p->getSource() . '"';
        $cmd .= ' -negate ';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Applies sepia filter to current image.
     *
     * @param PhMagick $p
     * @param int $tone
     *
     * @return PhMagick
     */
    function sepia(PhMagick $p, $tone = 90)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -sepia-tone ' . $tone . '% ';
        $cmd .= ' -modulate 100,50 ';
        $cmd .= ' -normalize ';
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * autoLevels.
     *
     * Normalization of image.
     *
     * @param PhMagick $p
     *
     * @return PhMagick
     */
    function autoLevels(PhMagick $p)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -normalize ';
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }
}
