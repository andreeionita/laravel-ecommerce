    <div class="album py-5 bg-light">
      <div class="container">

        <div class="row">
            @foreach ($products as $product)
                
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="{{asset($product->thumbnail)}}" alt="{{$product->title}}" style="height: 225px; width: 100%; display: block;">
                <div class="card-body">
                  <p class="card-text">{!!$product->title!!}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href={{route('products.single' ,$product )}} type="button" class="btn btn-sm btn-outline-secondary">View Product</a>
                      <a href="{{ route('products.addToCart' , $product)}}" type="button" class="btn btn-sm btn-outline-secondary">Add To Cart</a>
                    </div>
                    <small class="text-muted">9 mins</small>
                  </div>
                </div>
              </div>
            </div>
            
            @endforeach

        </div>
        <div class="row">
          <div class="col-md-12">
            {{ $products->links()}}
          </div>
        </div>
      </div>
    </div>
