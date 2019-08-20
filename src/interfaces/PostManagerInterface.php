<?php

namespace tina\postManager\interfaces;

/**
 * Interface PostManagerInterface
 */
interface PostManagerInterface
{
    /**
     * @return array
     */
    public function attributeTypes(): array;

    /**
     * @param array $data
     *
     * @return bool
     */
    public function populate(array $data): bool;
}
