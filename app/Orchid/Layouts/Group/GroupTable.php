<?php

namespace App\Orchid\Layouts\Group;

use App\Models\Group;
use App\Models\Theme;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class GroupTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'groups';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'Назва групи')->cantHide()
                ->popover('Назва групи, як то КН-41, чи КНз-31.')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->width(400),
            TD::make('created_at', 'Дата створення')->defaultHidden(),
            TD::make('updated_at', 'Дата оновлення (редагування)')->defaultHidden(),
            TD::make('action','')->render(function (Group $group) {
                return ModalToggle::make('Редагувати')
                    ->modal('editGroup')
                    ->method('createOrUpdateGroup')
                    ->asyncParameters([
                        'group' => $group->id
                    ]);
            })->alignRight()->cantHide(),
            TD::make('delete','')->render( function (Group $group){
                return  ModalToggle::make('Видалити')
                    ->modal('deleteGroup')
                    ->method('deleteGroup')
                    ->asyncParameters([
                        'group' => $group->id
                    ]);
            })->alignRight()->cantHide()->width(100),
        ];
    }
}
