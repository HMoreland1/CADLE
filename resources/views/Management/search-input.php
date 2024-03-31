<?php
// resources/views/search-input.php

use Orchid\Screen\Fields\Input;

Input::make('search')
    ->placeholder('Search quizzes')
    ->title('Search')
    ->value(request()->input('search'))
    ->onChange('searchQuizzes');
