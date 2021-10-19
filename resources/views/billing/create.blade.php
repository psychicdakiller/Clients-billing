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
  <h4 class="card-title">Create Billing Data</h4>
</div>
<div class="card-body">
  <form action="{{ route('billings.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row mt-3">
      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating"><b class="text-danger">* </b>Amount </label>
          <input type="number" class="form-control border-bottom-0" name="Amount" required>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating"><b class="text-danger">* </b>Due Date</label>
          <input type="date" class="form-control border-bottom-0" name="DueDate" required>
        </div>
      </div>
      
    </div>

    <div class="row mt-3">
      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating"><b class="text-danger">* </b>Client Name</label>
          <select class="form-control border-bottom-0" name="client_id">
            @foreach ($clients as $c)
              <option value="{{$c->id}}">{{$c->name}}</option>
            @endforeach
            
          </select>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="bmd-label-floating">Description</label>
          <textarea type="text" class="form-control border-bottom-0" name="description"></textarea>
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