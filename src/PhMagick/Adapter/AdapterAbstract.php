<?php

namespace PhMagick\Adapter;

use PhMagick\Service\PhMagick as Service;
use Zend\Config\Config;

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
 * @link       https://github.com/renepardon/PhMagick
 * @since      2013-01-09
 */
abstract class AdapterAbstract implements AdapterInterface
{
    /**
     * @var array|Config
     */
    protected $options = array();

    /**
     * @var null|Service
     */
    protected $service = null;

    /**
     * Initialize adapter with configuration options (defaults) and dynamic
     * options (image offset, target, ...)
     *
     * @param Service $phMagick
     */
    public function __construct(Service $phMagick)
    {
        $this->service = $phMagick;
        $this->options = $this->service->getOptions();
    }
}