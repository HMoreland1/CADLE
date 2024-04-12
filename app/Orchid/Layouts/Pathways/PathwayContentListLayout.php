<?php

namespace App\Orchid\Layouts\Pathways;

use App\Models\LearningContent;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PathwayContentListLayout extends Table
{
    public $target = 'content';

    /**
     * Get the table columns.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        $assignedContent = $this->query->get('assignedContent', []);
        // Get the content IDs associated with the pathway

        $assignedContent = $assignedContent ?? [];
        return [
            TD::make('Select')
                ->render(function (LearningContent $learningContent) use ($assignedContent) {
                    // Check if the current content ID is in the pathway content IDs
                    if ($assignedContent !== null) {
                        $checked = in_array($learningContent->getKey(), $assignedContent);
                    }
                    return CheckBox::make('content_ids[]')
                        ->value($learningContent->getKey())
                        ->placeholder('')
                        ->checked($checked); // Set checked attribute based on whether content is already selected
                }),
            TD::make('title', __('Title')),
            TD::make('description', __('Description')),
            // Add more columns as needed
        ];
    }
}
