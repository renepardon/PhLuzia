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
class Convert extends AdapterAbstract
{
    /**
     * Converts from one format to another.
     *
     * Use the convert program to convert between image formats as well as
     * resize an image, blur, crop, despeckle, dither, draw on, flip, join,
     * re-sample, and much more. See Command Line Processing for advice on how
     * to structure your convert command or see below for example usages of
     * the command.
     *
     * @return PhLuzia
     */
    public function convert()
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-quality %d', $this->service->getImageQuality())
            ->addOption('"%s"', $this->service->getSource())
            ->addOption('"%s"', $this->service->getDestination());
        $cmd->exec();

        return $this->service;
    }
}
