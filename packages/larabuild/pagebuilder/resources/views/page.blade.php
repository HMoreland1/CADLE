@extends(config('pagebuilder.site_layout'),['page' => $page, 'edit' => false ])

@section(config('pagebuilder.site_section'))
{!! $pageSections !!}
@endsection
