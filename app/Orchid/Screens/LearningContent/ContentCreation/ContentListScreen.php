<?php

declare(strict_types=1);

namespace App\Orchid\Screens\LearningContent\ContentCreation;
use App\Models\LearningContent;
use App\Models\Question;
use App\Models\Quiz;
use App\Orchid\Layouts\LearningContent\ContentCreation\ContentListLayout;
use App\Orchid\Layouts\Quiz\QuestionListLayout;
use Harishdurga\LaravelQuiz\Models\QuizQuestion;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ContentListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'contents' =>  LearningContent::query()
                ->filters()
                ->defaultSort('content_id', 'desc')
                ->paginate(5)
        ];
    }


    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Content Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all Learning Content.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.learningcontent',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save Content'))
                ->icon('bs.check-circle')
                ->id('saveButton')
                ->method('save'),

            Link::make(__('Add'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.learningcontent.create'),
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

            ContentListLayout::class,

        ];

    }

    /**
     * @return array
     */

    public function remove(Request $request): void
    {
        LearningContent::findOrFail($request->get('content_id'))->delete();

        Toast::info(__('Content was removed'));
    }

    public function save(Request $request)
    {

    }






}
