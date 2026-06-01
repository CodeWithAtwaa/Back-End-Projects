<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];


    public function students()
    {
        return $this->hasMany(User::class);
    }


    public function transferRequestsFrom()
    {
        return $this->hasMany(TransferRequest::class, 'from_department_id');
    }

 
    public function transferRequestsTo()
    {
        return $this->hasMany(TransferRequest::class, 'to_department_id');
    }
}
