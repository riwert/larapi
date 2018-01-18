<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get user list by limit
        $users = User::paginate($this->limit);

        // Return collection of users as a resource
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id = null, Request $request)
    {
        // Create new or update existing user
        $user = ($request->isMethod('put')) ? User::findOrFail($id) : new User();

        if ($request->input('name')) {
            $user->name = $request->input('name');
        }
        if ($request->input('email')) {
            $user->email = $request->input('email');
        }
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($user->save()) {
            return new UserResource($user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get single user
        $user = User::findOrFail($id);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get single article or throw 404 error
        $user = User::findOrFail($id);

        // Delete user and return deleted resource
        if ($user->delete()) {
            return new UserResource($user);
        }
    }
}
