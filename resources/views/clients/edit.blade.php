@extends('layouts.app')
@section('content')
<style>
  input{
    border: 1px solid #D8D6D5 !important;
  }

  textarea{
     border: 1px solid #D8D6D5 !important;
  }
</style>
<div class="card-header card-header-primary">
  <h4 class="card-title">Edit Client Data</h4>
</div>
<div class="card-body">
  <form action="{{ route('clients.update',$client->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row mt-3">
      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating"><b class="text-danger">* </b>Client Name</label>
          <input type="text" class="form-control border-bottom-0" name="name" value="{{$client->name}}" required>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating">Email</label>
          <input type="email" class="form-control border-bottom-0" name="email" value="{{$client->email}}">
        </div>
      </div>
      
    </div>

    <div class="row mt-3">
      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating">Phone</label>
          <input type="text" class="form-control border-bottom-0" name="phone" value="{{$client->phone}}">
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating">Address</label>
          <input type="text" class="form-control border-bottom-0" name="address" value="{{$client->address}}">
        </div>
      </div>
      
    </div>

      <div class="col-md-6 mt-3">
        <div class="form-control">
          <label class="bmd-label-floating">Photo</label>
          <input type="file" name="photo" />
          <input type="hidden" name="old_photo" value="{{$client->photo}}"/>
        </div>
      </div>
    </div>

    <div class="row mt-2">
      <div class="col-md-2 ml-4">
        <button type="submit" class="btn btn-success pull left">Save Data</button>
      </div>
    </div>
    <div class="clearfix"></div>
  </form>
</div>
@endsection