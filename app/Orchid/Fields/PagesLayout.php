<?php
namespace App\Orchid\Fields;

use Orchid\Screen\Layouts\Component;
use Orchid\Support\Facades\Layout;
use Larabuild\Pagebuilder\Models\Page;

class PagesLayout extends Component
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'pages';

    /**
     * PagesLayout constructor.
     *
     * @param string $component
     */
    public function __construct(string $component = null)
    {
        parent::__construct('pages_layout');
    }

    /**
     * Load the data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'pages' => Page::when(request()->input('search'), function ($query) {
                return $query->where('name', 'like', '%' . request()->input('search') . '%');
            })->orderBy('id', request()->input('sort') ?? 'asc')->paginate(request()->input('per_page') ?? 10),
        ];
    }

    /**
     * Render the layout.
     *
     * @return \Orchid\Screen\Layout
     */
    public function layout(): array
    {
        return [
            Layout::view('pagebuilder::components.pages-list', [
                'pages' => $this->query()['pages'],
            ]),
        ];
    }
}
