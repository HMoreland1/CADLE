<?php
namespace App\Orchid\Layouts\LearningContent\ContentCreation;

use App\Models\LearningContent;
use App\Models\Question;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ContentListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'contents';


    /**
     * @return TD[]
     */
    public function columns(): array
    {

        return [
            // Checkbox column for selecting questions

            TD::make('title', __('Title'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

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

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (LearningContent $content) {
                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.systems.learningcontent.edit', $content)
                                ->icon('bs.pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Are you sure you want to delete this question?'))
                                ->method('remove', ['content_id' => $content->content_id]),
                        ]);
                }),
        ];
    }


}
