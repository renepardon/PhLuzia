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
class TextObject
{
    /**
     * @var int
     */
    protected $fontSize = 12;

    /**
     * @var string|bool
     */
    protected $font = false;

    /**
     * @var string
     */
    protected $color = '#000000';

    /**
     * @var string|bool
     */
    protected $background = 'none';

    /**
     * @var string
     */
    protected $pGravity = Gravity::Center;

    /**
     * This is the text which gets displayed/rendered as/into image.
     *
     * @var string
     */
    protected $pText = '';

    /**
     * Tries to return property value.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * Sets $background.
     *
     * @param boolean $background
     *
     * @return TextObject
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Gets $background.
     *
     * @return boolean
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Sets $color.
     *
     * @param string $color
     *
     * @return TextObject
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Gets $color.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Sets $font.
     *
     * @param boolean $font
     *
     * @return TextObject
     */
    public function setFont($font)
    {
        $this->font = $font;

        return $this;
    }

    /**
     * Gets $font.
     *
     * @return boolean
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * Sets $fontSize.
     *
     * @param int $fontSize
     *
     * @return TextObject
     */
    public function setFontSize($fontSize)
    {
        $this->fontSize = $fontSize;

        return $this;
    }

    /**
     * Gets $fontSize.
     *
     * @return int
     */
    public function getFontSize()
    {
        return $this->fontSize;
    }

    /**
     * Sets $pGravity.
     *
     * @param string $pGravity
     *
     * @return TextObject
     */
    public function setGravity($pGravity)
    {
        $this->pGravity = $pGravity;

        return $this;
    }

    /**
     * Gets $pGravity.
     *
     * @return string
     */
    public function getGravity()
    {
        return $this->pGravity;
    }

    /**
     * Sets $pText.
     *
     * @param string $pText
     *
     * @return TextObject
     */
    public function setText($pText)
    {
        $this->pText = (string)$pText;

        return $this;
    }

    /**
     * Gets $pText.
     *
     * @return string
     */
    public function getText()
    {
        return $this->pText;
    }
}