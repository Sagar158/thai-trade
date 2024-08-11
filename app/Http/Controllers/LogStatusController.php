<?php

namespace App\Http\Controllers;

use App\Models\LogStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LogStatusController extends Controller
{

    public $title = 'Log Status';
    public function index()
    {
        $this->authorization();
        $title = $this->title;
        return view('logStatus.index', compact('title'));
    }


    public function getLogStatusData()
    {
        $query = LogStatus::where('status', 1);

        return DataTables::of($query)
            ->addColumn('action', function ($logStatus) {
                return '
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                    <a class="dropdown-item" href="'.route('logStatus.edit', $logStatus->id).'">Edit</a>
                                    <a class="dropdown-item delete-record" href="#" data-route="'.route('logStatus.destroy', $logStatus->id).'" data-id="'.$logStatus->id.'">Delete</a>
                                </div>
                            </div>
                        ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $title = $this->title;
        $logStatus = new LogStatus();
        return view('logStatus.edit',compact('title','logStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'hours' => 'nullable',
        ]);

        $logStatus = new LogStatus();
        $logStatus->name = $validatedData['name'];
        $logStatus->description = $validatedData['description'];
        $logStatus->hours = $validatedData['hours'];
        $logStatus->save();

        return redirect()->route('logStatus.index')->with('success','Log Status created Successfully');

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
    public function edit(Request $request, $logStatus)
    {
        $title = $this->title;
        $logStatus = LogStatus::findOrFail($logStatus);
        return view('logStatus.edit',compact('title','logStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $logStatusId)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required|string',
            'hours' => 'nullable',
        ]);

        $logStatus = LogStatus::findOrFail($logStatusId);
        $logStatus->name = $validatedData['name'];
        $logStatus->description = $validatedData['description'];
        $logStatus->hours = $validatedData['hours'];
        $logStatus->save();
        return redirect()->route('logStatus.index')->with('success','Log Status updated Successfully');
    }

    public function destroy($logStatusId)
    {
        $record = LogStatus::destroy($logStatusId);
        return response()->json(['success' => $record]);
    }
}
