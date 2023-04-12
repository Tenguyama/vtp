<?php

namespace App\Orchid\Layouts\Themes;

use App\Models\Group;
use App\Models\SelectedTheme;
use App\Models\Student;
use App\Models\Theme;
use App\Models\User;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class StudentThemesTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'selectedThemes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('student_id','ПІП')->sort()->cantHide()->render(function (SelectedTheme $selectedTheme){
                $studentId = $selectedTheme->student_id;
                $studentName = Student::where('id', $studentId)->value('name');
                return $studentName;
            }),
            TD::make('group_id', 'Група')->sort()->render(function (SelectedTheme $selectedTheme) {
                $groupId = $selectedTheme->group_id;
                $groupName = Group::where('id', $groupId)->value('name');
                return $groupName;
            }),
            TD::make('theme.name','Тема')->render(function (SelectedTheme $selectedTheme){
                $themeId = $selectedTheme->theme_id;
                $themeName = Theme::where('id', $themeId)->value('name');
                return $themeName;
            }),
            TD::make('theme.user_id','Керівник')->render(function (SelectedTheme $selectedTheme){
                $themeId = $selectedTheme->theme_id;
                $userId = Theme::where('id', $themeId)->value('user_id');
                $userName = User::where('id', $userId)->value('name');
                return $userName;
            }),
            TD::make('created_at', 'Дата створення')->defaultHidden(),
            TD::make('updated_at', 'Дата оновлення (редагування)')->defaultHidden(),
        ];
    }
}
