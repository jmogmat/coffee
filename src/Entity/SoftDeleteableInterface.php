<?php

namespace App\Entity;

/**
 * Explicar esta funcionalidad en el fichero README, porque la usamos.
 */

interface SoftDeleteableInterface
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_DELETED = 'deleted';

    public const STATUS_PENDING = 'pending';

    public function setAsDeleted(): void;

    public function isDeleted(): bool;
}