@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
		</div>
            <div class="col-md-4 order-md-2 mb-4">
              <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">{{$cart->countProduct()}}</span>
              </h4>
              <ul class="list-group mb-3">
             

                @foreach($cart->getContents() as $slug => $product)
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                  <div>
                    <h6 class="my-0">{{$product['product']->title}}</h6>
                    <small class="text-muted">{{$product['qty']}}</small>
                  </div>
                  <span class="text-muted">{{$product['price']}}</span>
                </li>
                @endforeach
             
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>
                      
                        {{$cart->getTotalPrice()}}
                    </strong>
                  </li>
            
              </ul>
    
              
            </div>
            <div class="col-md-8 order-md-1">
              <h4 class="mb-3">Billing address</h4>
              <form class="needs-validation" novalidate="" method="POST" action={{route('checkout.store')}}>
                  @csrf
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="blling_firstName">First name</label>
                    <input type="text" class="form-control" id="firstName" placeholder="" value="" name="billing_firstName" required="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                    <div class="invalid-feedback">
                      Valid first name is required.
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="billing_lastName">Last name</label>
                    <input  name="billing_lastName" type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                    <div class="invalid-feedback">
                      Valid last name is required.
                    </div>
                  </div>
                </div>
    
                <div class="mb-3">
                  <label for="username">Username</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">@</span>
                    </div>
                    <input name="billing_username" type="text" class="form-control" id="username" placeholder="Username" required="">
                    <div class="invalid-feedback" style="width: 100%;">
                      Your username is required.
                    </div>
                  </div>
                </div>
    
                <div class="mb-3">
                  <label for="email">Email <span class="text-muted">(Optional)</span></label>
                  <input name="billing_email" type="email" class="form-control" id="email" placeholder="you@example.com">
            
                </div>
    
                <div class="mb-3">
                  <label for="address">Address</label>
                  <input name="billing_address1" type="text" class="form-control" id="address" placeholder="1234 Main St" required="">
                  <div class="invalid-feedback">
                    Please enter your shipping address.
                  </div>
                </div>
    
                <div class="mb-3">
                  <label for="address2">Address Line 2 <span class="text-muted">(Optional)</span></label>
                  <input type="text" name="billing_address2" class="form-control" id="address2" placeholder="Apartment or suite">
                </div>
    
                <div class="row">
                  <div class="col-md-5 mb-3">
                    <label for="country">Country</label>
                    <select name="billing_country" class="custom-select d-block w-100" id="country" required="">
                      <option value="">Choose...</option>
                      <option>United States</option>
                    </select>
                    <div class="invalid-feedback">
                      Please select a valid country.
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="state">State</label>
                    <select name="billing_state" class="custom-select d-block w-100" id="state" required="">
                      <option value="">Choose...</option>
                      <option>California</option>
                    </select>
                    <div class="invalid-feedback">
                      Please provide a valid state.
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="zip">Zip</label>
                    <input name="billing_zip" type="text" class="form-control" id="zip" placeholder="" required="">
                    <div class="invalid-feedback">
                      Zip code required.
                    </div>
                  </div>
                </div>
                <hr class="mb-4">
                <div class="custom-control custom-checkbox">
                  <input name="shipping_address" type="checkbox" class="custom-control-input" id="same-address">
                  <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="save-info">
                  <label class="custom-control-label" for="save-info">Checkout as Guest</label>
                </div>
                
    
                <div id="shipping_address" class="col-md-12 order-md-1">
                    <hr class="mb-4">
              <h4 class="mb-3">Shipping address</h4>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="shipping_firstName">First name</label>
                  <input type="text" class="form-control" id="firstName" placeholder="" value="" name="shipping_firstName" required="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                  <div class="invalid-feedback">
                    Valid first name is required.
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="shipping_lastName">Last name</label>
                  <input name="shipping_lastName" type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                  <div class="invalid-feedback">
                    Valid last name is required.
                  </div>
                </div>
              </div>
  
              <div class="mb-3">
                <label for="username">Username</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                  </div>
                  <input name="shipping_username" type="text" class="form-control" id="username" placeholder="Username" required="">
                  <div class="invalid-feedback" style="width: 100%;">
                    Your username is required.
                  </div>
                </div>
              </div>
  
              <div class="mb-3">
                <label for="email">Email <span class="text-muted">(Optional)</span></label>
                <input name="shipping_email" type="email" class="form-control" id="email" placeholder="you@example.com">
          
              </div>
  
              <div class="mb-3">
                <label for="address">Address</label>
                <input name="shipping_address1" type="text" class="form-control" id="address" placeholder="1234 Main St" required="">
                <div class="invalid-feedback">
                  Please enter your shipping address.
                </div>
              </div>
  
              <div class="mb-3">
                <label for="address2">Address Line 2 <span class="text-muted">(Optional)</span></label>
                <input type="text" name="shipping_address2" class="form-control" id="address2" placeholder="Apartment or suite">
              </div>
  
              <div class="row">
                <div class="col-md-5 mb-3">
                  <label for="country">Country</label>
                  <select name="shipping_country" class="custom-select d-block w-100" id="country" required="">
                    <option value="">Choose...</option>
                    <option>United States</option>
                  </select>
                  <div class="invalid-feedback">
                    Please select a valid country.
                  </div>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="state">State</label>
                  <select name="shipping_state" class="custom-select d-block w-100" id="state" required="">
                    <option value="">Choose...</option>
                    <option>California</option>
                  </select>
                  <div class="invalid-feedback">
                    Please provide a valid state.
                  </div>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="zip">Zip</label>
                  <input name="shipping_zip" type="text" class="form-control" id="zip" placeholder="" required="">
                  <div class="invalid-feedback">
                    Zip code required.
                  </div>
                </div>
              </div>
                 </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
              </form>
           </div>
          </div>

</div>    
@endsection
@section('scripts')
<script>
	$(function(){
		$('#same-address').on('change', function(){
			$('#shipping_address').slideToggle(!this.checked)
		})
	})
</script>
@endsection