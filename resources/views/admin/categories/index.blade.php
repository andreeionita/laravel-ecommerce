@extends('admin.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h2>Categories</h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('admin.category.create')}}" class="btn btn-primary">Add New Category</a>
        </div>
    </div>
</div>

@endsection