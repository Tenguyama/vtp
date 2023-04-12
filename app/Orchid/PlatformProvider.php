<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make('Документи')
                ->icon('docs')
                ->route('platform.docs')
                ->permission('platform.docs')
                ->title('Файли'),

            Menu::make('Перелік тем')
                ->icon('list')
                ->title('Теми')
                ->list([
                    Menu::make('Особистий перелік тем')
                        ->icon('user')
                        ->route('platform.thems.user')
                        ->permission('platform.thems.user'),
                    Menu::make('Загальний перелік тем')
                        ->icon('text-center')
                        ->route('platform.thems.all'),
                    Menu::make('Закріплені теми')
                        ->icon('pin')
                        ->route('platform.thems.student'),
                ]),

            Menu::make('Перелік груп')
                ->icon('grid')
                ->route('platform.group')
                ->permission('platform.group')
                ->title('Групи'),

            Menu::make('Авторизовані студенти')
                ->icon('friends')
                ->route('platform.student')
                ->title('Студенти'),


            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make(__('Profile'))
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
            ItemPermission::group('Функції')
                ->addPermission('platform.docs', 'Перелік документів')
                ->addPermission('platform.group', 'Перелік груп')
                ->addPermission('platform.thems.user', 'Особистий перелік тем ДП')

        ];
    }
}
