<?php

namespace tina\postManager\interfaces;

use yii\mail\MessageInterface as BaseMessageInterface;

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
     * @return BaseMessageInterface
     */
    public function make(PostManagerInterface $model): BaseMessageInterface;
}
