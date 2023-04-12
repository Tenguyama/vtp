<?php

namespace App\Orchid\Screens\Thems;

use App\Http\Requests\GroupRequest;
use App\Http\Requests\ThemeRequest;
use App\Models\Group;
use App\Models\Theme;
use App\Orchid\Layouts\CreateOrUpdateTheme;
use App\Orchid\Layouts\Themes\UserThemesTable;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserThemesScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'themes' => Theme::where('user_id', Auth::id())->filters()->paginate(15)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Теми керівника';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Створити тему')->modal('createTheme')->method('createOrUpdateTheme')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            UserThemesTable::class,
            Layout::modal('createTheme', CreateOrUpdateTheme::class)->title('Створення теми')->applyButton('Створити'),
            Layout::modal('editTheme', CreateOrUpdateTheme::class)->title('Редагування теми')->applyButton('Зберегти')->async('asyncGetTheme'),
            Layout::modal('deleteTheme', Layout::rows([
                Input::make('theme.id')->type('hidden'),
                Input::make('theme.name')->readonly(),
            ]))->title('Видалення теми')->applyButton('Видалити')->async('asyncGetTheme'),
        ];
    }

    public function asyncGetTheme(Theme $theme): array
    {
        return [
            'theme' => $theme,
        ];
    }

    public function createOrUpdateTheme(ThemeRequest $request): void
    {
        $themeId = $request->input('theme.id');
        Theme::updateOrCreate([
            'id'=> $themeId
        ], array_merge($request->validated()['theme'], []));

        is_null($themeId) ? Toast::info('Тема успішно створена') : Toast::info('Тема успішно відредагована');
    }
    public function deleteTheme(ThemeRequest $request)
    {
        $themeId = $request->input('theme.id');
        $theme = Theme::find($themeId);
        $theme->delete();

        Toast::info('Тема успішно видалена');
    }
}
