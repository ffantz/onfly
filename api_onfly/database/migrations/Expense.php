<?php

namespace App\Models;

class Expense
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'date',
        'users_id',
        'cost',
    ];
}
