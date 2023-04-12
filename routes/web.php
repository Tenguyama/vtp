<?php

use App\Http\Controllers\DocsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SelectedThemesController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ThemesController;
use App\Models\SelectedTheme;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/docs', [DocsController::class, 'index'])->name('docs');

Route::get('/themes', [ThemesController::class, 'index'])->name('themes');

Route::get('/selected-themes', [SelectedThemesController::class, 'index'])->name('selected_themes');

Route::get('/student', [StudentController::class, 'index'])->name('student')->middleware('auth:std');

Route::get('/google', [SocialController::class, 'googleRedirect'])->name('google');

Route::get('/google/callback', [SocialController::class, 'loginWithGoogle']);

Route::post('/student/save', function(Request $request) {
    try {
        $group_id = $request->input('group_id');
        $theme_id = $request->input('theme_id');
        $student_id = auth()->user()->id;

        if (!SelectedTheme::where('student_id', $student_id)->exists()) {
            SelectedTheme::create([
                'student_id' => $student_id,
                'group_id' => $group_id,
                'theme_id' => $theme_id,
            ]);
        }
        return response('OK', 200);
    }catch(Exception $exception){
        return "error";
    }
});

Route::get('/qq', function(){
   auth()->guard('std')->logout();
});
