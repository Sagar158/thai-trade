<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $title = 'Customers';
    public function index()
    {
        $this->authorization();
        $title = $this->title;
        return view('customers.index',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = $this->title;
        $customer = new Customers;
        return view('customers.edit',compact('title','customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'MAITOU' => 'required|string',
            'CS' => 'nullable|string',
            // 'DID' => 'nullable|string',
            'address' => 'nullable|string',
            'sub_district' => 'nullable|string',
            'district' => 'nullable|string',
            'state' => 'nullable|string',
            'post_code' => 'string|nullable',
            'telephone1' => 'string|nullable',
            'telephone2' => 'string|nullable',
            'telephone3' => 'string|nullable',
            'Preferred_WULIU' => 'string|nullable',
            'GOOGLE_MAP' => 'string|nullable',

        ]);

        $customer = new Customers;
        $customer->name = $validatedData['name'];
        $customer->MAITOU = $validatedData['MAITOU'];
        $customer->CS = $validatedData['CS'];
        // $customer->DID = $validatedData['DID'];
        $customer->address = $validatedData['address'];
        $customer->sub_district = $validatedData['sub_district'];
        $customer->district = $validatedData['district'];
        $customer->state = $validatedData['state'];
        $customer->district = $validatedData['district'];
        $customer->post_code = $validatedData['post_code'];
        $customer->telephone1 = $validatedData['telephone1'];
        $customer->telephone2 = $validatedData['telephone2'];
        // $customer->telephone3 = $validatedData['telephone3'];
        $customer->Preferred_WULIU = $validatedData['Preferred_WULIU'];
        $customer->GOOGLE_MAP = $validatedData['GOOGLE_MAP'];
        $customer->save();

        return redirect()->route('customers.index')->with('success','User created Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $customerId)
    {
        $title = $this->title;
        $customer = Customers::findOrFail($customerId);
        return view('customers.edit',compact('title','customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $customerId)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'MAITOU' => 'required|string',
            'CS' => 'nullable|string',
            // 'DID' => 'nullable|string',
            'address' => 'nullable|string',
            'sub_district' => 'nullable|string',
            'district' => 'nullable|string',
            'state' => 'nullable|string',
            'post_code' => 'string|nullable',
            'telephone1' => 'string|nullable',
            'telephone2' => 'string|nullable',
            'telephone3' => 'string|nullable',
            'Preferred_WULIU' => 'string|nullable',
            'GOOGLE_MAP' => 'string|nullable',
        ]);


        $customer = Customers::findOrFail($customerId);
        $customer->name = $validatedData['name'];
        $customer->MAITOU = $validatedData['MAITOU'];
        $customer->CS = $validatedData['CS'];
        // $customer->DID = $validatedData['DID'];
        $customer->address = $validatedData['address'];
        $customer->sub_district = $validatedData['sub_district'];
        $customer->district = $validatedData['district'];
        $customer->state = $validatedData['state'];
        $customer->district = $validatedData['district'];
        $customer->post_code = $validatedData['post_code'];
        $customer->telephone1 = $validatedData['telephone1'];
        $customer->telephone2 = $validatedData['telephone2'];
        // $customer->telephone3 = $validatedData['telephone3'];
        $customer->Preferred_WULIU = $validatedData['Preferred_WULIU'];
        $customer->GOOGLE_MAP = $validatedData['GOOGLE_MAP'];
        $customer->save();
        return redirect()->route('customers.index')->with('success','Customer updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId)
    {
        $record = Customers::destroy($userId);
        return response()->json(['success' => $record]);
    }

    public function getCustomersData()
    {
        $query = Customers::query();

        return DataTables::of($query)
            ->editColumn('GOOGLE_MAP', function($customer){
                if(isset($customer->GOOGLE_MAP))
                    return '<a href="'.$customer->GOOGLE_MAP.'" target="_blank">Link</a>';
                else
                    return  '';
            })
            ->addColumn('action', function ($customer) {
                return '
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                    <a class="dropdown-item" href="'.route('customers.edit', $customer->id).'">Edit</a>
                                    <a class="dropdown-item delete-record" href="#" data-route="'.route('customers.destroy', $customer->id).'" data-id="'.$customer->id.'">Delete</a>
                                </div>
                            </div>
                        ';
            })
            ->rawColumns(['action','GOOGLE_MAP'])
            ->make(true);
    }
}
