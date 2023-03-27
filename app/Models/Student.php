<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Student extends Model
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

    protected $allowedSorts = ['name',];

    protected $allowedFilters = ['name',];

    public function selectedTheme(){
        return $this->hasOne(SelectedTheme::class);
    }
}
