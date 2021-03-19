@extends('layouts.app');

@section('content');

<div class="album py-5 bg-light">
    <div class="container">

      <div class="row">
       
              
          <div class="col-md-12">
            <div class="card mb-4 box-shadow">
                <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img class="card-img-top" src="{{asset($product->thumbnail)}}" alt="{{$product->title}}" style="height: 225px; width: 100%; display: block;">
                    </div>
                    <div class="col-md-8">
                        <h4 class="card-text">{{$product->title}}</h4>
                        <p class="card-text">{!!$product->description!!}</p>
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="btn-group">
                      
                            <a type="button" href="{{ route('products.addToCart' , $product)}}" class="btn btn-sm btn-outline-secondary">Add To Cart</a>
                          </div>
                          <small class="text-muted">9 mins</small>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        
      </div>
    </div>
  </div>

  @endsection