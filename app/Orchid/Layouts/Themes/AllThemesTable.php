<?php

namespace App\Orchid\Layouts\Themes;

use App\Models\Theme;
use App\Models\User;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AllThemesTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'themes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name','Назва теми')->sort()->filter(TD::FILTER_TEXT)->cantHide(),
            TD::make('user_id','Керівник')->sort()->filter(TD::FILTER_TEXT)->cantHide()->render(function (Theme $theme){
                $userId = $theme->user_id;
                $userName = User::where('id', $userId)->value('name');
                return $userName;
            }),
            TD::make('created_at', 'Дата створення')->defaultHidden(),
            TD::make('updated_at', 'Дата оновлення (редагування)')->defaultHidden(),
        ];
    }
}
