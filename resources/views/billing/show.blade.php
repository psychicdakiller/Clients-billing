@extends('layouts.app')
    @section('content')
    <div class="card-header card-header-primary">
          <h4 class="card-title" style="text-transform: capitalize;">{{ $billing->name }}</h4>
          <p class="card-category">{{ $billing->client->name }}'s Description</p>
        </div>
        <div class="card-body">

          <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <strong>Amount: </strong>
                    </div>
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10">
                    <div class="form-group">
                        {{ $billing->Amount }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <strong>Due Date: </strong>
                    </div>
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10">
                    <div class="form-group">
                        {{ $billing->DueDate }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <strong>Client Name: </strong>
                    </div>
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10">
                    <div class="form-group">
                        {{ $billing->client->name }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <strong>Description: </strong>
                    </div>
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10">
                    <div class="form-group">
                        {{ $billing->description }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mt-4">
                        <a class="btn btn-primary" href="{{ route('billings.index') }}"> Back</a>
                </div>
            </div>
        </div>
    @endsection