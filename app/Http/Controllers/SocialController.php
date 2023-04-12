<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginWithGoogle()
    {

            $user = Socialite::driver('google')->user();

            $isUser = Student::where('google_id', $user->id)->first();

            if($isUser){
                Auth::guard('std')->login($isUser);
            }else{
                $createStudents = Student::create([
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'password'=>password_hash($user->email, PASSWORD_DEFAULT ),
                    'google_id'=>$user->id,
                ]);

                Auth::guard('std')->login($isUser, true);
            }

            return redirect()->to('student');
    }
}
