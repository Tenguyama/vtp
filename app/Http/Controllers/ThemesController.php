<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemesController extends Controller
{
    public function index(){
        $themes = Theme::join('users', 'themes.user_id','=','users.id')
            ->select('themes.name as theme_name', 'users.name as user_name')
            ->orderBy('themes.user_id')
            ->get();
        $index = 1;
        return  view('app.themes', compact('themes', 'index'));
    }
}
