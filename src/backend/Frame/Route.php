<?php

declare(strict_types=1);

namespace App\backend\Frame;

interface Route
{
    public function getRoutes(): array;
    public function getTemplate(): string;
    public function getRestrict(): array;
}
