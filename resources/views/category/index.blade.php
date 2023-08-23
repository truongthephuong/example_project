@extends('category.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Example - Category Section</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('categories.create') }}"> Create New Category</a>
            </div>
        </div>

    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>Name</th>
            <th width="280px">Action</th>
        </tr>

        @foreach ($categories as $cate)

        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $cate->id }}</td>
            <td>{{ $cate->name }}</td>
            <td>
                <form action="{{ route('categories.destroy',$cate->id) }}" method="POST">
                    <a class="btn btn-info" href="#">Show</a>
                    <a class="btn btn-primary" href="#">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>

        @endforeach
    </table>

    {!! $categories->links() !!}
      
@endsection