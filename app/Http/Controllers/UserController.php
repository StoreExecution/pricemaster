<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return User::with('role')->latest()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'unique:users,email', 'email', 'max:255',],
            'password' => ['required', 'string', 'min:8',],
            'role' => ['required', "exists:roles,id"]

        ]);
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role_id = $data['role'];
        $user->password = Hash::make($data['password']);

        $user->save();
        return redirect("/users");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'unique:users,email,' . $user->id, 'email', 'max:255',],
            'password' => ['sometimes', 'nullable', 'string', 'min:8',],
            'role' => ['required', "exists:roles,id"]

        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role_id = $data['role'];
        if (isset($data["password"]) && $data["password"] != '')
            $user->password = Hash::make($data['password']);

        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function count()
    {
        return User::all()->count();
    }
}
