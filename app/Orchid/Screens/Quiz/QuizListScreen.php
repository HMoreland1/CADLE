<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Quiz;
use App\Orchid\Layouts\Quiz\QuizListLayout;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class QuizListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'quizzes' => Quiz::filters()
                ->defaultSort('id', 'desc')
                ->paginate(5),
        ];
    }




    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Quiz Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all Quizzes.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.quizzes',
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
            Link::make(__('Add'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.quizzes.create'),
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
            QuizListLayout::class,


        ];

    }

    /**
     * @return array
     */
    public function asyncGetQuiz(Quiz $quiz): iterable
    {
        return [
            'quiz' => $quiz,
        ];
    }



    public function remove(Request $request): void
    {
        Quiz::findOrFail($request->get('id'))->delete();

        Toast::info(__('Quiz was removed'));
    }


}
