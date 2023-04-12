<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class CreateOrUpdateDoc extends Rows
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
        return [
            Input::make('doc.id')->type('hidden'),
            Input::make('doc.name')->required()->title('Файл')->placeholder('Назва файлу')->help('Введіть назву файлу'),
            Upload::make('doc.file_id')->required()->title('Завантажити файл')->minFiles(1)->maxFiles(1)->storage('docs')
        ];
    }
}
