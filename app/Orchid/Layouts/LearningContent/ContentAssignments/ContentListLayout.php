<?php

namespace App\Orchid\Layouts\LearningContent\ContentAssignments;

use App\Models\LearningContent;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ContentListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'content';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('selected', 'Add to Quiz')
                ->align(TD::ALIGN_CENTER)
                ->width(150)
                ->cantHide()
                ->render(function (LearningContent $content) {
                    $assignedContent = $this->query->get('assignedContent', []);
                    $isChecked = in_array($content->content_id, $assignedContent);

                    return "
                        <input
                            type='checkbox'
                            name='selected_content[]'
                            value='$content->content_id'
                            class='content-checkbox'
                            data-assigned-questions='" . json_encode($assignedContent) . "'
                            " . ($isChecked ? 'checked' : '') . ">
                    ";
                }),

            TD::make('importance', 'Importance')
                ->align(TD::ALIGN_CENTER)
                ->width(150)
                ->cantHide()
                ->render(function (LearningContent $content) {
                    // Options for the importance dropdown
                    $importanceOptions = [
                        'Essential' => 'Essential',
                        'Compliance' => 'Compliance',
                    ];

                    // Generate the HTML for the importance dropdown
                    return "<div>
                            " . Select::make('importance')
                            ->options($importanceOptions)
                            ->value('Essential') // Default value
                            ->render() . "
                        </div>";


                }),
            TD::make('title', __('Title'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('description', __('Description'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('categories', __('Categories'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),


        ];
    }
}
