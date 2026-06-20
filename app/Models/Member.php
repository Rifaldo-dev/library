<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['member_code', 'name', 'email', 'phone', 'address', 'joined_at'];

    protected $casts = [
        'joined_at' => 'date',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
