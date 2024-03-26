<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\LearningContent;

use App\Models\LearningContent;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ContentListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'learning_contents';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('title', __('Title'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(fn (LearningContent $content) => Link::make($content->title)->route('platform.systems.learning-content.edit', $content->content_id)),

            TD::make('description', __('Description'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),

            TD::make('updated_at', __('Last Edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->sort(),
        ];
    }
}
