<?php 

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EventModel;

class Admin extends Controller {

    // --- DASHBOARD ENTRY POINT ---
    public function index() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $search = trim($this->request->getGet('search') ?? '');

        $eventModel = new EventModel();
        $latestEvent = $eventModel->orderBy('start_event', 'DESC')->first();
        $current_event_id = $latestEvent ? $latestEvent['id'] : 0;

        // ✅ Count students
        $student_count = $db->table('users')
                            ->where('role', 'student')
                            ->countAllResults();

        // ✅ Count events this month
        $event_count = $db->table('events')
                          ->where('MONTH(start_event)', date('m'))
                          ->where('YEAR(start_event)', date('Y'))
                          ->countAllResults();

        // ✅ Count announcements
        $announcement_count = $db->table('announcements')->countAllResults();

        // ✅ Upcoming events for sidebar
        $upcoming_events = $eventModel->orderBy('start_event', 'ASC')
                                      ->findAll(5);

        $data = [
            'current_event_id'   => $current_event_id,
            'event_name'         => $latestEvent ? $latestEvent['title'] : 'No Active Event',
            'search_query'       => $search,
            'student'            => null,
            'student_count'      => $student_count,
            'event_count'        => $event_count,
            'announcement_count' => $announcement_count,
            'upcoming_events'    => $upcoming_events,
        ];

        if (!empty($search)) {
            $builder = $db->table('users');
            $builder->select('users.id_number, users.full_name, users.course, users.year_level_id, users.profile_pic, attendance.time_in, attendance.time_out');
            $builder->join('attendance', "attendance.student_id = users.id_number AND attendance.event_id = $current_event_id", 'left');
            $builder->where('users.id_number', $search);
            $data['student'] = $builder->get()->getRowArray();
        }

        return view('admin/admin_dashboard', $data); 
    }

    // --- VIEW SPECIFIC STUDENT PROFILE ---
    public function view_student($id_number) {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        
        $student = $db->table('users')
                      ->where('id_number', $id_number)
                      ->where('role', 'student')
                      ->get()
                      ->getRowArray();

        if (!$student) {
            return redirect()->to(base_url('admin/students'))->with('error', 'Student not found.');
        }

        $eventModel = new EventModel();
        $latestEvent = $eventModel->orderBy('start_event', 'DESC')->first();
        $current_event_id = $latestEvent ? $latestEvent['id'] : 0;

        $attendance = null;
        if ($current_event_id > 0) {
            $attendance = $db->table('attendance')
                             ->where('student_id', $id_number)
                             ->where('event_id', $current_event_id)
                             ->get()
                             ->getRowArray();
        }

        $yearLevelMap = ['1' => '1st Year', '2' => '2nd Year', '3' => '3rd Year', '4' => '4th Year'];
        $student['year_level'] = $yearLevelMap[$student['year_level_id'] ?? ''] ?? 'Year ' . ($student['year_level_id'] ?? '');

        $data = [
            'student'          => $student,
            'attendance'       => $attendance,
            'current_event_id' => $current_event_id,
            'event_name'       => $latestEvent ? $latestEvent['title'] : 'No Active Event'
        ];

        return view('admin/view_student', $data);
    }

    // --- ALL REGISTERED STUDENTS LIST ---
    public function students() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $search = trim($this->request->getGet('search') ?? '');

        $builder = $db->table('users');
        $builder->where('role', 'student');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('full_name', $search)
                    ->orLike('id_number', $search)
                    ->groupEnd();
        }

        $data['students'] = $builder->orderBy('full_name', 'ASC')->get()->getResultArray();
        $data['search_query'] = $search;

        return view('admin/student_list', $data);
    }

    // ✅ --- ATTENDANCE LOG (fixes the 404) ---
    public function check_attendance() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $eventModel = new EventModel();
        $latestEvent = $eventModel->orderBy('start_event', 'DESC')->first();
        $current_event_id = $latestEvent ? $latestEvent['id'] : 0;

        // Get specific student search if coming from view_student History button
        $search = trim($this->request->getGet('search') ?? '');

        // Join users with attendance for the latest event
        $builder = $db->table('users');
        $builder->select('users.id_number, users.full_name, users.course, users.year_level_id, users.profile_pic, attendance.time_in, attendance.time_out, attendance.status');
        $builder->join('attendance', "attendance.student_id = users.id_number AND attendance.event_id = $current_event_id", 'left');
        $builder->where('users.role', 'student');

        if (!empty($search)) {
            $builder->where('users.id_number', $search);
        }

        $builder->orderBy('users.full_name', 'ASC');

        $data = [
            'students'         => $builder->get()->getResultArray(),
            'search_query'     => $search,
            'event_name'       => $latestEvent ? $latestEvent['title'] : 'No Active Event',
            'current_event_id' => $current_event_id,
        ];

        return view('admin/attendance_list', $data);
    }

    // --- ATTENDANCE TERMINAL (ID Scanner) ---
    public function attendance_terminal() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $search = trim($this->request->getGet('search') ?? '');

        $eventModel = new EventModel();
        $latestEvent = $eventModel->orderBy('start_event', 'DESC')->first();
        $current_event_id = $latestEvent ? $latestEvent['id'] : 0;

        $student = null;
        if (!empty($search)) {
            $builder = $db->table('users');
            $builder->select('users.id_number, users.full_name, users.course, users.year_level_id, users.profile_pic, attendance.time_in, attendance.time_out');
            $builder->join('attendance', "attendance.student_id = users.id_number AND attendance.event_id = $current_event_id", 'left');
            $builder->where('users.id_number', $search);
            $student = $builder->get()->getRowArray();
        }

        $data = [
            'student'          => $student,
            'search_query'     => $search,
            'event_name'       => $latestEvent ? $latestEvent['title'] : 'No Active Event',
            'current_event_id' => $current_event_id,
        ];

        return view('admin/attendance_terminal', $data);
    }

    // --- TOGGLE ATTENDANCE LOGIC ---
    public function toggle_attendance($student_id, $event_id) {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        date_default_timezone_set('Asia/Manila'); 

        $attendanceModel = new \App\Models\AttendanceModel();
        $eventModel = new \App\Models\EventModel();

        $event = $eventModel->find($event_id);
        if (!$event) return redirect()->back()->with('error', 'Event not found.');

        $currentTime = time(); 
        $eventStartTime = strtotime($event['start_event']);
        $lateThreshold = $eventStartTime + (15 * 60); 

        $record = $attendanceModel->where('student_id', $student_id)
                                  ->where('event_id', $event_id)
                                  ->first();

        if (!$record) {
            if ($currentTime > $lateThreshold) {
                return redirect()->back()->with('error', 'Late Entry Denied! Event started at '.date('h:i A', $eventStartTime).'. You are past the 15-minute limit.');
            }

            $data = [
                'student_id' => $student_id,
                'event_id'   => $event_id,
                'time_in'    => date('Y-m-d H:i:s'),
                'date'       => date('Y-m-d'),
                'status'     => 'Present'
            ];
            $attendanceModel->insert($data);
            return redirect()->back()->with('msg', 'Successfully Timed In!');

        } elseif (empty($record['time_out'])) {
            $attendanceModel->update($record['id'], ['time_out' => date('Y-m-d H:i:s')]);
            return redirect()->back()->with('msg', 'Successfully Timed Out!');
        }

        return redirect()->back()->with('error', 'Attendance already completed.');
    }

    public function update_event($id) {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $eventModel = new \App\Models\EventModel();
        $start_event = $this->request->getPost('date') . ' ' . $this->request->getPost('time');

        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'start_event' => $start_event,
            'color'       => $this->request->getPost('color'),
        ];

        if ($eventModel->update($id, $data)) {
            return redirect()->to(base_url('admin'))->with('msg', 'Event updated successfully!');
        } else {
            return redirect()->to(base_url('admin'))->with('error', 'Failed to update event.');
        }
    }

    public function save_event() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $eventModel = new \App\Models\EventModel();

        $date = $this->request->getPost('date');
        $time = $this->request->getPost('time');
        $start_event = $date . ' ' . $time;

        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'start_event' => $start_event,
            'end_event'   => $start_event, 
            'color'       => $this->request->getPost('color')
        ];

        if ($eventModel->insert($data)) {
            return redirect()->to(base_url('admin'))->with('msg', 'New event created successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to create event. Please try again.');
        }
    }

    // --- ALL EVENTS LIST ---
    public function events() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $eventModel = new EventModel();

        $filter = $this->request->getGet('filter') ?? 'all'; // all | month | upcoming | past

        $builder = $db->table('events')->orderBy('start_event', 'DESC');

        if ($filter === 'month') {
            $builder->where('MONTH(start_event)', date('m'))
                    ->where('YEAR(start_event)', date('Y'));
        } elseif ($filter === 'upcoming') {
            $builder->where('start_event >=', date('Y-m-d H:i:s'));
        } elseif ($filter === 'past') {
            $builder->where('start_event <', date('Y-m-d H:i:s'));
        }

        $data = [
            'events'       => $builder->get()->getResultArray(),
            'filter'       => $filter,
            'event_count'  => $db->table('events')
                                ->where('MONTH(start_event)', date('m'))
                                ->where('YEAR(start_event)', date('Y'))
                                ->countAllResults(),
        ];

        return view('admin/events_list', $data);
    }

    // --- ALL ANNOUNCEMENTS LIST ---
    public function announcements() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();

        $announcements = $db->table('announcements')
                            ->orderBy('created_at', 'DESC')
                            ->get()
                            ->getResultArray();

        $data = [
            'announcements'      => $announcements,
            'announcement_count' => count($announcements),
        ];

        return view('admin/announcements_list', $data);
    }

    public function save_announcement() {
        $session = session();
        $db = \Config\Database::connect();
        $img = $this->request->getFile('announcement_pic');
        $imagePath = null;

        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'assets/uploads/announcements/', $newName);
            $imagePath = $newName;
        }

        $data = [
            'user_id'    => $session->get('id'),
            'message'    => $this->request->getVar('message'),
            'image_path' => $imagePath,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($db->table('announcements')->insert($data)) {
            return redirect()->to(base_url('admin'))->with('msg', 'Announcement posted with image!');
        } else {
            return redirect()->back()->with('error', 'Failed to post.');
        }
    }
    // --- MARK ALL STUDENTS PRESENT ---
    public function mark_all_present() {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        date_default_timezone_set('Asia/Manila'); 
        
        $db = \Config\Database::connect();
        $eventModel = new EventModel();
        $attendanceModel = new \App\Models\AttendanceModel();

        // 1. Get the current active event
        $latestEvent = $eventModel->orderBy('start_event', 'DESC')->first();
        if (!$latestEvent) {
            return redirect()->back()->with('error', 'No active event found to mark attendance for.');
        }

        $current_event_id = $latestEvent['id'];

        // 2. Get all students
        $students = $db->table('users')->where('role', 'student')->get()->getResultArray();

        $currentTime = date('Y-m-d H:i:s');
        $currentDate = date('Y-m-d');
        $markedCount = 0;

        // 3. Loop through students and mark them present if they aren't already
        foreach ($students as $student) {
            $record = $attendanceModel->where('student_id', $student['id_number'])
                                      ->where('event_id', $current_event_id)
                                      ->first();

            // If no attendance record exists for this event, insert one
            if (!$record) {
                $data = [
                    'student_id' => $student['id_number'],
                    'event_id'   => $current_event_id,
                    'time_in'    => $currentTime,
                    'date'       => $currentDate,
                    'status'     => 'Present'
                ];
                $attendanceModel->insert($data);
                $markedCount++;
            }
        }

        // 4. Return with success message
        if ($markedCount > 0) {
            return redirect()->back()->with('msg', "Successfully marked $markedCount student(s) as present for '" . $latestEvent['title'] . "'!");
        } else {
            return redirect()->back()->with('msg', 'All students are already marked present for this event.');
        }
    }
    // --- MARK ALL STUDENTS TIME OUT ---
public function mark_all_timeout() {
    if (!session()->get('isLoggedIn')) {
        return redirect()->to(base_url('login'));
    }

    date_default_timezone_set('Asia/Manila'); 
    
    $eventModel = new EventModel();
    $attendanceModel = new \App\Models\AttendanceModel();

    // 1. Get the current active event
    $latestEvent = $eventModel->orderBy('start_event', 'DESC')->first();
    if (!$latestEvent) {
        return redirect()->back()->with('error', 'No active event found to mark attendance for.');
    }

    $current_event_id = $latestEvent['id'];
    $currentTime = date('Y-m-d H:i:s');
    $markedCount = 0;

    // 2. Find all students currently timed-in but NOT timed-out for this event
    $recordsToUpdate = $attendanceModel->where('event_id', $current_event_id)
                                       ->where('time_in IS NOT NULL')
                                       ->where('time_out', null)
                                       ->findAll();

    // 3. Update their records
    foreach ($recordsToUpdate as $record) {
        $attendanceModel->update($record['id'], ['time_out' => $currentTime]);
        $markedCount++;
    }

    // 4. Return message
    if ($markedCount > 0) {
        return redirect()->back()->with('msg', "Successfully timed out $markedCount student(s)!");
    } else {
        return redirect()->back()->with('msg', 'All active students are already timed out or missing time-in.');
    }
}
// --- DELETE EVENT ---
    public function delete_event($id) {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $eventModel = new \App\Models\EventModel();
        
        // Add the AttendanceModel so we can delete the child records
        $attendanceModel = new \App\Models\AttendanceModel(); 
        
        // Ensure the event exists before deleting
        if ($eventModel->find($id)) {
            
            // 1. Delete all attendance records tied to this event first
            $attendanceModel->where('event_id', $id)->delete();

            // 2. Now it is safe to delete the parent event
            $eventModel->delete($id);
            
            return redirect()->to(base_url('admin'))->with('msg', 'Event and associated attendance records deleted successfully!');
        } else {
            return redirect()->to(base_url('admin'))->with('error', 'Failed to delete: Event not found.');
        }
    }

    
}