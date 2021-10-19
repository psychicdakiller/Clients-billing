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
  <h4 class="card-title">Edit Billing Data</h4>
</div>
<div class="card-body">
  <form action="{{ route('billings.update',$billing->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row mt-3">
      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating"><b class="text-danger">* </b>Amount </label>
          <input type="number" class="form-control border-bottom-0" name="Amount" required value="{{$billing->Amount}}">
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating"><b class="text-danger">* </b>Due Date</label>
          <input type="date" class="form-control border-bottom-0" name="DueDate" required value="{{$billing->DueDate}}">
        </div>
      </div>
      
    </div>

    <div class="row mt-3">
      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating"><b class="text-danger">* </b>Client Name</label>
          <select class="form-control border-bottom-0" name="client_id">
            @foreach ($clients as $c)
              <option value="{{$c->id}}" {{$billing->client_id == $c->id  ? 'selected' : ''}}>{{$c->name}}</option>
            @endforeach
            
          </select>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating">Description</label>
          <textarea type="text" class="form-control border-bottom-0" name="description">{{$billing->description}}</textarea>
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