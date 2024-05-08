<?php

declare(strict_types=1);

namespace App\Orchid\Screens\AuthLogs;

use App\Models\AuthLog;
use App\Orchid\Layouts\AuthLogs\AuthLogsListLayout;
use Orchid\Screen\Screen;

class AuthLogListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {

        return [
            'logs' => AuthLog::query()
                ->filters()
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Authentication logs';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all auth logs.';
    }

    /**
     * Permissions required to access this screen.
     *
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.systems.authlogs',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            AuthLogsListLayout::class,

        ];
    }



}
