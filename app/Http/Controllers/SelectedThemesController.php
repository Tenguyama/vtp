<?php

namespace App\Http\Controllers;

use App\Models\SelectedTheme;

class SelectedThemesController extends Controller
{
    public function index(){
        $selectedThemes = SelectedTheme::join('themes', 'selected_themes.theme_id', '=', 'themes.id')
            ->join('students', 'selected_themes.student_id', '=', 'students.id')
            ->join('groups', 'selected_themes.group_id', '=', 'groups.id')
            ->join('users', 'themes.user_id', '=', 'users.id')
            ->select('students.name as student_name', 'groups.name as group_name', 'themes.name as theme_name', 'users.name as user_name')
            ->orderBy('themes.user_id')
            ->get();
        $index = 1;
        return  view('app.selected_themes', compact('selectedThemes','index'));
    }
}
