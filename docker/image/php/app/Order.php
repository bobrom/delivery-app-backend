<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['product_ids', 'user_id', 'status'];

    protected $hidden = ['created_at', 'updated_at'];
}
