<?php
namespace App\Orchid\Screens;

use Orchid\Screen\Screen;

class TaskScreen extends Screen
{
    /**
     * A method that defines all screen input data
     * is in it that database queries should be called,
     * api or any others (not necessarily explicit),
     * the result of which should be an array,
     * appeal to which his keys will be used.
     */
    public function query(): array
    {
        return [];
    }

    /**
     * The name is displayed on the user's screen and in the headers
     */
    public function name(): ?string
    {
        return "TaskScreen";
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "TaskScreen";
    }

    /**
     * Identifies control buttons and events.
     * which will have to happen by pressing
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Set of mappings
     * rows, tables, graphs,
     * modal windows, and their combinations
     */
    public function layout(): array
    {
        return [];
    }
}
