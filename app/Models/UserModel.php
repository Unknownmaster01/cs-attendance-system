<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    // app/Models/UserModel.php
protected $allowedFields = ['full_name', 'email', 'course', 'id_number', 'password', 'year_level_id', 'role', 'profile_pic'];
}