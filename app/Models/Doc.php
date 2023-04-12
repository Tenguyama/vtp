<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Doc extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use Attachable;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'file_id',
    ];

    protected $allowedSorts = [
        'name',
    ];

    protected $allowedFilters = [
        'name',
    ];

    public function file(){
        return $this->hasOne(Attachment::class, 'id', 'file_id')->withDefault();
    }
}
