<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\SelectedTheme;
use App\Models\Theme;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $student = auth()->user();
        $isSelectedTheme = SelectedTheme::join('themes', 'selected_themes.theme_id', '=', 'themes.id')
            ->join('students', 'selected_themes.student_id', '=', 'students.id')
            ->join('groups', 'selected_themes.group_id', '=', 'groups.id')
            ->join('users', 'themes.user_id', '=', 'users.id')
            ->select('students.name as student_name', 'groups.name as group_name', 'themes.name as theme_name', 'users.name as user_name')
            ->where('student_id', $student->id)
            ->first();

//        $themes = Theme::join('users', 'themes.user_id','=','users.id')
//            ->select('themes.id as theme_id','themes.name as theme_name', 'users.name as user_name')
//            ->orderBy('themes.user_id')
//            ->get();
        $themes = Theme::join('users', 'themes.user_id', '=', 'users.id')
            ->select('themes.id as theme_id', 'themes.name as theme_name', 'users.name as user_name')
            ->whereNotIn('themes.id', function($query) {
                $query->select('selected_themes.theme_id')
                    ->from('selected_themes');
            })
            ->orderBy('themes.user_id')
            ->get();
        $groups = Group::get();
        $index = 1;
        return  view('app.student', compact('student', 'isSelectedTheme', 'themes', 'groups','index'));

    }
}
