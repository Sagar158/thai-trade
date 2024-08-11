<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Helper;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HodDepartments;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $title = 'Users';
    public function index()
    {
        $this->authorization();
        $title = $this->title;
        return view('users.index',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = $this->title;
        $user = new User;
        return view('users.edit',compact('title','user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|max:255|email|unique:users,email',
            'name' => 'required|string',
            'password' => 'required|string|min:6|max:255',
        ]);

        $user = new User;
        $user->email = $validatedData['email'];
        $user->name = $validatedData['name'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        return redirect()->route('users.index')->with('success','User created Successfully');

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
    public function edit(Request $request, $userId)
    {
        $title = $this->title;
        $user = User::findOrFail($userId);
        return view('users.edit',compact('title','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|unique:users,email,' . $userId,
            'name' => 'required|string',
            'password' => 'max:255',
        ]);


        $user = User::findOrFail($userId);
        $user->email = $validatedData['email'];
        $user->name = $validatedData['name'];

        $user->save();
        if(!empty($request->password))
        {
            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();
        }
        return redirect()->route('users.index')->with('success','User updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId)
    {
        $record = User::destroy($userId);
        return response()->json(['success' => $record]);
    }

    public function getUserData()
    {
        $query = User::query();

        return DataTables::of($query)
            ->addColumn('action', function ($user) {
                return '
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                    <a class="dropdown-item" href="'.route('users.edit', $user->id).'">Edit</a>
                                    <a class="dropdown-item delete-record" href="#" data-route="'.route('users.destroy', $user->id).'" data-id="'.$user->id.'">Delete</a>
                                </div>
                            </div>
                        ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}
