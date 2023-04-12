<?php

namespace App\Orchid\Screens\Thems;

use App\Models\Theme;
use App\Models\User;
use App\Orchid\Layouts\Themes\AllThemesTable;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AllThemesScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'themes' => Theme::filters()->orderBy('user_id')->paginate(15)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Загальний перелік тем';
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
                ModalToggle::make('Очистити таблицю')->modal('truncateThemes')->method('truncateThemes')
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
            AllThemesTable::class,
            Layout::modal('truncateThemes',Layout::rows([]))->title('Очищення таблиці')->applyButton('Очистити'),
            Layout::tabs([
               'Скачати перелік тем'=> [
                   Layout::rows([
                       Button::make('Скачати')
                       ->method('downloadThemes')
                       ->rawClick()
                   ]),
               ],
            ]),
        ];
    }

    public function truncateThemes(){
        Theme::truncate();

        Toast::info('Таблиця успішно очищена');
    }

    public function downloadThemes(){
        $themes = Theme::with('user')->orderBy('user_id')->get(['name','user_id']);
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=themes.csv'
        ];
        $delimiter = ';'; // встановлюємо розділювач полів
        $columns = ['Назва теми', 'Керівник'];
        $callback = function () use ($themes, $columns, $delimiter){
            $stream = fopen('php://output','w');
            fwrite($stream, chr(0xEF).chr(0xBB).chr(0xBF)); // додаємо BOM для кодування utf-8

            fputcsv($stream, $columns, $delimiter);

            foreach ($themes as $theme){
                $name = $theme->name; // кодуємо рядки в utf-8
                $username = User::where('id', $theme->user_id)->value('name');
                fputcsv($stream, [$name, $username], $delimiter);
            }
            fclose($stream);
        };
        return response()->stream($callback, 200, $headers);
    }
}
