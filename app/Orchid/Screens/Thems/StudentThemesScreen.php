<?php

namespace App\Orchid\Screens\Thems;

use App\Models\Group;
use App\Models\SelectedTheme;
use App\Models\Student;
use App\Models\Theme;
use App\Models\User;
use App\Orchid\Layouts\Themes\StudentThemesTable;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class StudentThemesScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'selectedThemes'=>SelectedTheme::filters()
                ->join('themes', 'selected_themes.theme_id', '=', 'themes.id')
                ->orderBy('themes.user_id')
                ->paginate(15),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Закріплені теми';
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
                ModalToggle::make('Очистити таблицю')->modal('truncateSelectedThemes')->method('truncateSelectedThemes')
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
            StudentThemesTable::class,
            Layout::modal('truncateSelectedThemes',Layout::rows([]))->title('Очищення таблиці')->applyButton('Очистити'),
            Layout::tabs([
                'Скачати перелік закріплених тем'=> [
                    Layout::rows([
                        Button::make('Скачати')
                            ->method('downloadSelectedThemes')
                            ->rawClick()
                    ]),
                ],
            ]),
        ];
    }

    public function truncateSelectedThemes(){
        SelectedTheme::truncate();

        Toast::info('Таблиця успішно очищена');
    }

    public function downloadSelectedThemes(){
        //$selectedThemes = SelectedTheme::with('student','group','theme')->get(['student_id','group_id','theme_id']);
        $selectedThemes = SelectedTheme::with('student', 'group', 'theme')
            ->join('themes', 'selected_themes.theme_id', '=', 'themes.id')
            ->orderBy('themes.user_id')
            ->get(['student_id', 'group_id', 'theme_id']);
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=selected_themes.csv'
        ];
        $delimiter = ';'; // встановлюємо розділювач полів
        $columns = ['ПІП', 'Група', 'Назва теми', 'Керівник'];
        $callback = function () use ($selectedThemes, $columns, $delimiter){
            $stream = fopen('php://output','w');
            fwrite($stream, chr(0xEF).chr(0xBB).chr(0xBF)); // додаємо BOM для кодування utf-8

            fputcsv($stream, $columns, $delimiter);

            foreach ($selectedThemes as $selectedTheme){
                $studentName = Student::where('id',$selectedTheme->student_id)->value('name');
                $groupName = Group::where('id', $selectedTheme->group_id)->value('name');
                $themeName = Theme::where('id', $selectedTheme->theme_id)->value('name');
                $userId = Theme::where('id', $selectedTheme->theme_id)->value('user_id');
                $username = User::where('id', $userId)->value('name');
                fputcsv($stream, [$studentName,$groupName,$themeName,$username], $delimiter);
            }
            fclose($stream);
        };
        return response()->stream($callback, 200, $headers);
    }
}
