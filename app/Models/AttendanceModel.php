<?php 

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model 
{
    protected $table      = 'attendance';
    protected $primaryKey = 'id';

    // This is the most important part. 
    // It tells CodeIgniter which columns it is allowed to write to.
    protected $allowedFields = [
        'student_id', 
        'event_id', 
        'status', 
        'remarks', 
        'time_in', 
        'time_out', 
        'date'
    ];

    protected $useTimestamps = false; // Set to true if you have created_at columns
}