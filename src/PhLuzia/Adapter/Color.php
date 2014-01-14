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
class Color extends AdapterAbstract
{
    /**
     * Makes current image darker.
     *
     * @param int $alphaValue
     *
     * @return PhLuzia
     */
    public function darken($alphaValue = 50)
    {
        $percent = 100 - (int)$alphaValue;

        // Get original file dimensions.
        list ($width, $height) = $this->service->getInfo();

        $cmd = new Command('composite', $this->service);

        if (PHLUZIA_LIBRARY_GRAPHICSMAGICK == $this->service->getOptions()['library']) {
            $cmd->addOption('-dissolve %d', $percent);
        } else {
            $cmd->addOption('-blend %d', $percent);
        }

        $cmd->addOption('"%s"', $this->service->getSource())
            ->addOption('-size %dx%d xc:black', $width, $height)
            ->addOption('-matte "%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     * Brightens current image, default: 50%.
     *
     * 100%: white , 0%: original color (no change)
     *
     * @param int $alphaValue
     *
     * @return PhLuzia
     */
    public function brighten($alphaValue = 50)
    {
        $percent = 100 - (int)$alphaValue;

        // Get original file dimensions.
        list ($width, $height) = $this->service->getInfo();

        $cmd = new Command('composite', $this->service);

        if (PHLUZIA_LIBRARY_GRAPHICSMAGICK == $this->service->getOptions()['library']) {
            $cmd->addOption('-dissolve %d', $percent);
        } else {
            $cmd->addOption('-blend %d', $percent);
        }

        $cmd->addOption('"%s"', $this->service->getSource())
            ->addOption('-size %dx%d xc:white', $width, $height)
            ->addOption('-matte "%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     * Convert current image to grey scale.
     *
     * @param int $enhance
     *
     * @return PhLuzia
     */
    public function toGreyScale($enhance = 2)
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-modulate 100,0');

        if (PHLUZIA_LIBRARY_IMAGEMAGICK == $this->service->getOptions()['library']) {
            $cmd->addOption('-sigmoidal-contrast %dx50%%', $enhance);
        }

        $cmd->addOption('-background "none" "%s"', $this->service->getSource())
            ->addOption('"%s"', $this->service->getDestination());
        $cmd->exec();

        return $this->service;
    }

    /**
     * Inverts the image colors.
     *
     * @return PhLuzia
     */
    public function invertColors()
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('"%s"', $this->service->getSource());
        $cmd->addOption('-negate');
        $cmd->addOption('"%s"', $this->service->getDestination());
        $cmd->exec();

        return $this->service;
    }

    /**
     * Applies sepia filter to current image.
     *
     * @param int $tone Ignored with Graphicsmagick
     *
     * @return PhLuzia
     */
    public function sepia($tone = 90)
    {
        $cmd = new Command('convert', $this->service);

        if (PHLUZIA_LIBRARY_GRAPHICSMAGICK == $this->service->getOptions()['library']) {
            // @todo Play with values to get real sepia!!!
            $cmd->addOption('-modulate 115,0,100')
                ->addOption('-colorize 7,21,50')
                ->addOption('"%s"', $this->service->getSource());
        } else {
            $cmd->addOption('-sepia-tone %d%%', $tone)
                ->addOption('-modulate 100,50')
                ->addOption('-normalize')
                ->addOption('-set colorspace RGB')
                ->addOption('-background "none" "%s"', $this->service->getSource());
        }

        $cmd->addOption('"%s"', $this->service->getDestination());
        $cmd->exec();

        return $this->service;
    }

    /**
     * autoLevels.
     *
     * Normalization of image.
     *
     * @return PhLuzia
     */
    public function autoLevels()
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-normalize') // @todo Fix Graphicsmagic? version - Image becomes red.
            ->addOption('-background "none" "%s"', $this->service->getSource());
        $cmd->addOption('"%s"', $this->service->getDestination());
        $cmd->exec();

        return $this->service;
    }
}
