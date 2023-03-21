<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
    ];

    public function selectedTheme(){
        return $this->hasOne(SelectedTheme::class);
    }
}
