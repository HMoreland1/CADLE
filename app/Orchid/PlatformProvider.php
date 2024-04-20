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
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            /*
            Menu::make('Get Started')
                ->icon('bs.book')
                ->title('Navigation')
                ->route(config('platform.index')),

            Menu::make('Sample Screen')
                ->icon('bs.collection')
                ->route('platform.example')
                ->badge(fn () => 6),

            Menu::make('Form Elements')
                ->icon('bs.card-list')
                ->route('platform.example.fields')
                ->active('examples/form'),

            Menu::make('Overview Layouts')
                ->icon('bs.window-sidebar')
                ->route('platform.example.layouts'),

            Menu::make('Grid System')
                ->icon('bs.columns-gap')
                ->route('platform.example.grid'),

            Menu::make('Charts')
                ->icon('bs.bar-chart')
                ->route('platform.example.charts'),

            Menu::make('Cards')
                ->icon('bs.card-text')
                ->route('platform.example.cards')
                ->divider(),
            */
            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Administration')),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),


            Menu::make(__('Quizzes'))
                ->icon('bs.question-circle')
                ->route('platform.systems.quizzes')
                ->permission('platform.systems.quizzes'),

            Menu::make(__('Learning Content - This will open in a new tab'))
                ->icon('bs.book')
                ->route('platform.systems.learningcontent')
                ->permission('platform.systems.learningcontent')
                ->target('_blank'),

            Menu::make(__('Pathways'))
                ->icon('bs.book')
                ->route('platform.systems.pathways')
                ->permission('platform.systems.pathways')
                ->divider(),

            Menu::make(__('User Learning Assignment'))
                ->icon('bs.people')
                ->route('platform.systems.learningcontent.assign.users')
                ->permission('platform.systems.users')
                ->title(__('Learning Assignment'))
                ->divider(),


            Menu::make('Documentation')
                ->title('Docs')
                ->icon('bs.box-arrow-up-right')
                ->url('https://orchid.software/en/docs')
                ->target('_blank'),

            Menu::make('Changelog')
                ->icon('bs.box-arrow-up-right')
                ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
                ->target('_blank')
                ->badge(fn () => Dashboard::version(), Color::DARK),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('Super User'))
                ->addPermission('platform.systems.super', __('Super')),
            ItemPermission::group(__('User Management'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users'))
                ->addPermission('platform.systems.impersonate', __('Impersonate User')),
            ItemPermission::group(__('Content Management'))
                ->addPermission('platform.systems.learningcontent', __('Learning Content Management'))
                ->addPermission('platform.systems.quizzes', __('Quiz Management'))
                ->addPermission('platform.systems.pathways', __('Pathway Management')),
            ItemPermission::group(__('Content Assignment'))
                ->addPermission('platform.systems.learningcontent.assign', __('Learning Content Assignment'))
        ];

    }
}
