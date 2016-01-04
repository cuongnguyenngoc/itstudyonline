<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyManager extends Model
{
    protected $table = "moneymanager";
    protected $fillable = ['user_id', 'card_type', 'card_id', 'card_seri'];
    public $timestamps = false;
}
