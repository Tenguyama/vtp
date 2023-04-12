<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class SelectedTheme extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $guarded = ['id'];

    protected $fillable = [
        'student_id',
        'group_id',
        'theme_id',
    ];

    protected $allowedSorts = [
        'student_id',
        'group_id',
        'theme_id',
    ];

    protected $allowedFilters = [
        'student_id',
        'group_id',
        'theme_id',
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function theme(){
        return $this->belongsTo(Theme::class);
    }
}
