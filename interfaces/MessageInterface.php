<?php

namespace tina\postManager\interfaces;

use tina\postManager\models\PostManager;

/**
 * Interface MessageInterface
 *
 * @package tina\subscriber\interfaces
 */
interface MessageInterface
{
    /**
     * @param PostManager $model
     *
     * @return mixed
     */
    public function make(PostManager $model);
}
