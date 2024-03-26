<!-- resources/views/ContentList.blade.php -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="subheader">Pages</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <!-- Add more columns as needed -->
                            </tr>
                        </thead>
                        <tbody>
@foreach($pages as $page)
    <tr>
        <td>{{ $page->id }}</td>
        <td>{{ $page->name }}</td>
        <!-- Display more attributes as needed -->
    </tr>
    @endforeach
    </tbody>
    </table>
    </div>
    {{ $pages->links() }} <!-- Pagination links -->
    </div>
    </div>
    </div>
    </div>
