<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AttendanceModel;
use App\Models\EventModel;

class AttendanceController extends ResourceController {
    
    // Fetch events for the FullCalendar JS
    public function getEvents() {
        $model = new EventModel();
        $events = $model->findAll();
        
        $data = [];
        foreach($events as $row) {
            $data[] = [
                'id'    => $row['id'],
                'title' => $row['title'],
                'start' => $row['start_event'],
                'end'   => $row['end_event'],
                'color' => $row['color']
            ];
        }
        return $this->respond($data);
    }

    // Admin function to edit attendance
    public function updateAttendance($id = null) {
        $model = new AttendanceModel();
        $data = [
            'status'  => $this->request->getVar('status'),
            'remarks' => $this->request->getVar('remarks')
        ];
        
        if($model->update($id, $data)) {
            return $this->respond(['message' => 'Record updated successfully']);
        }
    }
}