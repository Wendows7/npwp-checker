<?php

namespace App\Services;

use App\Models\Suspect;
use App\Models\Cases;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SuspectService
{
    protected $suspect;

    public function __construct(Suspect $suspect)
    {
        $this->suspect = $suspect;
    }

    public function getByNik($nik)
    {
        return $this->suspect->where('nik', 'LIKE', '%' . $nik . '%')->with('cases')->get();
    }

    public function getAll()
    {
        return $this->suspect->with('cases')->latest();
    }

    public function getAllWithCases()
    {
        return $this->suspect->with('cases')->get();
    }

    /**
     * Create new suspect with optional case data
     * @param array $data - Suspect data
     * @param $photoFile - Photo file from request
     * @param array|null $casesData - Array of cases data (optional)
     * @return Suspect
     */
    public function createWithCase(array $data, $photoFile = null, ?array $casesData = null)
    {
        DB::beginTransaction();

        try {
            // Handle photo upload
            if ($photoFile) {
                $data['photo'] = $photoFile->store('suspects', 'public');
            }

            // Create suspect
            $suspect = $this->suspect->create($data);

            // Create multiple cases if cases data provided
            if ($casesData && is_array($casesData)) {
                foreach ($casesData as $caseData) {
                    // Only create case if it has at least number or name
                    if (!empty($caseData['number']) || !empty($caseData['name'])) {
                        $suspect->cases()->create([
                            'number' => $caseData['number'] ?? null,
                            'name' => $caseData['name'] ?? null,
                            'chapter' => $caseData['chapter'] ?? null,
                            'place' => $caseData['place'] ?? null,
                            'datetime' => $caseData['datetime'] ?? null,
                            'division' => $caseData['division'] ?? null,
                            'decision' => $caseData['decision'] ?? null,
                            'description' => $caseData['description'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return $suspect;
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded photo if exists
            if (isset($data['photo']) && Storage::disk('public')->exists($data['photo'])) {
                Storage::disk('public')->delete($data['photo']);
            }

            throw $e;
        }
    }

    /**
     * Update suspect with optional case data
     * @param Suspect $suspect
     * @param array $data - Suspect data
     * @param $photoFile - Photo file from request
     * @param array|null $casesData - Array of cases data (optional)
     * @return Suspect
     */
    public function updateWithCase(Suspect $suspect, array $data, $photoFile = null, ?array $casesData = null)
    {
        DB::beginTransaction();

        try {
            $oldPhoto = $suspect->photo;

            // Handle photo upload
            if ($photoFile) {
                // Delete old photo if exists
                if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
                    Storage::disk('public')->delete($oldPhoto);
                }

                $data['photo'] = $photoFile->store('suspects', 'public');
            }

            // Update suspect
            $suspect->update($data);

            // Handle multiple cases update or creation
            if ($casesData && is_array($casesData)) {
                // Get all existing case IDs from submitted data
                $submittedCaseIds = [];

                foreach ($casesData as $caseData) {
                    // Only process case if it has at least number or name
                    if (!empty($caseData['number']) || !empty($caseData['name'])) {
                        $casePayload = [
                            'number' => $caseData['number'] ?? null,
                            'name' => $caseData['name'] ?? null,
                            'chapter' => $caseData['chapter'] ?? null,
                            'place' => $caseData['place'] ?? null,
                            'datetime' => $caseData['datetime'] ?? null,
                            'division' => $caseData['division'] ?? null,
                            'decision' => $caseData['decision'] ?? null,
                            'description' => $caseData['description'] ?? null,
                        ];

                        if (!empty($caseData['id'])) {
                            // Update existing case
                            $case = $suspect->cases()->find($caseData['id']);
                            if ($case) {
                                $case->update($casePayload);
                                $submittedCaseIds[] = $caseData['id'];
                            }
                        } else {
                            // Create new case
                            $newCase = $suspect->cases()->create($casePayload);
                            $submittedCaseIds[] = $newCase->id;
                        }
                    }
                }

                // Delete cases that were removed from the form
                if (!empty($submittedCaseIds)) {
                    $suspect->cases()->whereNotIn('id', $submittedCaseIds)->delete();
                }
            }

            DB::commit();
            return $suspect->fresh(['cases']);
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete new uploaded photo if exists
            if (isset($data['photo']) && Storage::disk('public')->exists($data['photo'])) {
                Storage::disk('public')->delete($data['photo']);
            }

            throw $e;
        }
    }

    /**
     * Delete suspect and its photo
     * @param Suspect $suspect
     * @return bool
     */
    public function deleteSuspect(Suspect $suspect)
    {
        DB::beginTransaction();

        try {
            // Delete photo if exists
            if ($suspect->photo && Storage::disk('public')->exists($suspect->photo)) {
                Storage::disk('public')->delete($suspect->photo);
            }

            // Delete suspect (cases will be cascade deleted if foreign key is set with onDelete cascade)
            $result = $suspect->delete();

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Import suspects from excel data
     * @param $file
     * @return void
     */
    public function importFromExcel($file)
    {
        $import = new \App\Imports\SuspectImport();
        \Maatwebsite\Excel\Facades\Excel::import($import, $file);
    }
}
