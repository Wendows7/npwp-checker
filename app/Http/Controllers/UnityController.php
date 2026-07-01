<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\UnityService;
use Illuminate\Http\Request;

class UnityController extends Controller
{

    protected $unityService;
    public function __construct(UnityService $unityService, AuthService $authService)
    {
        $this->unityService = $unityService;
        $this->authService = $authService;
    }
    public function index()
    {
        $selisihMenit = $this->authService->showMinute();

        $data = $this->unityService->getAll()->get();
        return view('unity.index', compact('data','selisihMenit'));
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|string",
        ]);

        $this->unityService->addUnity($validatedData);
        return redirect()->back()->with('success', 'Unity has been created!');
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|string",
        ]);

        $this->unityService->updateUnity( $validatedData,$request->id);
        return redirect()->back()->with('success', 'Unity has been updated!');
    }
}
