<?php

declare(strict_types=1);

namespace App\Orchid\Screens\LearningContent;

use App\Models\LearningContent;
use App\Orchid\Layouts\LearningContent\ContentEditLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Inertia\Inertia;

class ContentEditScreen extends Screen
{
    /**
     * @var LearningContent
     */
    public $learningContent;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param LearningContent $content
     * @return array
     */
    public function query(LearningContent $content): array
    {
        return [
            'learning_content' => $content,1
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Edit Learning Content';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Modify the details of a learning content.';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block([
                ContentEditLayout::class,
            ])->title('Learning Content Details')
                ->description('Modify the details of the learning content.'),

            // Add a new block for the page builder
        ];
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, LearningContent $content)
    {
        $request->validate([
            'learning_content.title' => 'required',
            'learning_content.description' => 'required',
            'learning_content.content' => 'required'
        ]);

        $content->fill($request->get('learning_content'));
        $content->save();

        Toast::info(__('Learning content was saved'));

        return redirect()->route('platform.systems.learning-content');
    }


}
