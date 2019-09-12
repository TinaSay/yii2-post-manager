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
     * @param PostManagerInterface $model
     *
     * @return bool
     */
    public function send(PostManagerInterface $model): bool;
}
