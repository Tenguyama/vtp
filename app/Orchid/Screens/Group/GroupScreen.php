<?php

namespace App\Orchid\Screens\Group;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Orchid\Layouts\CreateOrUpdateGroup;
use App\Orchid\Layouts\Group\GroupTable;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class GroupScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'groups' => Group::filters()->paginate(15)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Перелік випускних груп';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Створити групу')->modal('createGroup')->method('createOrUpdateGroup')
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
            GroupTable::class,
            Layout::modal('createGroup', CreateOrUpdateGroup::class)->title('Створення груп')->applyButton('Створити'),
            Layout::modal('editGroup', CreateOrUpdateGroup::class)->title('Редагування групи')->applyButton('Зберегти')->async('asyncGetGroup'),
            Layout::modal('deleteGroup', Layout::rows([
                Input::make('group.id')->type('hidden'),
                Input::make('group.name')->readonly(),
            ]))->title('Видалення групи')->applyButton('Видалити')->async('asyncGetGroup'),
        ];
    }

    public function asyncGetGroup(Group $group): array
    {
        return [
            'group' => $group,
        ];
    }

    public function createOrUpdateGroup(GroupRequest $request): void
    {
        $groupId = $request->input('group.id');
        Group::updateOrCreate([
           'id'=> $groupId
        ], array_merge($request->validated()['group'], []));

        is_null($groupId) ? Toast::info('Група успішно створена') : Toast::info('Група успішно відредагована');
    }

    public function deleteGroup(GroupRequest $request){
        $groupId = $request->input('group.id');
        $group = Group::find($groupId);
        $group->delete();
        Toast::info('Група успішно видалена');
    }
}
