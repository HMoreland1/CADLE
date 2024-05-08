<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\AuthLogs;

use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AuthLogsListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'logs';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('user_id', __('User ID'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('ip_address', __('IP Address'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('user_agent', __('User Agent'))
                ->align(TD::ALIGN_RIGHT)
                ->sort(),

            TD::make('type', __('Event Type'))
                ->align(TD::ALIGN_RIGHT)
                ->sort(),

            TD::make('created_at', __('Time'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->sort(),

        ];
    }
}
