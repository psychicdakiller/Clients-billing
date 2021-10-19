@extends('layouts.app')
    @section('content')
    <div class="card-header card-header-primary">
          <p class="card-category">{{ $client->name }}'s Description</p>
        </div>
        <div class="card-body">

          <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <strong>Name: </strong>
                    </div>
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10">
                    <div class="form-group">
                        {{ $client->name }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <strong>Email: </strong>
                    </div>
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10">
                    <div class="form-group">
                        {{ $client->email }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <strong>Phone: </strong>
                    </div>
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10">
                    <div class="form-group">
                        {{ $client->phone }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <strong>Address: </strong>
                    </div>
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10">
                    <div class="form-group">
                        {{ $client->address }}
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <strong>Client Photo: </strong>
                        <img src="{{ Storage::url($client->photo) }}" width="100" height="100" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mt-4">
                        <a class="btn btn-primary" href="{{ route('clients.index') }}"> Back</a>
                </div>
            </div>
        </div>
    @endsection