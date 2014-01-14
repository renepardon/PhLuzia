<?php

namespace PhLuzia\Service;

use PhLuzia\History;
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
 * @package    PhLuzia\Service
 * @author     Christoph, René Pardon <christoph@renepardon.de>
 * @copyright  2014 by Christoph, René Pardon
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt
 * @version    1.0
 * @link       https://github.com/renepardon/PhLuzia
 * @since      2013-01-09
 */
class PhLuzia
{
    /**
     * @var array|\Zend\Config\Config
     */
    protected $options = array();

    /**
     * @var array
     */
    protected $history = array();

    /**
     * Path to original file.
     *
     * @var string
     */
    protected $originalFile = '';

    /**
     * Source image file/path.
     *
     * @var string
     */
    protected $source = '';

    /**
     * Destination file/path.
     *
     * @var string
     */
    protected $destination = '';

    /**
     * Path to Image Magick.
     *
     * @var string
     */
    protected $imageMagickPath = '';

    /**
     * Quality of edited image.
     *
     * @var int
     */
    protected $imageQuality = 100;

    /**
     * Contains executed commands.
     *
     * @var array
     */
    private $log = array();

    /**
     * Initialize PhLuzia service with configuration options.
     *
     * @param Config|array $options
     */
    public function __construct($options)
    {
        $this->options = is_array($options) ? $options : $options->toArray();
    }

    /**
     * Gets $options.
     *
     * @return array|Config
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Gets file information.
     *
     * Returns the size of provided image or size of image stored within $source
     * if no $file is provided.
     *
     * @param string $file
     *
     * @return array
     */
    public function getInfo($file = '')
    {
        if ($file == '') {
            $file = $this->getSource();
        }

        return getimagesize($file);
    }

    /**
     * Get width of image.
     *
     * @param string $file
     *
     * @return mixed
     */
    public function getWidth($file = '')
    {
        list($width, $height, $type, $attr) = $this->getInfo($file);

        return $width;
    }

    /**
     * Get height of image.
     *
     * @param string $file
     *
     * @return mixed
     */
    public function getHeight($file = '')
    {
        list($width, $height, $type, $attr) = $this->getInfo($file);

        return $height;
    }

    /**
     * Get size of image in Bits.
     *
     * @param string $file
     *
     * @return mixed
     */
    public function getBits($file = '')
    {
        if ($file == '') {
            $file = $this->getSource();
        }

        $info = getimagesize($file);

        return $info["bits"];
    }

    /**
     * Gets MIME type of image.
     *
     * @param string $file
     *
     * @return mixed
     */
    public function getMime($file = '')
    {
        if ($file == '') {
            $file = $this->getSource();
        }

        $info = getimagesize($file);

        return $info["mime"];
    }

    /**
     * Tries to call method on injected adapter(s).
     *
     * @param string $method
     * @param array $args
     *
     * @return mixed
     * @throws \Exception Method not found/Error while executing method.
     */
    public function __call($method, $args)
    {
        /*foreach ($this->_availableMethods as $adapterIdentifier => $methods) {
            if (method_exists($this->adapters[$adapterIdentifier], $method)) {
                array_unshift($args, $this);
                return call_user_func_array(array($this->adapters[$adapterIdentifier], $method), $args);
            }
        }*/

        $class = 'PhLuzia\Adapter\\' . ucfirst($method);

        if (class_exists($class)) {
            return new $class($this);
        }

        throw new \Exception ('Call to undefined method: ' . $method);
    }

    /**
     * Check if provided libraray name equals the configured library.
     *
     * @param string $library
     *
     * @return bool
     */
    public function isLibrary($library)
    {
        if ($library == $this->getOptions()['library']) {
            return true;
        }

        return false;
    }

    /**
     * Gets $log.
     *
     * @return array
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Gets binary from Image Magick path.
     *
     * @param string $binName
     *
     * @return string
     */
    public function getBinary($binName)
    {
        return $this->getImageMagickPath() . (string)$binName;
    }

    /**
     * Sets $source.
     *
     * @param string $path
     *
     * @return PhLuzia
     */
    public function setSource($path)
    {
        if (null === $this->originalFile) {
            $this->originalFile = (string)$path;
        }

        $this->source = str_replace(' ', '\ ', (string)$path);

        if (null === $this->getDestination()) {
            $this->setDestination($this->getSource());
        }

        return $this;
    }

    /**
     * Gets $source.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Sets destination path.
     *
     * @param string $path
     *
     * @return PhLuzia
     */
    public function setDestination($path)
    {
        $path = str_replace(' ', '\ ', (string)$path);
        $this->destination = $path;

        return $this;
    }

    /**
     * Gets destination path.
     *
     * @param bool $needsPng This flag is used to trigger a warning if current
     *                       operation needs PNG as destination format but
     *                       another format is given.
     *
     * @return string
     */
    public function getDestination($needsPng = false)
    {
        if (($this->destination == '')) {
            $source = $this->getSource();
            $sourceParts = explode('.', $source);
            $ext = end($sourceParts);
            $this->destination = sprintf("%s/%s.%s", dirname($source), md5(microtime()), $ext);
        }

        if (true === $needsPng) {
            $sourceParts = explode('.', $this->destination);
            $ext = strtolower(end($sourceParts));

            if ('png' != $ext) {
                trigger_error(
                    'File operation needs PNG format for target file.',
                    E_USER_NOTICE
                );
            }
        }

        return $this->destination;
    }

    /**
     * Sets $imageMagickPath.
     *
     * @param string $path
     *
     * @return PhLuzia
     */
    public function setImageMagickPath($path)
    {
        if ($path != '') {
            if (strpos($path, '/') < strlen($path)) {
                $path .= '/';
            }
        }

        $this->imageMagickPath = str_replace(' ', '\ ', (string)$path);

        return $this;
    }

    /**
     * Gets $imageMagickPath.
     *
     * @return string
     */
    public function getImageMagickPath()
    {
        return $this->imageMagickPath;
    }

    /**
     * Sets $imageQuality.
     *
     * @param int $value
     *
     * @return PhLuzia
     */
    public function setImageQuality($value)
    {
        $this->imageQuality = intval($value);

        return $this;
    }

    /**
     * Gets $imageQuality.
     *
     * @return int
     */
    public function getImageQuality()
    {
        return $this->imageQuality;
    }

    /**
     * Get history of executed commands?
     *
     * @param int $type
     *
     * @return array
     */
    public function getHistory($type = null)
    {
        switch ($type) {
            case History::TO_CSV:
                return explode(',', array_unique($this->history));
            case History::TO_ARRAY:
            default:
                return array_unique($this->history);
        }
    }

    /**
     * Adds element to $history.
     *
     * @param string $path
     *
     * @return PhLuzia
     */
    public function setHistory($path)
    {
        $this->history[] = $path;

        return $this;
    }

    /**
     * Clear the history.
     *
     * @return PhLuzia
     */
    public function clearHistory()
    {
        unset($this->history);
        $this->history = array();

        return $this;
    }
}