<?php

namespace App\Orchid\Layouts\Themes;

use App\Models\Theme;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class UserThemesTable extends Table
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
            TD::make('created_at', 'Дата створення')->defaultHidden(),
            TD::make('updated_at', 'Дата оновлення (редагування)')->defaultHidden(),
            TD::make('action','')->render(function (Theme $theme){
                return ModalToggle::make('Редагувати')
                        ->modal('editTheme')
                        ->method('createOrUpdateTheme')
                        ->asyncParameters([
                            'theme' => $theme->id
                        ]);
            })->alignRight()->cantHide(),
            TD::make('delete','')->render( function (Theme $theme){
                return  ModalToggle::make('Видалити')
                    ->modal('deleteTheme')
                    ->method('deleteTheme')
                    ->asyncParameters([
                        'theme' => $theme->id
                    ]);
            })->alignRight()->cantHide()->width(100),
        ];
    }
}
