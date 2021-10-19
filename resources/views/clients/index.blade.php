@extends('layouts.app')
	@section('content')
			<div class="card-header card-header-primary">
			  <h4 class="card-title ">Client DATAs</h4>
			</div>
			@if ($message = Session::get('success'))
		        <div class="alert alert-success alert-dismissible fade show" role="alert">
		            <p>{{ $message }}</p>
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
		        </div>
		    @endif
			<div class="card-body">
				<div class="row">
					<div class="col-md-10 col-sm-4">
						
					</div>
					<div class="col-md-2 col-sm-4">
						<a href="{{ route('clients.create') }}" class="btn btn-success pull-right btn-round text-white">Add New Data</a>
					</div>
				</div>
				
			  <div class="table-responsive">
			    <table class="table">
			      <thead class=" text-primary">
			        <th>
			          No
			        </th>
			        <th>
			          Photo
			        </th>
			        <th>
			          Name
			        </th>
			        <th>
			          Email
			        </th>
			        <th>
			        	Phone
			        </th>
			        <th>
			        	Address
			        </th>
			        {{-- <th>
			        	Actions
			        </th> --}}
			      </thead>
			      <tbody>
			      	@foreach ($clients as $key => $value)
			        <tr>
			          <td class="align-text-top">{{++$i}}</td>
			          <td class="align-text-top"><img src="{{ Storage::url($value->photo) }}" width="100" height="100" /></td>

			          <td class="align-text-top">{{$value->name}}</td>
			          <td style="white-space: pre-line">{{$value->email}}</td>
			          <td class="align-text-top">{{$value->phone}}</td>
			          {{-- <td class="align-text-top">{{$value->address}}</td> --}}
			          	<td class="align-text-top">
			                <form action="{{ route('clients.destroy',$value->id) }}" method="POST">   
			                    <a class="btn btn-sm btn-round btn-info" href="{{ route('clients.show',$value->id) }}">Show</a>    
			                    <a class="btn btn-sm btn-round btn-primary" href="{{ route('clients.edit',$value->id) }}">Edit</a>   
			                    @csrf
			                    @method('DELETE')      
			                    <button type="submit" class="btn btn-sm btn-round btn-danger delete_btn" onclick="return confirm('Are you sure?');">Delete</button>
			                </form>
			            </td>
			        </tr>
			        @endforeach
			      </tbody>
			    </table>
			    
			  </div>
			</div>
			{{ $clients->withQueryString()->links() }}
@endsection