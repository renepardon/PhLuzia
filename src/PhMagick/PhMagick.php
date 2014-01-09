<?php

namespace PhMagick;

use PhMagick\Adapter\AdapterInterface;

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
 * @author     Nuno Costa, <sven@francodacosta.com> (Initial Author)
 * @copyright  2014 by Christoph, René Pardon
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt
 * @version    1.0
 * @link       http://www.francodacosta.com/phmagick
 * @since      2013-01-09
 */
class PhMagick
{
    /**
     * @var array
     */
    private $_availableMethods = array();

    /**
     * @var array
     */
    protected $loadedPlugins = array();

    /**
     * win/lin is the indicator for the value.
     *
     * @var boolean
     */
    protected $escapeChars = null;

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
     * We don't need all functionality for every operation. For this we have an
     * adapter structure to only load features we need for current tasks.
     *
     * @var array
     */
    protected $adapters = array();

    /**
     * Throws/Triggers Exceptions and Errors if set to true.
     *
     * @var bool
     */
    protected $debug = false;

    /**
     * Contains executed commands.
     *
     * @var array
     */
    private $log = array();

    /**
     * Initialize PhMagick with source file and target/destination path.
     *
     * @param string $sourceFile
     * @param string $destinationFile
     */
    public function __construct($sourceFile, $destinationFile = null)
    {
        $this->originalFile = (string)$sourceFile;
        $this->setSource($sourceFile);

        if (null === $destinationFile) {
            $this->setDestination($this->getSource());
        } else {
            $this->setDestination($destinationFile);
        }

        if (is_null($this->escapeChars)) {
            $this->escapeChars = !(strtolower(substr(php_uname('s'), 0, 3)) == "win");
        }
    }

    /**
     * Execute the command against installed library (Imagemagick/Graphicsmagick)
     *
     * @param string $cmd
     * @return null|string|int
     */
    public function execute($cmd)
    {
        $ret = null;
        $out = array();

        if ($this->escapeChars) {
            $cmd = str_replace('(', '\(', $cmd);
            $cmd = str_replace(')', '\)', $cmd);
        }

        exec($cmd . ' 2>&1', $out, $ret);

        if ($ret != 0) {
            if ($this->debug) {
                trigger_error(new \Exception('Error executing "' . $cmd .
                        '" <br>return code: ' . $ret . ' <br>command output :"' .
                        implode("<br>", $out) . '"'), E_USER_NOTICE
                );
            }
        }

        $this->log[] = array(
            'cmd' => $cmd,
            'return' => $ret,
            'output' => $out
        );

        return $ret;
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
        foreach ($this->_availableMethods as $adapterIdentifier => $methods) {
            if (method_exists($this->adapters[$adapterIdentifier], $method)) {
                array_unshift($args, $this);
                return call_user_func_array(array($this->adapters[$adapterIdentifier], $method), $args);
            }
        }

        throw new \Exception ('Call to undefined method: ' . $method);
    }

    /**
     * Adds an additional adapter to $adapters.
     *
     * @param AdapterInterface $adapter
     *
     * @return PhMagick
     */
    public function addAdapter(AdapterInterface $adapter)
    {
        // Prevent adapters from being added more than once by using the unique
        // identifier as key for our adapters.
        $identifier = $adapter->getIdentifier();
        $this->adapters[$identifier] = $adapter;
        // Retrieve the available methods from adapter.
        $this->_availableMethods[$identifier] = $adapter->getAvailableMethods();

        return $this;
    }

    /**
     * Sets multiple adapters at once.
     *
     * @param array $adapters
     *
     * @return PhMagick
     */
    public function setAdapters(array $adapters)
    {
        array_walk($adapters, array($this, '_convertAdapters'));

        // Reset, because we "set" adapters.
        $this->adapters = array();

        foreach ($adapters as $adapter) {
            $this->addAdapter($adapter);
        }

        return $this;
    }

    /**
     * Covnert $adapter to correct format for $adapters.
     *
     * @param string|AdapterInterface $adapter
     * @param string $key
     *
     * @throws \Exception
     */
    private function _convertAdapters(&$adapter, $key)
    {
        // That's what we want :)
        if ($adapter instanceof AdapterInterface) {
            return;
        }

        if (is_string($adapter)) {
            $class = 'PhMagick\Adapter\\' . ucfirst($adapter);

            if (class_exists($class)) {
                $adapter = new $class();
                return;
            }
        }

        throw new \Exception('Unknown adapter/type provided');
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
     * @return PhMagick
     */
    public function setSource($path)
    {
        $this->source = str_replace(' ', '\ ', (string)$path);

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
     * @return PhMagick
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
     * @return string
     */
    public function getDestination()
    {
        if (($this->destination == '')) {
            $source = $this->getSource();
            $ext = end(explode('.', $source));
            $this->destination = sprintf("%s/%s.%s", dirname($source), md5(microtime()), $ext);
        }

        return $this->destination;
    }

    /**
     * Sets $imageMagickPath.
     *
     * @param string $path
     *
     * @return PhMagick
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
     * @return PhMagick
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
     * @return PhMagick
     */
    public function setHistory($path)
    {
        $this->history[] = $path;

        return $this;
    }

    /**
     * Clear the history.
     *
     * @return PhMagick
     */
    public function clearHistory()
    {
        unset ($this->history);
        $this->history = array();

        return $this;
    }
}
