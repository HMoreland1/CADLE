<?php

declare(strict_types=1);

namespace App\Orchid\Screens\LearningContent\ContentCreation;

use App\Models\LearningContent;
use App\Models\Pathway;
use App\Models\Quiz;
use App\Models\Role;
use App\Orchid\Layouts\LearningContent\ContentCreation\ContentEditLayout;
use App\Orchid\Layouts\LearningContent\ContentCreation\ContentQuizListLayout;
use App\Orchid\Layouts\Pathways\PathwayContentListLayout;
use App\Orchid\Layouts\Role\RolePermissionLayout;
use App\Orchid\Layouts\Pathways\PathwayEditLayout;
use Harishdurga\LaravelQuiz\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Orchid\Access\Impersonation;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Dashboard;

class ContentEditScreen extends Screen
{

    /**
     * @var LearningContent
     */
    public $content;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(LearningContent $content): array
    {
        return [
            'content' => $content,
            'contents' => "test",
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
        return $this->content->exists ? 'Edit Content' : 'Create Content';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return $this->content->exists ? 'Edit existing learning content.' : 'Create new learning content.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.pathways',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Once the pathway is deleted, all of its resources and data will be permanently deleted. Before deleting the pathway, please download any data or information that you wish to retain.'))
                ->method('remove')
                ->canSee($this->content->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::block(ContentEditLayout::class)
                ->title(__('Content Information'))
                ->description(__('Set the content details'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->content->exists)
                        ->method('save')
                ),
            Layout::block(ContentQuizListLayout::class)
                ->title(__('Quizzes'))
                ->description(__('Set the content details'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->content->exists)
                        ->method('save')
                ),

            Layout::view('scorm_creator'),
            Layout::view('ContentManagement/ContentQuizCheckbox', [
            ]),

        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(LearningContent $content, Request $request)
    {



        // Validate the request data
        $request->validate([
            'content.title' => 'required|string|max:255',
            'content.description' => 'nullable|string',
            'selected_quiz' => 'required',
            'canvas_json' => 'required',
            // Add more validation rules as needed
        ]);

        // Update the pathway's name and description
        $content->title = $request->input('content.title');
        $content->description = $request->input('content.description');
        $content->content = $request->input('canvas_json');
        $content->quiz_id = $request->get('selected_quiz');
        $selectedQuizzes = $request->get('selected_quiz');

// $selectedQuizzes is now an array containing the IDs of the selected quizzes

        $content->save();


        // Show success message
        Toast::info(__('Content details have been saved.'));

        return redirect()->route('platform.systems.learningcontent');
    }




    // Remaining methods...
}
