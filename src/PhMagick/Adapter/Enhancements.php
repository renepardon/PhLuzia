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
class Enhancements extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Enhancements';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'denoise',
            'sharpen',
            'smooth',
            'saturate',
            'contrast',
            'edges',
        );
    }

    /**
     * Removes noise like Photoshop does.
     *
     * @param PhMagick $p
     * @param int $amount
     *
     * @return PhMagick
     */
    public function denoise(PhMagick $p, $amount = 1)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -noise ' . $amount;
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Sharpening is a the computer graphics algorithm that is most often see
     * on TV shows and movies. Picture the police force 'cleaning up' a
     * 'zoomed in' photo of a licence plate of a bank robbers car, or the face
     * of a man on a fuzzy shop camera video, and you see what I mean.
     *
     * @param PhMagick $p
     * @param int $amount
     *
     * @return PhMagick
     */
    public function sharpen(PhMagick $p, $amount = 10)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -sharpen 2x' . $amount;
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Chip the edges within current image.
     *
     * @param PhMagick $p
     *
     * @return PhMagick
     */
    public function smooth(PhMagick $p)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -despeckle -despeckle -despeckle ';
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Change saturation of current image through provided amount for the
     * saturation.
     *
     * A saturation of '0' will produce a grayscale image. The gray however
     * mixes all three color channels equally, as defined by the HSL
     * colorspace, as such does not produce a true 'intensity' grayscale.
     *
     * @param PhMagick $p
     * @param int $amount
     *
     * @return PhMagick
     */
    public function saturate(PhMagick $p, $amount = 200)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -modulate 100,' . $amount;
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * The result is a non-linear, smooth contrast change (a 'Sigmoidal Function'
     * in mathematical terms) over the whole color range, preserving the white
     * and black colors, much better for photo color adjustments.
     *
     * The exact formula from the paper is very complex, and even has a mistake,
     * but essentially requires with two adjustment values. A threshold level
     * for the contrast function to center on (typically centered at '50%'),
     * and a contrast factor ('10' being very high, and '0.5' very low).
     *
     * @param PhMagick $p
     * @param int $amount The contrast factor. ('10' being very high, and '0.5'
     *                    very low)
     *
     * @return PhMagick
     */
    public function contrast(PhMagick $p, $amount = 10)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -sigmoidal-contrast ' . $amount . 'x50%';
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     *
     *
     * @param PhMagick $p
     * @param int $amount
     *
     * @return PhMagick
     */
    public function edges(PhMagick $p, $amount = 10)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -adaptive-sharpen 2x' . $amount;
        $cmd .= ' -background "none" "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }
}