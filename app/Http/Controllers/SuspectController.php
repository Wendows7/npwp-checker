<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Services\SuspectService;
use App\Models\Suspect;
use App\Models\Cases;
use Illuminate\Support\Facades\Storage;

class SuspectController extends Controller
{

    protected $suspectService;
    protected $authService;
    public function __construct(SuspectService $suspectService, AuthService $authService)
    {
        $this->authService = $authService;
        $this->suspectService = $suspectService;
    }

    public function index()
    {
        $selisihMenit = $this->authService->showMinute();
        $suspects = null;  // Kosongkan data di awal, hanya muncul saat search

        return view('suspect.search', compact('suspects', 'selisihMenit'));
    }

    public function search(Request $request)
    {
        $selisihMenit = $this->authService->showMinute();
        $suspects = $this->suspectService->getByNik($request->query('slug'));

        if ($suspects->isEmpty()) {
            return redirect()->route('suspect')->with('error', 'Data tidak ditemukan');
        }

        alert()->success('Success', 'Data Ditemukan');

        return view('suspect.search', compact('suspects','selisihMenit'));
    }

    public function getAll()
    {
        $suspects = $this->suspectService->getAllWithCases();
        $selisihMenit = $this->authService->showMinute();

        return view('suspect.index', compact('suspects', 'selisihMenit'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('excel_file');
            $this->suspectService->importFromExcel($file);

            alert()->success('Success', 'Data berhasil diimport');
            return redirect()->route('suspect');
        } catch (\Exception $e) {
            alert()->error('Error', 'Gagal mengimport data: ' . $e->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:suspects,nik',
            'name' => 'required|string',
            'gender' => 'required|string',
            'alias' => 'nullable|string',
            'place_of_birth' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'age' => 'nullable|integer',
            'religion' => 'nullable|string',
            'education' => 'nullable|string',
            'occupation' => 'nullable|string',
            'address' => 'nullable|string',
            'finger_code' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Case validation - now accepts array
            'cases' => 'nullable|array',
            'cases.*.number' => 'nullable|string',
            'cases.*.name' => 'nullable|string',
            'cases.*.chapter' => 'nullable|string',
            'cases.*.place' => 'nullable|string',
            'cases.*.datetime' => 'nullable|date',
            'cases.*.division' => 'nullable|string',
            'cases.*.decision' => 'nullable|string',
            'cases.*.description' => 'nullable|string',
            'cases.*.updated_by' => 'nullable|exists:users,id',
            'cases.*.evidence' => 'nullable|string',
        ]);

        try {
            // Prepare suspect data
            $suspectData = $request->only([
                'nik', 'name', 'alias', 'gender', 'place_of_birth',
                'date_of_birth', 'age', 'religion', 'education',
                'occupation', 'address', 'finger_code'
            ]);

            // Get cases data (already in array format)
            $casesData = $request->input('cases', []);

            // Create suspect with cases using service
            $photoFile = $request->hasFile('photo') ? $request->file('photo') : null;
            $this->suspectService->createWithCase($suspectData, $photoFile, $casesData);

            alert()->success('Success', 'Data tersangka berhasil ditambahkan');
            return redirect()->back();
        } catch (\Exception $e) {
            alert()->error('Error', 'Gagal menambahkan data: ' . $e->getMessage());
            return back();
        }
    }

    public function update(Request $request, Suspect $suspect)
    {

        $request->validate([
            'nik' => 'required|unique:suspects,nik,' . $suspect->id,
            'name' => 'required|string',
            'gender' => 'required|string',
            'alias' => 'nullable|string',
            'place_of_birth' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'age' => 'nullable|integer',
            'religion' => 'nullable|string',
            'education' => 'nullable|string',
            'occupation' => 'nullable|string',
            'address' => 'nullable|string',
            'finger_code' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Case validation - now accepts array
            'cases' => 'nullable|array',
            'cases.*.id' => 'nullable|exists:cases,id',
            'cases.*.number' => 'nullable|string',
            'cases.*.name' => 'nullable|string',
            'cases.*.chapter' => 'nullable|string',
            'cases.*.place' => 'nullable|string',
            'cases.*.datetime' => 'nullable|date',
            'cases.*.division' => 'nullable|string',
            'cases.*.decision' => 'nullable|string',
            'cases.*.description' => 'nullable|string',
            'cases.*.updated_by' => 'nullable|exists:users,id',
            'cases.*.evidence' => 'nullable|string',


        ]);

        try {
            // Prepare suspect data
            $suspectData = $request->only([
                'nik', 'name', 'alias', 'gender', 'place_of_birth',
                'date_of_birth', 'age', 'religion', 'education',
                'occupation', 'address', 'finger_code'
            ]);

            // Get cases data (already in array format)
            $casesData = $request->input('cases', []);

            // Update suspect with cases using service
            $photoFile = $request->hasFile('photo') ? $request->file('photo') : null;
            $this->suspectService->updateWithCase($suspect, $suspectData, $photoFile, $casesData);

            alert()->success('Success', 'Data tersangka berhasil diubah');
            return redirect()->back();
        } catch (\Exception $e) {
            alert()->error('Error', 'Gagal mengubah data: ' . $e->getMessage());
            return back();
        }
    }

    public function delete(Suspect $suspect)
    {
        try {
            $this->suspectService->deleteSuspect($suspect);

            alert()->success('Success', 'Data tersangka berhasil dihapus');
            return redirect()->route('suspect');
        } catch (\Exception $e) {
            alert()->error('Error', 'Gagal menghapus data: ' . $e->getMessage());
            return back();
        }
    }
}
