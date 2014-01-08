<?php
namespace PhMagick;

class TextObject
{
    protected $fontSize = 12;
    protected $font = false;

    protected $color = '#000000';
    protected $background = false;

    protected $pGravity = Gravity::Center;
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