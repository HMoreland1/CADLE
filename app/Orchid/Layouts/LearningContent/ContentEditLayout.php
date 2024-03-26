<?php
declare(strict_types=1);

namespace App\Orchid\Layouts\LearningContent;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Rows;
use Inertia\Inertia;
use Orchid\Screen\Layouts\View;
use Orchid\Support\Facades\Layout;
use PHPageBuilder\PHPageBuilder;
use App\Orchid\Fields\pagebuilder;

class ContentEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public $content;
    public function __construct($content = null)
    {
        $this->content = $content;
    }
    public function fields(): array
    {
        return [

            Input::make('learning_content.title')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Title'))
                ->placeholder(__('Title'))
                ->help(__('Learning content title')),

            Input::make('learning_content.description')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Description'))
                ->placeholder(__('Description'))
                ->help(__('Learning content description')),


            Quill::make('learning_content.content')
                ->toolbar(["text", "color", "header", "list", "format", "media"])
                ->required()
                ->title(__('Content'))
                ->placeholder(__('Content'))
                ->help(__('Learning content')),




        ];

    }


}
