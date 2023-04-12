<?php

namespace App\Orchid\Layouts\Docs;

use App\Models\Doc;
use App\Models\Theme;
use Illuminate\Mail\Attachment;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DocsTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'docs';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name','Назва документу')->sort()->filter(TD::FILTER_TEXT)->cantHide(),
            TD::make('created_at', 'Дата створення')->defaultHidden(),
            TD::make('updated_at', 'Дата оновлення (редагування)')->defaultHidden(),
            TD::make('action','')->render(function (Doc $doc){
                return ModalToggle::make('Редагувати')
                    ->modal('editDoc')
                    ->method('createOrUpdateDoc')
                    ->asyncParameters([
                        'doc' => $doc->id
                    ]);
            })->alignRight()->cantHide(),
            TD::make('delete','')->render(function (Doc $doc){
                return ModalToggle::make('Видалити')
                    ->modal('deleteDoc')
                    ->method('deleteDoc')
                    ->asyncParameters([
                        'doc' => $doc->id
                    ]);
            })->alignRight()->cantHide()->width(100),
        ];
    }
}
