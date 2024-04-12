<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Pathways;

use App\Models\LearningContent;
use App\Models\Pathway;
use App\Models\Role;
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

class PathwayEditScreen extends Screen
{
    /**
     * @var Pathway
     */
    public $pathway;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Pathway $pathway, LearningContent $learningContent): iterable
    {
        if ($pathway !== null) {
            $assignedContent = $pathway->content_ids;
        }
        else{
            $assignedContent = [];
        }
       // dd($assignedContent);
        return [
            'pathway' => $pathway,
            'content'  => LearningContent::paginate(8),
            'assignedContent' => $assignedContent,
            // You can define other data to be queried here if needed
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->pathway->exists ? 'Edit Pathway' : 'Create Pathway';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Pathway profile and privileges, including associated roles.';
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
                ->canSee($this->pathway->exists),

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

            Layout::block(PathwayEditLayout::class)
                ->title(__('Profile Information'))
                ->description(__('Update pathway profile information and email address.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->pathway->exists)
                        ->method('save')
                ),
            Layout::block(PathwayContentListLayout::class)
                ->title(__('Learning Content'))
                ->description(__('Select Learning Content to be included within the pathway'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->pathway->exists)
                        ->method('save')
                )

        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Pathway $pathway, Request $request)
    {
        // Validate the request data
        $request->validate([
            'pathway.name' => 'required|string|max:255',
            'pathway.description' => 'nullable|string',
            // Add more validation rules as needed
        ]);

        // Update the pathway's name and description
        $pathway->name = $request->input('pathway.name');
        $pathway->description = $request->input('pathway.description');

        // Convert selected content IDs to integers
        $contentIds = array_map('intval', $request->input('content_ids', []));

        // Save the pathway details
        $pathway->content_ids = $contentIds;
        $pathway->save();

        // Show success message
        Toast::info(__('Pathway details have been saved.'));

        return redirect()->route('platform.systems.pathways');
    }




    // Remaining methods...
}
