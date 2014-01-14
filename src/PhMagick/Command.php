<?php

namespace PhMagick;

use PhMagick\Service\PhMagick as Service;

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
class Command
{
    /**
     * The binary to use.
     *
     * @var string
     */
    protected $binary;

    /**
     * Options which gets appended to the binary command.
     *
     * @var array
     */
    protected $options = array();

    /**
     * win/lin is the indicator for the value.
     *
     * @var boolean
     */
    protected $escapeChars = null;

    /**
     * Create a new command for provided binary.
     *
     * @param string $binary
     * @param Service $service
     */
    public function __construct($binary, Service $service)
    {
        $this->service = $service;

        if ($this->service->isLibrary(PHMAGICK_LIBRARY_GRAPHICSMAGICK)) {
            $this->binary = 'gm ' . (string)$binary;
        } else {
            $this->binary = (string)$binary;
        }

        if (is_null($this->escapeChars)) {
            $this->escapeChars = !(strtolower(substr(php_uname('s'), 0, 3)) == "win");
        }
    }

    /**
     * Adds an option to the command.
     *
     * @return Command
     * @throws \Exception We need at least one argument.
     */
    public function addOption()
    {
        if (0 == func_num_args()) {
            throw new \Exception('Invalid argument count. Expected at least one argument');
        }

        $args = func_get_args();
        $format = $args[0];
        array_shift($args);

        $this->options[] = vsprintf($format, $args);

        return $this;
    }

    /**
     * Executes the command through system call.
     *
     * @return array      Executed command, return code from system call and
     *                    output of system call as array.
     * @throws \Exception If execution fails.
     */
    public function exec()
    {
        $return = null;
        $out = array();
        $cmd = join(' ', $this->options);

        if ($this->escapeChars) {
            $cmd = str_replace('(', '\(', $cmd);
            $cmd = str_replace(')', '\)', $cmd);
        }

        exec($this->binary . ' ' . $cmd . ' 2>&1', $out, $return);

        if ($return != 0) {
            throw new \Exception(
                sprintf(
                    "Error executing '%s' \nReturn code: %d \nCommand output : '%s'",
                    $cmd,
                    $return,
                    implode("\n", $out)
                )
            );
        }

        $this->service->setSource($this->service->getDestination());
        $this->service->setHistory($this->service->getDestination());

        return array($cmd, $return, $out);
    }
}