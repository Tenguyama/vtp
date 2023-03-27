<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Theme extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'user_id',
    ];

    protected $allowedSorts = [
        'name',
    ];

    protected $allowedFilters = [
        'name',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function selectedTheme(){
        return $this->hasOne(SelectedTheme::class);
    }
}
