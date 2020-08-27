<?php

namespace Xmen\StarterKit\Controllers\Admin;

use App\Http\Controllers\Controller;
use Xmen\StarterKit\Requests\UserSaveRequest;
use App\User;
use function Xmen\StarterKit\Helpers\logAdmin;

class UserController extends Controller {

    private $name = 'User';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $users = User::orderBy('name')->paginate(20);
        return view('admin.user.userList', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        return view('admin.user.userForm');
    }

    public function createOrUpdate(User $user, UserSaveRequest $req) {
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        if (trim($req->input('password')) != '') {
            $user->password = bcrypt($req->input('password'));
        }
        $user->mobile = $req->input('mobile');
        $user->syncRoles($req->input('role'));
        $user->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserSaveRequest $request) {
        //
        $user = new User();
        $user = $this->createOrUpdate($user, $request);
        logAdmin(__METHOD__,User::class,$user->id);
        return redirect()->route('admin.user.all')->with(['message'=> $user->name .' '.__($this->name)  .' '. __(' created') ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    public function edit(User $user) {
        //
        return view('admin.user.userForm', compact('user'));
    }

    public function update(UserSaveRequest $request, User $user) {
        //
        $this->createOrUpdate($user, $request);
        logAdmin(__METHOD__,User::class,$user->id);
        return redirect()->route('admin.user.all')->with(['message'=> $user->name .' '.__($this->name)  .' '. __(' edited') ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        //
        $user->delete();
        logAdmin(__METHOD__,User::class,$user->id);
        return redirect()->back()->with(['message'=> $user->name .' '.__($this->name)  .' '. __(' deleted') ]);
    }
}
