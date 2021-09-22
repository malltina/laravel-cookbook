<?php

namespace App\Http\Controllers\API\v1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        //        return DB::table('posts')->get();
        return User::all();
    }

    public function store(Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');


        $user= User::query()->create([
            'name'=>$name,
            'email'=>$email
        ]);
        return $user;
    }

    public function update(Request $request,int $userId)
    {
        $user=User::query()->findOrFail($userId);
        $name = $request->get('name');
        $email  = $request->get('email');
        $user->update([
            'name'=>$name,
            'email'=>$email
        ]);
        return 'user updated.';
    }

    public function show(int $userId)
    {

        $user=User::query()->findOrFail($userId,['name','email']);
        return $user;
    }

    public function destroy(int $userId)
    {
        User::findOrFail($userId)
            ->delete();
        return 'user has been deleted';
    }
}

