@extends('admin.app')
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
<li class="breadcrumb-item "><a href="{{route('admin.profile.index')}}">users</a></li>
<li class="breadcrumb-item active" aria-current="page">Add/Edit users</li>
@endsection
@section('content')
<h2 class="modal-title">Add/Edit users</h2>
<form  action="@if(isset($user)) {{route('admin.profile.update', $user)}} @else {{route('admin.profile.store')}} @endif" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<div class="row">
		@csrf
		@if(isset($user))
		@method('PUT')
		@endif
		<div class="col-lg-9">
			<div class="form-group row">
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
				<div class="col-sm-12">
					@if (session()->has('message'))
					<div class="alert alert-success">
						{{session('message')}}
					</div>
					@endif
				</div>
				<div class="col-sm-12 col-md-6">
					<label class="form-control-label">Name: </label>
					<input type="text" id="txturl" name="name" class="form-control " value="{{@$user->profile->name}}" />
					<p class="small">{{route('admin.profile.index')}}/<span id="url">{{@$user->profile->slug}}</span>
					<input type="hidden" name="slug" id="slug" value="{{@$user->profile->slug}}">
				</p>
			</div>
			<div class="col-sm-12 col-md-6">
				<label class="form-control-label">Email: </label>
				<input type="text" id="email" name="email" class="form-control " value="{{@$user->email}}" />
				
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12 col-md-6">
				<label class="form-control-label">Password: </label>
				<input type="password" id="password" name="password" class="form-control " value="{{@$user->profile->name}}" />
				
			</div>
			<div class="col-sm-12 col-md-6">
				<label class="form-control-label">Re-Type Password: </label>
				<input type="password" id="password_confirm" name="password_confirm" class="form-control " value="" />
				
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label class="form-control-label">Status</label>
				<div class="input-group mb-3">
					<select class="form-control" id="status" name="status">
						<option value="0" @if(isset($user) && $user->status == 0) {{'selected'}} @endif >Blocked</option>
						<option value="1" @if(isset($user) && $user->status == 1) {{'selected'}} @endif>Active</option>
					</select>
				</div>
			</div>
			@php
			$ids = (isset($user->role) && $user->role->count() > 0 ) ? array_pluck($user->role->toArray(), 'id') : null;
			@endphp
			
			<div class="col-sm-6">
				<label class="form-control-label">Select Role</label>
				<select name="role_id" id="role" class="form-control">
					@if($roles->count() > 0)
					@foreach($roles as $role)
					<option value="{{$role->id}}"
						@if(!is_null($ids) && in_array($role->id, $ids))
						{{'selected'}}
					@endif>{{$role->name}}</option>
					@endforeach
					@endif
				</select>
			</div>
		</div>
		<div class="row">
			<h4 class="title">Address</h4>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label class="form-control-label">Address: </label>
				<div class="input-group mb-3">
					<input type="text" name="address" class="form-control " value="{{@$user->addrress}}" />
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6 col-md-3">
				<label class="form-control-label">Country: </label>
				<div class="input-group mb-3">
					<select name="country_id" class="form-control" id="countries" multiple>
					
						@foreach($countries as $country)
						<option value="{{$country->id}}">{{$country->name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<label class="form-control-label">State: </label>
				<div class="input-group mb-3">
					<select name="state_id" class="form-control" id="states" multiple>
						<option value="0">Select a State</option>
					</select>
				</div>
			</div>
			
			<div class="col-sm-6 col-md-3">
				<label class="form-control-label">City: </label>
				<div class="input-group mb-3">
					<select name="city_id" class="form-control" id="cities" multiple>
						
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<label class="form-control-label">Phone: </label>
				<div class="input-group mb-3">
					<input type="text" class="form-control" name="phone" placeholder="Phone" value="{{@$user->phone}}" />
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<ul class="list-group row">
			
			<li class="list-group-item active"><h5>Profile Image</h5></li>
			<li class="list-group-item">
				<div class="input-group mb-3">
					<div class="custom-file ">
						<input type="file"  class="custom-file-input" name="thumbnail" id="thumbnail">
						<label class="custom-file-label" for="thumbnail">Choose file</label>
					</div>
				</div>
				<div class="img-thumbnail  text-center">
					<img src="@if(isset($user)) {{asset($user->thumbnail)}} @else {{asset('https://reactnativecode.com/wp-content/uploads/2018/02/Default_Image_Thumbnail.png')}} @endif" id="imgthumbnail" class="img-fluid" alt="">
				</div>
			</li>
			<li class="list-group-item">
				<div class="form-group row">
					<div class="col-lg-12">
						@if(isset($user))
						<input type="submit" name="submit" class="btn btn-primary btn-block " value="Update user" />
						@else
						<input type="submit" name="submit" class="btn btn-primary btn-block " value="Add user" />
						@endif
					</div>
					
				</div>
			</li>
		</ul>
	</div>
</div>
</form>
@endsection
@section('js')
<script type="text/javascript">
	$(function(){


			$('#txturl').on('keyup', function(){
				var url = $(this).val();
				url = url.toLowerCase();
				url = url.replace(/[^a-zA-Z0-9]+/g,'-');
				$('#url').html(url);
				$('#slug').val(url);
			})

			$('#thumbnail').on('change', function() {
			var file = $(this).get(0).files;
			var reader = new FileReader();
			reader.readAsDataURL(file[0]);
			reader.addEventListener("load", function(e) {
			var image = e.target.result;
			$("#imgthumbnail").attr('src', image);
			});
			});

    });

    $(document).ready(function () {

                    $('#countries').select2()
            $('#states').select2();
            $('#cities').select2();

            $('#countries').on('change', function () {
                var idCountry = this.value;
                $("#states").html('');
                $.ajax({
                    url: "{{route('admin.profile.states')}}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#states').html('<option value="">Select State</option>');
                        $.each(result.states, function (key, value) {
                            $("#states").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#cities').html('<option value="">Select City</option>');
                    }
                });
            });
            $('#states').on('change', function () {
                var idState = this.value;
                console.log(idState)
                $("#cities").html('');
                $.ajax({
                    url: "{{route('admin.profile.cities')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#cities').html('<option value="">Select City</option>');
                        $.each(res.cities, function (key, value) {
                            $("#cities").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
		

			</script>
@endsection	