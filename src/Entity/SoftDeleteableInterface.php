<?php

namespace App\Entity;

interface SoftDeleteableInterface
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_DELETED = 'deleted';

    public function setAsDeleted(): void;

    public function isDeleted(): bool;
}