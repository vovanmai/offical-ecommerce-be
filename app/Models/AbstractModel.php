<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model
{
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->toDateTimeString();
    }
}
