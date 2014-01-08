<?php
namespace PhMagick\Adapter;

trait AdapterTrait
{
    /**
     * Returns an unique identifier for the current adapter.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}