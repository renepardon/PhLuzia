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
class Decorations extends AdapterAbstract
{
    /**
     * Create round corners and apply to current image.
     *
     * @param int $i Radius to use.
     *
     * @return PhLuzia
     */
    public function roundCorners($i = 15)
    {
        // @todo Get working with Graphicsmagick
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('"%s"', $this->service->getSource())
            ->addOption(
                '( +clone -threshold -1 -draw "fill black polygon 0,0 0,%d %d,0 fill white circle %d,%d %d,0" ( +clone -flip )',
                $i, $i, $i, $i, $i
            )
            ->addOption('-compose Multiply -composite ( +clone -flop )')
            ->addOption('-compose Multiply -composite )')
            ->addOption('+matte')
            ->addOption('-compose CopyOpacity')
            ->addOption('-composite "%s"', $this->service->getDestination());
        $cmd->exec();

        return $this->service;
    }

    /**
     * Create a drop shadow on current image.
     *
     * @param string $color
     * @param int $offset
     * @param int $transparency
     * @param int $top
     * @param int $left
     *
     * @return PhLuzia
     */
    public function dropShadow($color = '#000000', $offset = 4, $transparency = 60, $top = 4, $left = 4)
    {
        $top = $top > 0 ? '+' . $top : $top;
        $left = $left > 0 ? '+' . $left : $left;

        // @todo Get working with Graphicsmagick
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('-page %d%d "%s"', $top, $left, $this->service->getSource())
            ->addOption(
                '-matte ( +clone -background "%d" -shadow %dx4+%d+%d ) +swap',
                $color, $transparency, $offset, $offset
            )
            ->addOption('-background none -mosaic')
            ->addOption('"%s"', $this->service->getDestination());
        $cmd->exec();

        return $this->service;
    }

    /**
     * Create a glow effect.
     *
     * @param string $color
     * @param int $offset
     * @param int $transparency
     *
     * @return PhLuzia
     */
    public function glow($color = '#827f00', $offset = 10, $transparency = 60)
    {
        list ($w, $h) = $this->service->getInfo($this->service->getSource());
        $cOffset = ($offset / 4);

        // @todo Get working with Graphicsmagic
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('"%s"', $this->service->getSource())
            ->addOption(
                '( +clone  -background "%s"  -shadow %dx%d-%d+%d ) +swap -background none -layers merge +repage',
                $color, $transparency, $offset, $cOffset, $cOffset
            )
            ->addOption('"%s"', $this->service->getDestination());
        $cmd->exec();

        return $this->service;
    }

    /**
     * Fake polaroid effect (white border and rotation)
     *
     * @param int $rotate The Image will be rotated n degrees.
     * @param string $borderColor Drop shadow color.
     * @param string $background Image background color (use for jpegs or images
     *                            that do not support transparency or you will
     *                            end up with a black background).
     *
     * @return PhLuzia
     */
    public function fakePolaroid($rotate = 6, $borderColor = "#fff", $background = "none")
    {
        // @todo Get working with Graphicsmagick
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('"%s"', $this->service->getSource())
            ->addOption(
                '-bordercolor "%s"  -border 6 -bordercolor grey60 -border 1 -background  "none"   -rotate %d -background  black  ( +clone -shadow 60x4+4+4 ) +swap -background  "%s"   -flatten',
                $borderColor, $rotate, $background
            )
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     * Real polaroid effect, supports text
     *
     * @param null $format Text format for image label.
     * @param int $rotation The image will be rotated n degrees
     * @param string $borderColor Polaroid border (usually white)
     * @param string $shadowColor Drop shadow color.
     * @param string $background Image background color (use for jpegs or
     *                             images that do not support transparency or
     *                             you will end up with a black background)
     *
     * @return PhLuzia
     */
    public function polaroid($format = null, $rotation = 6, $borderColor = "snow", $shadowColor = "black", $background = "none")
    {
        $formatName = (is_object($format)) ? explode('\\', get_class($format)) : array();

        if ('TextObject' != end($formatName)) {
            $tmp = new TextObject();

            if (is_string($format)) {
                $tmp->setText($format);
            }

            $format = $tmp;
        }

        $cmd = new Command('convert', $this->service);
        $cmd->addOption('"%s"', $this->service->getSource());

        if ($format->getBackground() !== false) {
            $cmd->addOption('-background "%s"', $format->getBackground());
        }

        if ($format->getColor() !== false) {
            $cmd->addOption('-fill "%s"', $format->getColor());
        }

        if ($format->getFont() !== false) {
            $cmd->addOption('-font %s', $format->getFont());
        }

        if ($format->getFontSize() !== false) {
            $cmd->addOption('-pointsize %d', $format->getFontSize());
        }

        if ($format->getGravity() !== false) {
            $cmd->addOption('-gravity %s', $format->getGravity());
        }

        if ($format->getText() != '') {
            $cmd->addOption('-set caption "%s"', $format->getText());
        }

        $cmd->addOption('-bordercolor "%s" -background "%s" -polaroid %d -background "%s" -flatten', $borderColor, $background, $rotation, $background)
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }

    /**
     * Create a border around current image.
     *
     * @param string $borderColor
     * @param int $borderSize
     *
     * @return PhLuzia
     */
    public function border($borderColor = "#000", $borderSize = 1)
    {
        $cmd = new Command('convert', $this->service);
        $cmd->addOption('"%s"', $this->service->getSource())
            ->addOption('-bordercolor "%s" -border %d', $borderColor, $borderSize)
            ->addOption('"%s"', $this->service->getDestination());

        $cmd->exec();

        return $this->service;
    }
}
