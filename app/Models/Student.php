<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
    ];

    protected $allowedSorts = ['name', 'email'];

    protected $allowedFilters = ['name', 'email'];

    public function selectedTheme(){
        return $this->hasOne(SelectedTheme::class);
    }
}
