<?php

namespace App\Orchid\Screens\Student;

use App\Models\SelectedTheme;
use App\Models\Student;
use App\Orchid\Layouts\Student\StudentTable;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class StudentScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'students'=>Student::filters()->paginate(20)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Авторизовані студенти';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        if (Auth::user()->hasAccess('platform.systems.users')){
            return [
                ModalToggle::make('Очистити таблицю')->modal('truncateStudents')->method('truncateStudents')
            ];
        }
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            StudentTable::class,
            Layout::modal('truncateStudents',Layout::rows([]))->title('Очищення таблиці')->applyButton('Очистити'),
        ];
    }

    public function truncateStudents(){
        Student::truncate();

        Toast::info('Таблиця успішно очищена');
    }
}
