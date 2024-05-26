<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Complaint_Ban extends Pivot
{
    use HasFactory;


    protected $table = 'complaint_ban';

    protected $fillable = ['complaint_id', 'ban_id'];

}
