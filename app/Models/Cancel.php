<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancel extends Model
{
    use HasFactory;
    
    protected $fillable = ['cancel_date'];
    
    public function reserve()
    {
        return $this->belongsTo(Reserve::class);
    }
    
}
