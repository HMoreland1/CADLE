<?php

declare(strict_types=1);

namespace App\Orchid\Screens\LearningContent;

use App\Models\LearningContent;
use App\Orchid\Layouts\LearningContent\ContentEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ContentEditorScreen extends Screen
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
            Layout::view('content-editor') // Assuming 'content-editor.blade.php' is the name of your Blade template file
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
    /**
     * JavaScript assets to inject into the screen.
     *
     * @return array
     */
    public function js(): array
    {
        return [
            '<script src= "' .asset("/App/Orchid/Layouts/LearningContent/ContentEditLayout.js") . '"></script>'
        ];
    }
    public function openEditor()
    {
        redirect()->route('platform.systems.learning-content.create.editor');
    }

}
