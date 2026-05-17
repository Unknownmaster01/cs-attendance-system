<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\EventModel;

class Student extends Controller {

   public function index() {
    $session = session();
    if(!$session->get('isLoggedIn')) return redirect()->to(base_url('login'));

    $db = \Config\Database::connect();
    $studentId = $session->get('id_number');
    $userId = $session->get('id');

    // Fetch the full student record including email
    $student = $db->table('users')->where('id', $userId)->get()->getRowArray();

    $attendanceLogs = $db->table('attendance')
        ->select('attendance.*, events.title as event_title')
        ->join('events', 'events.id = attendance.event_id', 'left')
        ->where('student_id', $studentId) 
        ->orderBy('attendance.time_in', 'DESC') 
        ->get()
        ->getResultArray();

    // ADD THIS: Fetch announcements using the 'message' column from your DB
    $announcements = $db->table('announcements')
        ->orderBy('created_at', 'DESC')
        ->get()
        ->getResultArray();

    $yearLevelMap = [
        '1' => '1st Year',
        '2' => '2nd Year',
        '3' => '3rd Year',
        '4' => '4th Year',
    ];
    $yearLevelRaw = $student['year_level_id'] ?? '';

    $data = [
        'name'            => $session->get('name') ?: $session->get('full_name'),
        'email'           => $student['email'],
        'course'          => $session->get('course'),
        'id'              => $session->get('id_number'),
        'year_level'      => $yearLevelMap[$yearLevelRaw] ?? $yearLevelRaw,
        'attendance_logs' => $attendanceLogs,
        'announcements'   => $announcements,
        'profile_pic'     => $session->get('profile_pic')
    ];

    return view('student_dashboard', $data);
}

    /**
     * 3. Fetch Events for FullCalendar
     * Formats database rows into JSON for the JavaScript calendar
     */
    public function get_calendar_events() {
        $model = new EventModel();
        $events = $model->findAll();
        
        $formattedEvents = [];
        foreach ($events as $e) {
            $formattedEvents[] = [
                'id'          => $e['id'],
                'title'       => $e['title'],
                // Uses 'start_event' to match your Admin saving logic
                'start'       => $e['start_event'], 
                'end'         => $e['end_event'],
                'description' => $e['description'],
                'color'       => $e['color']
            ];
        }
        return $this->response->setJSON($formattedEvents);
    }

    // 4. Handle Profile Picture Uploads
    public function upload_pic() {
    $session = session();
    $model = new \App\Models\UserModel();
    $userId = $session->get('id'); 
    $idNumber = $session->get('id_number'); // Use ID Number for the folder name

    $img = $this->request->getFile('profile_pic');

    if ($img->isValid() && !$img->hasMoved()) {
        // 1. Define the specific folder for this student
        // Path: public/assets/uploads/profile_pics/12-3456/
        $userFolder = FCPATH . 'assets/uploads/profile_pics/' . $idNumber . '/';

        // 2. Create the folder if it doesn't exist
        if (!is_dir($userFolder)) {
            mkdir($userFolder, 0777, true);
        }

        // 3. Clean out the folder (Delete old files)
        $files = glob($userFolder . '*'); 
        foreach($files as $file) {
            if(is_file($file)) {
                unlink($file); 
            }
        }

        // 4. Save the new file
        $newName = $img->getRandomName();
        $img->move($userFolder, $newName);

        // 5. Update Database with the relative path
        // We store "ID_NUMBER/filename.jpg" so the View knows which folder to check
        $dbPath = $idNumber . '/' . $newName;
        $model->update($userId, ['profile_pic' => $dbPath]);
        
        // 6. Update Session
        $session->set('profile_pic', $dbPath);

        return redirect()->back()->with('msg', 'Profile picture updated and folder organized!');
    }
    return redirect()->back()->with('error', 'Upload failed.');
}
public function dashboard() {
    $db = \Config\Database::connect();
    
    // Fetch all announcements, newest first
    $data['announcements'] = $db->table('announcements')
        ->orderBy('created_at', 'DESC')
        ->get()
        ->getResultArray();

    return view('student_dashboard', $data);
}
}