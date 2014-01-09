<?php

namespace PhMagick\Adapter;

use PhMagick\Gravity;
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
class Transform extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Transform';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'rotate',
            'flipVertical',
            'flipHorizontal',
            'reflection',
        );
    }

    /**
     * Rotate image by provided amount of degrees.
     *
     * @param PhMagick $p
     * @param int $degrees
     *
     * @return PhMagick
     */
    public function rotate(PhMagick $p, $degrees = 45)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -background "transparent" -rotate ' . $degrees;
        $cmd .= '  "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Flips the image vertically.
     *
     * @param PhMagick $p
     *
     * @return PhMagick
     */
    public function flipVertical(PhMagick $p)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -flip ';
        $cmd .= ' "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());
        
        return $p;
    }

    /**
     * Flips the image horizontally.
     *
     * @param PhMagick $p
     *
     * @return PhMagick
     */
    public function flipHorizontal(PhMagick $p)
    {
        $cmd = $p->getBinary('convert');
        $cmd .= ' -flop ';
        $cmd .= ' "' . $p->getSource() . '"';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);
        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }

    /**
     * Flips the image horizontally and vertically.
     *
     * @param PhMagick $p
     * @param int $size
     * @param int $transparency
     *
     * @return PhMagick
     */
    public function reflection(PhMagick $p, $size = 60, $transparency = 50)
    {
        // Requires Crop adapter.
        $p->addAdapter(new Crop());

        $source = $p->getSource();

        // Invert image.
        $this->flipVertical($p);

        // Crop it to $size%
        list($w, $h) = $p->getInfo($p->getDestination());
        $p->crop($w, $h * ($size / 100), 0, 0, Gravity::None);

        // Make a image fade to transparent.
        $cmd = $p->getBinary('convert');
        $cmd .= ' "' . $p->getSource() . '"';
        $cmd .= ' ( -size ' . $w . 'x' . ($h * ($size / 100)) . ' gradient: ) ';
        $cmd .= ' +matte -compose copy_opacity -composite ';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);

        // Apply desired transparency, by creating a transparent image and merge
        // the mirros image on to it with the desired transparency.
        $file = dirname($p->getDestination()) . '/' . uniqid() . '.png';

        $cmd = $p->getBinary('convert');
        $cmd .= '  -size ' . $w . 'x' . ($h * ($size / 100)) . ' xc:none  ';
        $cmd .= ' "' . $file . '"';

        $p->execute($cmd);

        $cmd = $p->getBinary('composite');
        $cmd .= ' -dissolve ' . $transparency;
        $cmd .= ' "' . $p->getDestination() . '"';
        $cmd .= ' ' . $file;
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);

        unlink($file);

        // Append the source and the relfex.
        $cmd = $p->getBinary('convert');
        $cmd .= ' "' . $source . '"';
        $cmd .= ' "' . $p->getDestination() . '"';
        $cmd .= ' -append ';
        $cmd .= ' "' . $p->getDestination() . '"';

        $p->execute($cmd);

        $p->setSource($p->getDestination());
        $p->setHistory($p->getDestination());

        return $p;
    }
}
