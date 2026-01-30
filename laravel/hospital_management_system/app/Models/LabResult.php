<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResult extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'test_date' => 'datetime',
        'result_date' => 'datetime',
        'is_abnormal' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }
}
