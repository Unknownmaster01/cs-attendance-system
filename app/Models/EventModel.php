<?php namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model {
    protected $table = 'events';
    protected $primaryKey = 'id';
    // Must match your Navicat columns exactly
    protected $allowedFields = ['title', 'description', 'start_event', 'end_event', 'color'];
}