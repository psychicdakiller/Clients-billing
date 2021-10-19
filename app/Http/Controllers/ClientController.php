<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use DB;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::paginate(10);
        return view('clients.index',compact('clients'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        DB::beginTransaction();
        try{
            

            $client = Client::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            if ($request->hasfile('photo')) {
            $path = $request->file('photo')->store('public');

            $client->update(['photo'=>$path]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    
        return redirect()->route('clients.index')
                        ->with('success','Client created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);

        return view('clients.show',compact('client'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);

        return view('clients.edit',compact('client'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
        ]);
        DB::beginTransaction();
        try{
            $client = Client::findOrFail($id);

            $client->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            if ($request->hasfile('photo')) {
                if (!is_null($client->photo)) {
                    Storage::delete($request->old_photo);
                    
                }

                    $path = $request->file('photo')->store('public');

                    $client->update(['photo'=>$path]);
                
            }else{
                $client->update(['photo'=>$request->old_photo]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();              
            return response()->json(['error' => $ex->getMessage()], 500);
        }  
    
        return redirect()->route('clients.index')
                        ->with('success','Client updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        if (!is_null($client->photo)) {
                    Storage::delete($client->photo);
                    
                }
        $client->delete();
    
        return redirect()->route('clients.index')
                        ->with('success','Client deleted successfully');
    }
}
