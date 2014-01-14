<?php

namespace PhLuzia\Adapter;

use PhLuzia\Command;
use PhLuzia\Gravity;
use PhLuzia\History;
use PhLuzia\Service\PhLuzia;

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
 * @package    PhLuzia/Adapter
 * @author     Christoph, René Pardon <christoph@renepardon.de>
 * @copyright  2014 by Christoph, René Pardon
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt
 * @version    1.0
 * @link       https://github.com/renepardon/PhLuzia
 * @since      2013-01-09
 */
class Compose extends AdapterAbstract
{
    /**
     * Add's a watermark to current image.
     *
     * composite -gravity SouthEast watermark.png original-image.png output-image.png
     *
     * @param $watermarkImage Image path.
     * @param string $gravity The placement of the watermark.
     * @param int $transparency 1 to 100, the transparency of the watermark (100 = opaque).
     *
     * @return PhLuzia
     */
    public function watermark($watermarkImage, $gravity = Gravity::Center, $transparency = 50)
    {
        $cmd = new Command('composite', $this->service);
        $cmd->addOption('-dissolve %d', $transparency)
            ->addOption('-gravity %s', $gravity)
            ->addOption($watermarkImage)
            ->addOption('"%s"', $this->service->getSource())
            ->addOption('"%s"', $this->service->getDestination(true));
        $cmd->exec();

        return $this->service;

    }

    /**
     * Joins several images in one tab strip.
     *
     * @param array $paths           Array of strings, The paths of images to join.
     * @param string|int $tileWidth
     * @param string|int $tileHeight
     *
     * @return PhLuzia
     */
    public function tile(array $paths = null, $tileWidth = 0, $tileHeight = 1)
    {
        if (is_null($paths)) {
            $paths = $this->service->getHistory(History::TO_ARRAY);
        }

        $cmd = new Command('montage', $this->service);

        if ($this->service->isLibrary(PHLUZIA_LIBRARY_GRAPHICSMAGICK)) {
            // @todo Get working with Graphicsmagick
            $cmd->addOption('-tile %dx%d -geometry 0x0+0+0', $tileWidth, $tileHeight);
        } else {
            $cmd->addOption('-geometry x+0+0 -tile %dx%d', $tileWidth, $tileHeight);
        }

        $cmd->addOption(implode(' ', $paths))
            ->addOption('"%s"', $this->service->getDestination());
        $cmd->exec();

        return $this->service;
    }

    /**
     * Attempts to create an image(s) from a File (PDF & Avi are supported on most systems).
     * It grabs the first frame / page from the source file.
     *
     * Imagemagick first converts all frames then deletes all but the first.
     *
     * @param $file The path to file.
     * @param int $frames
     *
     * @return PhLuzia
     */
    public function acquireFrame($file, $frames = 0)
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('"%s"[%d]', $file, $frames)
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }
}
