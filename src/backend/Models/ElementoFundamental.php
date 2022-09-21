<?php

declare(strict_types=1);

namespace App\backend\Models;

use Illuminate\Database\Eloquent\Model;

class ElementoFundamental extends DatabaseTable
{
    public const TABLE = 'elemento_fundamental';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id');
    }
}
