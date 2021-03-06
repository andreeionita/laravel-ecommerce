@extends('admin.app')

@section("breadcrumbs")

      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">All Categories</li>

@endsection

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

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Slug</th>
                        <th>Categories</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($categories)
                        
                        @foreach ($categories as $cat)    
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td>{{ $cat->title }}</td>
                            <td style="white-space: break-spaces;
                            width: 378px;">{!! $cat->description  !!}</td>
                            <td>{{ $cat->slug  }}</td>
                            <td>
                                @if($cat->childrens()->count() > 0)
                                @foreach ($cat->childrens as $children)
                                    {{ $children->title }},
                                @endforeach
                                @else
                                   <b> {{"Parent Category"}} </b>
                                @endif
                            </td>
                            <td>{{ $cat->created_at }}</td>
                            <td>
                                <a href="{{ route('admin.category.edit' , $cat->id)}}" class="btn btn-info btn-sm">Edit</a> |

                                <a href="javascript:;" onclick="confirmDelete('{{ $cat->id}}')" class="btn btn-danger btn-sm">Delete</a> 
                                <form id="delete-category-{{ $cat->id }}" action={{ route('admin.category.destroy' ,  $cat->id)}} method="POST" style="display: none">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            </td>
                        </tr>

                        @endforeach

                        @else
                        <tr>
                            <td colspan="5">No Categories Found</td>
                        </tr>
                        @endif
                    
                    </tbody>
                </table>
                </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            {{ $categories->links()}}
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
    function confirmDelete(id){
        let option = confirm("Are you sure , You want to delete this ?")
        if(option){
            document.getElementById('delete-category'+id).submit();
        }
    }
</script>

@endsection()