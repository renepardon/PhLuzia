<?php

namespace PhLuzia\Adapter;

use PhLuzia\Command;
use PhLuzia\Service\PhLuzia;
use PhLuzia\TextObject;

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
class Text extends AdapterAbstract
{
    /**
     * Draws an image with the submitted string. Useful for watermarks.
     *
     * @param string $text       The text to draw an image from
     * @param TextObject $format The text configuration
     *
     * @return PhLuzia
     */
    public function fromString($text = '', TextObject $format = null)
    {
        if (is_null($format)) {
            $format = new TextObject();
        }

        $cmd = new Command('convert', $this->service);

        if ($format->getBackground()) {
            $cmd->addOption('-background "%s"', $format->getBackground());
        }

        if ($format->getColor() !== false) {
            $cmd->addOption('-fill "%s"', $format->getColor());
        }

        if ($format->getFont() !== false) {
            $cmd->addOption('-font %s', $format->getFont());
        }

        if ($format->getFontSize() !== false) {
            $cmd->addOption('-pointsize "%d"', $format->getFontSize());
        }

        if (($format->getText() != '') && ($text = '')) {
            $text = $format->getText();
        }

        $cmd->addOption('label:"%s"', $text);
        $cmd->addOption('"%s"', $this->service->getDestination(true));

        $cmd->exec();

        return $this->service;
    }
}
