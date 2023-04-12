<?php

namespace App\Orchid\Layouts;

use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class CreateOrUpdateTheme extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        $id = Auth::id();
        return [
            Input::make('theme.id')->type('hidden'),
            Input::make('theme.name')->required()->title('Тема')->placeholder('Назва теми')->help('Введіть назву теми'),
            Input::make('theme.user_id')->type('hidden')->value($id)
        ];
    }
}
