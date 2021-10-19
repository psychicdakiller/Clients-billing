<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\AddOn;
use App\Models\ProductSpecification;
use Brian2694\Toastr\Facades\Toastr;
use DB;
use Session;

class ProductController extends Controller
{
    /*public function fileupload(Request $request){

     if($request->hasFile('file')) {

       // Upload path
       $destinationPath = 'files/';

       // Get file extension
       $extension = $request->file('file')->getClientOriginalExtension();

       // Valid extensions
       $validextensions = array("jpeg","jpg","png","pdf");

       // Check extension
       if(in_array(strtolower($extension), $validextensions)){

         // Rename file 
         $fileName = $request->file('file')->getClientOriginalName().time() .'.' . $extension;
         // Uploading file to given path
         $request->file('file')->move($destinationPath, $fileName); 

       }

     }
  }

  public  function dropZone(Request $request)  
    {  
        $file = $request->file('file');
        $fileName = time().'.'.$image->extension();
        $file->move(public_path('filess'),$fileName);
        return response()->json(['success'=>$fileName]);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::orderBy('name', 'asc')->paginate(20);
        $total = Product::all();
        
        return view('product.index',compact('data','total'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    function action(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = Product::where('name', 'like', $query.'%')
         ->orwhere('keyword', 'like', '%'.$query.'%')
         ->get();
         
      }
      else
      {
       $data = Product::orderBy('name', 'asc')->get();
      }
      $total_row = $data->count();
      $i=1;
      
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $show = route('products.show',$row->id);
        $edit = route('products.edit',$row->id);
        $delete = route('products.destroy',$row->id);
        $token = Session::token();
        $output .= '
        <tr>
         <td class="align-text-top">'.$i++.'</td>
         <td class="align-text-top">'.$row->name.'</td>
         <td class="align-text-top">'.$row->category->name.'</td>
         <td class="align-text-top">'.$row->sub_category->name.'</td>
         <td class="align-text-top">'.$row->unit_value.'</td>
         <td class="align-text-top">'.$row->price.'</td>
         <td class="align-text-top">
         <form action="'.$delete.'" method="POST">   
            <a class="btn btn-sm btn-round btn-info" href="'.$show.'">Show</a>
            <a class="btn btn-sm btn-round btn-primary" href="'.$edit.'">Edit</a> 
            <input type="hidden" name="_token" id="csrf-token" value="'.$token.'" />
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-sm btn-round btn-danger" onclick="return myFunction()">Delete</button>
        </form>   
        </td>


        </tr>
        <script>
function myFunction() {
  return confirm("are you sure you want to delete the data?");
}
</script>';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $addons = AddOn::all();
        return view('product.create',compact('categories','addons'));
    }

    public function select($id)
    {
        $sub_cats = SubCategory::where("category_id",$id)->pluck("name","id");
        return json_encode($sub_cats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'addon' => 'required',
            'highlight_information' => 'required',
            'code' => 'required',
            'price' => 'required',
            'min_order' => 'required',
            'max_order' => 'required',
            'unit_value' => 'required',
            'unit' => 'required',
            'keyword' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasfile('image')) {
            $profile = $request->file('image');
            $upload_path =public_path().'/files/';
            $name = $request->name.time().'.'.$profile->getClientOriginalExtension();
            $profile->move($upload_path,$name);
            $att = '/files/'.$name;
        }else{
            $att= "";
        }

        $product = Product::create($request->all());

        $product->update(['image'=>$att]);

        $i = 0;
        $title=$request->title;
        $spec_des=$request->spec_des;

        if (!is_null($title) && !is_null($spec_des)) {
            foreach ($title as $value) {
                        if ($value) {
                        ProductSpecification::create([
                            "product_id"=>$product->id,
                            'title' => $title[$i],
                            'description' => $spec_des[$i],
                        ]);

                        $i++;
                    }
                }
        }
                    

        Toastr::success('Candidate created successfully.');

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $pro_specs = ProductSpecification::where('product_id',$product->id)->get();
        return view('product.show',compact('product','pro_specs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $sub_cats = SubCategory::all();
        $addons = AddOn::all();
        $pro_specs = ProductSpecification::where('product_id',$product->id)->get();

        return view('product.edit',compact('product','categories','addons','sub_cats','pro_specs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (is_null($request->NewTitle[0]) && is_null($request->NewDescription[0])) {
            $request->validate([
                'name' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'addon' => 'required',
                'highlight_information' => 'required',
                'code' => 'required',
                'price' => 'required',
                'min_order' => 'required',
                'max_order' => 'required',
                'unit_value' => 'required',
                'unit' => 'required',
                'keyword' => 'required',
                'description' => 'required',
            ]);

            if ($request->hasfile('image')) {
                $profile = $request->file('image');
                $upload_path =public_path().'/files/';
                $name = $request->name.time().'.'.$profile->getClientOriginalExtension();
                $profile->move($upload_path,$name);
                $att = '/files/'.$name;
            }else{
                $att= request('old_att');
            }

            $product = Product::findOrFail($id);

            $product->update($request->all());

            if (!is_null($request->image)) {
                $file_old = public_path() . $product->attachment;
                unlink($file_old);

                $product->update(['image'=>$att]);
            }else{
                $product->update(['image'=>$att]);
            }
            
            $spec_id=$request->spec_id;
            $title=$request->title;
            $spec_des=$request->spec_des;

                foreach ($title as $key => $value) {
                        // dd($Sno[$key]);
                    if ($value) {
                        $ps=ProductSpecification::where('id',$spec_id[$key]);
                    $ps->update(['title'=>$title[$key]]);
                    $ps->update(['description'=>$spec_des[$key]]);
                }
            }

            Toastr::success('Product updated successfully.');

            return redirect()->route('products.index');
        }elseif (!is_null($request->NewTitle[0]) && !is_null($request->NewDescription[0])) {
            $request->validate([
                'name' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'addon' => 'required',
                'highlight_information' => 'required',
                'code' => 'required',
                'price' => 'required',
                'min_order' => 'required',
                'max_order' => 'required',
                'unit_value' => 'required',
                'unit' => 'required',
                'keyword' => 'required',
                'description' => 'required',
            ]);

            if ($request->hasfile('image')) {
                $profile = $request->file('image');
                $upload_path =public_path().'/files/';
                $name = $request->name.time().'.'.$profile->getClientOriginalExtension();
                $profile->move($upload_path,$name);
                $att = '/files/'.$name;
            }else{
                $att= request('old_att');
            }

            $product = Product::findOrFail($id);

            $product->update($request->all());

            if (!is_null($request->image)) {
                $file_old = public_path() . $product->attachment;
                unlink($file_old);

                $product->update(['image'=>$att]);
            }else{
                $product->update(['image'=>$att]);
            }
            
            $spec_id=$request->spec_id;
            $title=$request->title;
            $spec_des=$request->spec_des;

                foreach ($title as $key => $value) {
                        // dd($Sno[$key]);
                    if ($value) {
                        $ps=ProductSpecification::where('id',$spec_id[$key]);
                    $ps->update(['title'=>$title[$key]]);
                    $ps->update(['description'=>$spec_des[$key]]);
                }
            }

            $i = 0;
            $NewTitle=$request->NewTitle;
            $NewDescription=$request->NewDescription;
            // dd($NewDescription);
                    foreach ($NewTitle as $value) {
                        if ($value) {

                            // dd($Price[$i]);
                        ProductSpecification::create([
                            "product_id"=>$product->id,
                            'title' => $NewTitle[$i],
                            'description' => $NewDescription[$i],
                        ]);

                        $i++;
                    }
                }

            Toastr::success('Product updated successfully.');

            return redirect()->route('products.index');
        }else{
            Toastr::warning('New title or description cannot be empty.');

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (!is_null($product->image) && $product->image != '') {
            $file = public_path() . $product->image;
            unlink($file);
        }

        $product->delete();
        
        Toastr::error('Product deleted successfully.');
        return redirect()->route('products.index');
    }
}
