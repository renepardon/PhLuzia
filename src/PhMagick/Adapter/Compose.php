<?php

namespace PhMagick\Adapter;

use PhMagick\Gravity;
use PhMagick\History;
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
class Compose extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Compose';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'watermark',
            'tile',
            'acquireFrame',
        );
    }

    /**
     * Add's a watermark to current image.
     *
     * composite -gravity SouthEast watermark.png original-image.png output-image.png
     *
     * @param PhMagick $p
     * @param $watermarkImage Image path.
     * @param string $gravity The placement of the watermark.
     * @param int $transparency 1 to 100, the transparency of the watermark (100 = opaque).
     *
     * @return PhMagick
     */
    public function watermark(PhMagick $p, $watermarkImage, $gravity = Gravity::Center, $transparency = 50)
    {
        $cmd = $p->getBinary('composite');
        $cmd .= ' -dissolve ' . $transparency;
        $cmd .= ' -gravity ' . $gravity;
        $cmd .= ' ' . $watermarkImage;
        $cmd .= ' "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Joins several images in one tab strip.
     *
     * @param PhMagick $p
     * @param array $paths Array of strings, The paths of images to join.
     * @param string $tileWidth
     * @param int $tileHeight
     *
     * @return PhMagick
     */
    public function tile(PhMagick $p, array $paths = null, $tileWidth = '', $tileHeight = 1)
    {
        if (is_null($paths)) {
            $paths = $p->getHistory(History::TO_ARRAY);
        }

        $cmd = $p->getBinary('montage');
        $cmd .= ' -geometry x+0+0 -tile ' . $tileWidth . 'x' . $tileHeight . ' ';
        $cmd .= implode(' ', $paths);
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Attempts to create an image(s) from a File (PDF & Avi are supported on most systems).
     * It grabs the first frame / page from the source file.
     *
     * @param PhMagick $p
     * @param $file The path to file.
     * @param int $frames
     *
     * @return PhMagick
     */
    public function acquireFrame(PhMagick $p, $file, $frames = 0)
    {
        // $cmd = 'echo "" | '; //just a workarround for videos,
        //                    imagemagick first converts all frames then deletes all but the first
        $cmd = $p->getBinary('convert');
        $cmd .= ' "' . $file . '"[' . $frames . ']';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }
}
