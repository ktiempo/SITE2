<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Models\User;

Class UserController extends Controller {

    use ApiResponser;
    private $request;

    public function __construct(Request $request){
    $this->request = $request;
    }

    //Get Users
    public function getUsers(){
    $users = User::all();
    return response()->json($users, 200);
    }

    //Index
    public function index()
    {
    $users = User::all();
    return $this->successResponse($users);
    }

    // Add User
    public function add(Request $request ){
        $rules = [
        'username' => 'required|max:20',
        'password' => 'required|max:20',
        ];
        $this->validate($request,$rules);
        $user = User::create($request->all());
        
        return $this->successResponse($user,
        Response::HTTP_CREATED);
        }

    //Show ID
    public function show($id)
    {
    $user = User::findOrFail($id);
    return $this->successResponse($user);
    }

    //Update
    public function update(Request $request,$id){
        $rules = [
        'username' => 'max:20',
        'password' => 'max:20',
        ];
        $this->validate($request, $rules);
        $user = User::findOrFail($id);
        $user->fill($request->all());

        // if no changes happen
        if ($user->isClean()) {
        return $this->errorResponse('At least one value must
        change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->save();
        return $this->successResponse($user);
        }

        // Delete
        public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return $this->successResponse($user);
    }
}   