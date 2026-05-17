<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- Authentication Routes ---
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->post('login/auth', 'Login::auth');
$routes->get('logout', 'Login::logout');

// --- Registration Routes ---
$routes->get('register', 'Register::index');
$routes->post('register/save', 'Register::save');

// --- Student Dashboard & Features ---
$routes->get('student/dashboard', 'Student::index');
$routes->post('student/upload_pic', 'Student::upload_pic');
$routes->get('student/get_calendar_events', 'Student::get_calendar_events'); 

// --- Admin Dashboard & Core Features ---
$routes->get('admin', 'Admin::index');
$routes->get('admin/dashboard', 'Admin::index');
$routes->post('admin/post_announcement', 'Admin::post_announcement');
$routes->post('admin/save_event', 'Admin::save_event');
$routes->post('admin/update_event/(:num)', 'Admin::update_event/$1');

// --- Student Management ---
$routes->get('admin/students', 'Admin::students');

// --- Attendance Monitoring & Terminal ---
// 1. The List/Log View (Table)
$routes->get('admin/attendance_list', 'Admin::check_attendance');
$routes->get('admin/check_attendance', 'Admin::check_attendance'); // Alias for flexibility

// 2. The Monitoring/Scanner Page (Profile Card view)
$routes->get('admin/attendance_monitoring', 'Admin::attendance_monitoring');

// 3. The Manual Search Terminal (Manual ID entry)
$routes->get('admin/attendance_terminal', 'Admin::attendance_terminal');

// 4. The Logic (Toggle Time In/Out Action)
$routes->get('admin/toggle_attendance/(:any)/(:num)', 'Admin::toggle_attendance/$1/$2');

// --- API Routes ---
$routes->get('api/get-events', 'AttendanceController::getEvents');
$routes->post('api/update-attendance/(:num)', 'AttendanceController::updateAttendance/$1');

$routes->get('admin/view_student/(:any)', 'Admin::view_student/$1');
// Use (:any) for the Student ID (which might have letters) 
// and (:num) for the Event ID (which is always a number)
// --- Events & Announcements List Pages ---
$routes->get('admin/events', 'Admin::events');
$routes->get('admin/announcements', 'Admin::announcements');

// Admin Announcement Routes
$routes->post('admin/save_announcement', 'Admin::save_announcement');
$routes->post('admin/mark_all_present', 'Admin::mark_all_present');
$routes->post('admin/mark_all_timeout', 'Admin::mark_all_timeout');
$routes->get('admin/delete_event/(:num)', 'Admin::delete_event/$1');