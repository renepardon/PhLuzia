<?php

namespace PhLuzia\Adapter;

use PhLuzia\Command;
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
class Resize extends AdapterAbstract
{
    /**
     * Resize current image.
     *
     * @param $width
     * @param int $height
     * @param bool $exactDimensions
     *
     * @return PhLuzia
     */
    public function resize($width, $height = 0, $exactDimensions = false)
    {
        $modifier = $exactDimensions ? '!' : '>';

        // If $width or $height == 0 then we want to resize to fit one measure.
        // If any of them is sent as 0 resize will fail because we are trying to resize to 0 px.
        $width = $width == 0 ? '' : $width;
        $height = $height == 0 ? '' : $height;

        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-scale "%dx%d%s"', $width, $height, $modifier)
            ->addOption('-quality %d', $this->service->getImageQuality())
            ->addOption('-strip')
            ->addOption('"%s" "%s"',
                $this->service->getSource(),
                $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     * Tries to resize an image to the exact size wile mantaining aspect ratio,
     * the image will be cropped to fit the measures.
     *
     * @param int $width
     * @param int $height
     *
     * @return PhLuzia
     */
    public function resizeExactly($width, $height)
    {
        list($w, $h) = $this->service->getInfo($this->service->getSource());

        if ($w > $h) {
            $h = $height;
            //$w = 0;
        } else {
            //$h = 0;
            $w = $width;
        }

        $this->resize($w, $h)->crop($width, $height);

        return $this->service;
    }

    /**
     * Creates a thumbnail of an image if it doesn't exists.
     *
     * @param $imageUrl             The iamge URI
     * @param $width
     * @param $height
     * @param bool $exactDimensions If false: resizes the image to the exact
     *                              porportions (aspect ratio not preserved).
     *                              If true: preserves aspect ratio, only
     *                              resises if image is bigger than specified measures
     * @param string $webPath
     * @param string $physicalPath
     *
     * @return string The thumbnail URI
     */
    public function onTheFly($imageUrl, $width, $height, $exactDimensions = false, $webPath = '', $physicalPath = '')
    {
        // Convert web path to physical.
        $basePath = str_replace($webPath, $physicalPath, dirname($imageUrl));
        $sourceFile = $basePath . '/' . basename($imageUrl);;

        // Naming the new thumbnail.
        $thumbnailFile = $basePath . '/' . $width . '_' . $height . '_' . basename($imageUrl);

        $this->service->setSource($sourceFile);
        $this->service->setDestination($thumbnailFile);

        if (!file_exists($thumbnailFile)) {
            $this->resize($width, $height, $exactDimensions);
        }

        if (!file_exists($thumbnailFile)) {
            // If there was an error, just use original file.
            $thumbnailFile = $sourceFile;
        }

        // Returning the thumbnail url.
        return str_replace($physicalPath, $webPath, $thumbnailFile);
    }
}