<?php

namespace tina\postManager\interfaces;

/**
 * Interface MessageInterface
 *
 * @package tina\subscriber\interfaces
 */
interface MessageInterface
{
    /**
     * @param $model
     *
     * @return mixed
     */
    public function make($model);
}
