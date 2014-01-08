<?php
namespace PhMagick\Adapter;

interface AdapterInterface
{
    /**
     * Returns an unique identifier for the current adapter.
     *
     * @return mixed
     */
    public function getIdentifier();

    /**
     * Returns an array of names from methods the current adapter implements.
     *
     * @return mixed
     */
    public function getAvailableMethods();
}