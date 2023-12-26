<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class School extends Model
{
    use HasFactory;

    protected $table = 'schools';

    public static function getDataForGraph()
    {
        $q = DB::table('schools')
            ->select('level', DB::raw('count(*) as num'))
            ->groupBy('level')
            ->pluck('num', 'level')
            ->toArray();

            return $q;
    }
}

