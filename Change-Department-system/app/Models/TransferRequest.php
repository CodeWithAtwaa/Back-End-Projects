<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'from_department_id',
        'to_department_id',
        'reason',
        'status',
        'reviewer_comment',
        'admin_comment',
    ];


    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function fromDepartment()
    {
        return $this->belongsTo(Department::class, 'from_department_id');
    }

    public function toDepartment()
    {
        return $this->belongsTo(Department::class, 'to_department_id');
    }


    
}
