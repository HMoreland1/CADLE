<?php

declare(strict_types=1);

namespace App\Orchid\Screens\LearningContent;

use App\Models\LearningContent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\LearningContent\ContentListLayout;

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
            'learning_contents' => LearningContent::filters()->defaultSort('content_id', 'desc')->paginate(),
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
        return 'A comprehensive list of all learning content.';
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
            Link::make(__('Add'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.learning-content.create'),
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
     * @param LearningContent $content
     * @return array
     */
    public function asyncGetContent(LearningContent $content): array
    {
        return [
            'content' => $content,
        ];
    }

    /**
     * @param Request $request
     * @param LearningContent $content
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveContent(Request $request, LearningContent $content): void
    {
        $request->validate([
            'learning_content.title' => 'required',
            'learning_content.description' => 'required',
            'learning_content.content' => 'required',
            // Add any other validation rules as needed
        ]);

        $content->fill($request->input('content'))->save();

        Toast::info(__('Content was saved.'));
    }

    /**
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        LearningContent::findOrFail($request->get('id'))->delete();

        Toast::info(__('Content was removed'));
    }
}
