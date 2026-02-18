<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\AuthService;

class UserController extends Controller
{
    protected $userService;
    protected $authService;

    public function __construct(UserService $userService, AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    public function index()
    {
        $users = $this->userService->getAll()->get();
        $selisihMenit = $this->authService->showMinute();


        return view('user.index', compact('users','selisihMenit'));
    }

    public function deleteById(Request $request)
    {
        $this->userService->deleteById($request);

        return redirect()->back()->with('success', 'User has been deleted!');
    }

    public function create(Request $request)
    {
        $checkDuplicateUser = $this->userService->checkDuplicateUser($request->email);

        if ($checkDuplicateUser) {
            return redirect()->back()->with('error', 'Email already exists!');
        }
        $validateData = $request->validate([
            'name' => 'required|min:5|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5',
            'role' => 'required',
            'is_active' => 'required',
        ]);

        $validateData['password'] = bcrypt($validateData['password']);

        $this->userService->addUser($validateData);

        return redirect()->back()->with('success', 'User has been created!');

    }

    public function update(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|min:5|max:255',
                'email' => 'required|email:dns',
                'role' => 'required',
                'is_active' => 'required',
            ]);

        if($request->password == ''){
            $validatedData['password'] = $this->userService->getUserById($request->id)->password;
        }else{
            $validatedData['password'] = bcrypt($request->password);
        }

        $this->userService->editById($request->id, $validatedData);

        return redirect()->back()->with('success', 'Success Update Data');
    }
}
