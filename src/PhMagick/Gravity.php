<?php

namespace PhMagick;

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
 * @package    PhMagick
 * @author     Christoph, René Pardon <christoph@renepardon.de>
 * @copyright  2014 by Christoph, René Pardon
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt
 * @version    1.0
 * @link       https://github.com/renepardon/PhMagick
 * @since      2013-01-09
 */
class Gravity
{
    /**
     * @var string
     */
    const None = 'None';

    /**
     * @var string
     */
    const Center = 'Center';

    /**
     * @var string
     */
    const East = 'East';

    /**
     * @var string
     */
    const Forget = 'Forget';

    /**
     * @var string
     */
    const NorthEast = 'NorthEast';

    /**
     * @var string
     */
    const North = 'North';

    /**
     * @var string
     */
    const NorthWest = 'NorthWest';

    /**
     * @var string
     */
    const SouthEast = 'SouthEast';

    /**
     * @var string
     */
    const South = 'South';

    /**
     * @var string
     */
    const SouthWest = 'SouthWest';

    /**
     * @var string
     */
    const West = 'West';
}