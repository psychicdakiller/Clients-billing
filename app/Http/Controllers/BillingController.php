<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Billing;
use App\Models\Client;
use DB;

class BillingController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billings = Billing::paginate(10);

        return view('billing.index',compact('billings'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();

        return view('billing.create',compact('clients'));
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
            'Amount' => 'required',
            'DueDate' => 'required',
        ]);
        DB::beginTransaction();
        try{
            

            $billing = Billing::create([
                'Amount' => $request->Amount,
                'DueDate' => $request->DueDate,
                'client_id' => $request->client_id,
                'description' => $request->description,
            ]);
            

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    
        return redirect()->route('billings.index')
                        ->with('success','Billing created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $billing = Billing::findOrFail($id);

        return view('billing.show',compact('billing'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $billing = Billing::findOrFail($id);
        $clients = Client::all();
        return view('billing.edit',compact('billing','clients'));
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
        $this->validate($request, [
            'Amount' => 'required',
            'DueDate' => 'required',
        ]);
        DB::beginTransaction();
        try{
            $billing = Billing::findOrFail($id);

            $billing->update([
                'Amount' => $request->Amount,
                'DueDate' => $request->DueDate,
                'client_id' => $request->client_id,
                'description' => $request->description,
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();              
            return response()->json(['error' => $ex->getMessage()], 500);
        }  
    
        return redirect()->route('billings.index')
                        ->with('success','Billing updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $billing = Billing::findOrFail($id);
        $billing->delete();
    
        return redirect()->route('billings.index')
                        ->with('success','Billing deleted successfully');
    }
}
