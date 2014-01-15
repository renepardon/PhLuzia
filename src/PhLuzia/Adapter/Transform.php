<?php

namespace PhLuzia\Adapter;

use PhLuzia\Command;
use PhLuzia\Gravity;
use PhLuzia\Service\PhLuzia;

/**
 * Image manipulation library.
 *
 * This library can be used for easy image manipulation with
 * Image Magick/Graphics Magick.
 *
 * PHP version 5
 *
 * LICENSE: LGPL-3.0
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
 * @license    http://www.gnu.org/licenses/lgpl-3.0.txt
 * @version    1.0
 * @link       https://github.com/renepardon/PhLuzia
 * @since      2013-01-09
 */
class Transform extends AdapterAbstract
{
    /**
     * Rotate image by provided amount of degrees.
     *
     * @param int $degrees
     *
     * @return PhLuzia
     */
    public function rotate($degrees = 45)
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-background "transparent"')
            ->addOption('-rotate %d', $degrees)
            ->addOption('"%s"', $this->service->getSource())
            ->addOption('"%s"', $this->service->getDestination(true));

        $cmd->exec();

        return $this->service;
    }

    /**
     * Flips the image vertically.
     *
     * @return PhLuzia
     */
    public function flipVertical()
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-flip')
            ->addOption('"%s"', $this->service->getSource())
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     * Flips the image horizontally.
     *
     * @return PhLuzia
     */
    public function flipHorizontal()
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-flop')
            ->addOption('"%s"', $this->service->getSource())
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     * Flips the image horizontally and vertically.
     *
     * @param int $size
     * @param int $transparency
     *
     * @return PhLuzia
     */
    public function reflection($size = 60, $transparency = 50)
    {
        $source = $this->service->getSource();

        // Invert image.
        $this->flipVertical();

        // Crop it to $size%
        list($w, $h) = $this->service->getInfo($this->service->getDestination(true));
        $this->service->crop($w, $h * ($size / 100), 0, 0, Gravity::None);

        // Make a image fade to transparent.
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('"%s"', $this->service->getSource())
            ->addOption(' ( -size %dx%d gradient: ) ', $w, ($h * ($size / 100)))
            ->addOption('+matte -compose copy_opacity -composite')
            ->addOption('"%s"', $this->service->getDestination(true));

        $cmd->exec();

        // Apply desired transparency, by creating a transparent image and merge
        // the mirros image on to it with the desired transparency.
        $file = dirname($this->service->getDestination(true)) . '/' . uniqid() . '.png';

        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-size %dx%d xc:none', $w, ($h * ($size / 100)))
            ->addOption('"%s"', $file);

        $cmd->exec();

        $cmd = new Command('composite', $this->service);
        $cmd->addOption('-dissolve %d', $transparency)
            ->addOption('"%s"', $this->service->getDestination(true))
            ->addOption($file)
            ->addOption('"%s"', $this->service->getDestination(true));

        $cmd->exec();

        unlink($file);

        // Append the source and the relfex.
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('"%s"', $source)
            ->addOption('"%s"', $this->service->getDestination(true))
            ->addOption('-append')
            ->addOption('"%s"', $this->service->getDestination(true));

        $cmd->exec();

        return $this->service;
    }
}
