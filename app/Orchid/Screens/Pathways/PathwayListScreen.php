<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Pathways;

use App\Http\Controllers\ReactControllers\SCORMCreator;
use App\Models\Pathway;
use App\Orchid\Layouts\Pathways\PathwayEditLayout;
use App\Orchid\Layouts\Pathways\PathwayListLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Blank;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PathwayListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'pathways' => Pathway::query()
                ->filters()
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Pathway Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all pathways.';
    }

    /**
     * Permissions required to access this screen.
     *
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.systems.pathways',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make(__('Add'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.pathways.create'),


            Button::make(__('Delete'))
                ->icon('bs.trash')
                ->confirm(__('Are you sure you want to delete this pathway?'))
                ->method('remove'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            PathwayListLayout::class,

        ];
    }

    /**
     * Get the pathway data asynchronously.
     *
     * @param Pathway $pathway
     * @return array
     */

    /**
     * Save the pathway data.
     *
     * @param Request $request
     * @param Pathway $pathway
     * @return void
     */
    public function save(Request $request, Pathway $pathway): void
    {
        $request->validate([
            'pathway.name' => ['required', 'string', 'max:255'],
            'pathway.description' => ['required', 'string'],
        ]);

        $pathway->update($request->input('pathway'));

        Toast::info(__('Pathway was updated.'));
    }

    /**
     * Remove the pathway.
     *
     * @param Request $request
     * @return void
     */
    public function remove(Request $request): void
    {
        $pathway = Pathway::findOrFail($request->get('id'));
        $pathway->delete();

        Toast::info(__('Pathway was removed.'));
    }
}
