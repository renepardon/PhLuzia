<?php
namespace PhMagick\Adapter;

use PhMagick\PhMagick;

class Cli extends AdapterAbstract
{
    use AdapterTrait;

    /**
     * @var string
     */
    const IDENTIFIER = 'PhMagick\Adapter\Cli';

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods()
    {
        return array(
            'cmd',
        );
    }

    public function cmd(PhMagick $p, $string)
    {
		/*var list
		  %width
		  %height
		  %source
		  %destination
		  %tmp  
		 */
	}
}