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
class Crop extends AdapterAbstract
{
    /**
     * Crop current image.
     *
     * @param $width
     * @param $height
     * @param int $top The Y coordinate for the left corner of the crop rectangule
     * @param int $left The X coordinate for the left corner of the crop rectangule
     * @param string $gravity The initial placement of the crop rectangule
     *
     * @return PhLuzia
     */
    public function crop($width, $height, $top = 0, $left = 0, $gravity = Gravity::Center)
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption($this->service->getSource());

        if ('' != $gravity || Gravity::None != $gravity) {
            $cmd->addOption('-gravity %s', $gravity);
        }

        $cmd->addOption('-crop %dx%d+%d+%d', $width, $height, $left, $top)
            ->addOption($this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }
}
