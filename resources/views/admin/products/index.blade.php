@extends('admin.app')

@section("breadcrumbs")

      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">All Products</li>

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h2>Products</h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('admin.product.create')}}" class="btn btn-primary">Add New Product</a>
        </div>
        <div class="col-md-12">
            @if(session('message'))
            <ul class="alert alert-success">
                <li>{{ session('message')}}</li>
            </ul>
            @endif
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
                        <th>Price</th>
                        <th>Thumbnail</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                      
                        @if($products->count() > 0)
                        @foreach ($products as $product)    
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->title }}</td>
                            <td style="white-space: break-spaces;
                            width: 378px;">{!! $product->description  !!}</td>
                            <td>{{ $product->slug  }}</td>
                            <td>
                                @if($product->categories()->count() > 0)
                                @foreach ($product->categories as $children)
                                    {{ $children->title }},
                                @endforeach
                                @else
                                   <b> {{"Product"}} </b>
                                @endif
                            </td>
                            <td>Rs{{$product->price}}</td>
                            <td><img src="{{asset($product->thumbnail)}}" alt="{{$product->title}}" class="img-responsive" height="50"/></td>
                           
                            {{-- <td>{{ $product->created_at}}</td> --}}
                            
                            @if($product->trashed())

                            {{-- if it is trashed --}}

                            <td>{{$product->deleted_at}}</td>
                            <td><a class="btn btn-info btn-sm" href="{{route('admin.product.recover',$product->id)}}">Restore</a> | <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$product->id}}')">Delete</a>
                                <form id="delete-product-{{$product->id}}" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display: none;">

                                @method('DELETE')
                                @csrf
                                </form>
                            </td>
                            @else

                            {{-- if it is not trashed --}}

                            <td>{{$product->created_at}}</td>
                            <td>
                                <a href="{{ route('admin.product.edit' , $product->id)}}" class="btn btn-info btn-sm">Edit</a> |
                                <a id="trashed-product-{{ $product->id }}" class="btn btn-warning btn-sm"  href="{{ route('admin.product.remove' , $product->id)}}">Trash</a>
                                |

                                <a href="javascript:;" onclick="confirmDelete('{{ $product->id}}')" class="btn btn-danger btn-sm">Delete</a> 
                                <form id="delete-product-{{ $product->id }}" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display: none;">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            </td>
                            @endif
                        </tr>

                        @endforeach

                        @else
                        
                        <tr>
                            <td colspan="5" class="alert alert-info">No Products Found..</td>
                        </tr>
                        @endif
                    
                    </tbody>
                </table>
                </div>
        </div>
    </div>
</div>
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
        </script>
    <script>

    function confirmDelete(id){
        let option = confirm("Are you sure , you wnat to delete it");
        if(option){
            console.log(id);
            document.getElementById('delete-product-'+id).submit();
        }
    }
        </script>
@endsection