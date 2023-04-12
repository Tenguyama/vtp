<?php

namespace App\Orchid\Layouts\Student;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class StudentTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'students';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'ПІП')->sort()->cantHide()->filter(TD::FILTER_TEXT),
            TD::make('email', 'Корпоративна адреса')->sort()->filter(TD::FILTER_TEXT),
            TD::make('created_at', 'Дата авторизації')->sort()->defaultHidden(),
        ];
    }
}
