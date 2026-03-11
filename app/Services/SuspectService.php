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
        return $this->suspect->where('nik', 'LIKE', '%' . $nik . '%')->with('cases.user')->get();
    }

    public function getAll()
    {
        return $this->suspect->with('cases.user')->latest();
    }

    public function getAllWithCases()
    {
        return $this->suspect->with('cases.user')->get();
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
                foreach ($casesData as $index => $caseData) {
                    // Only create case if it has at least number or name
                    if (!empty($caseData['number']) || !empty($caseData['name'])) {
                        // Handle photo_evidence upload for case
                        $photoEvidencePath = null;
                        if (isset($caseData['photo_evidence']) && $caseData['photo_evidence']) {
                            $photoEvidencePath = $caseData['photo_evidence']->store('cases/evidence', 'public');
                        }

                        $suspect->cases()->create([
                            'number' => $caseData['number'] ?? null,
                            'name' => $caseData['name'] ?? null,
                            'chapter' => $caseData['chapter'] ?? null,
                            'place' => $caseData['place'] ?? null,
                            'datetime' => $caseData['datetime'] ?? null,
                            'division' => $caseData['division'] ?? null,
                            'decision' => $caseData['decision'] ?? null,
                            'description' => $caseData['description'] ?? null,
                            'updated_by' => $caseData['updated_by'] ?? null,
                            'evidence' => $caseData['evidence'] ?? null,
                            'photo_evidence' => $photoEvidencePath,
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
                        if (!empty($caseData['id'])) {
                            // Update existing case - only update updated_by if data changed
                            $case = $suspect->cases()->find($caseData['id']);
                            if ($case) {
                                // Check if any field has changed
                                $hasChanges = false;
                                $casePayload = [];

                                $fieldsToCheck = ['number', 'name', 'chapter', 'place', 'datetime', 'division', 'decision', 'description','evidence'];

                                foreach ($fieldsToCheck as $field) {
                                    $newValue = $caseData[$field] ?? null;
                                    if ($case->$field != $newValue) {
                                        $hasChanges = true;
                                        $casePayload[$field] = $newValue;
                                    }
                                }

                                // Handle photo_evidence upload for case
                                if (isset($caseData['photo_evidence']) && $caseData['photo_evidence']) {
                                    // Delete old photo evidence if exists
                                    if ($case->photo_evidence && Storage::disk('public')->exists($case->photo_evidence)) {
                                        Storage::disk('public')->delete($case->photo_evidence);
                                    }
                                    $casePayload['photo_evidence'] = $caseData['photo_evidence']->store('cases/evidence', 'public');
                                    $hasChanges = true;
                                }

                                // Only add updated_by if there are actual changes
                                if ($hasChanges && isset($caseData['updated_by'])) {
                                    $casePayload['updated_by'] = $caseData['updated_by'];
                                }

                                // Update only if there are changes
                                if (!empty($casePayload)) {
                                    $case->update($casePayload);
                                }

                                $submittedCaseIds[] = $caseData['id'];
                            }
                        } else {
                            // Create new case
                            $photoEvidencePath = null;
                            if (isset($caseData['photo_evidence']) && $caseData['photo_evidence']) {
                                $photoEvidencePath = $caseData['photo_evidence']->store('cases/evidence', 'public');
                            }

                            $casePayload = [
                                'number' => $caseData['number'] ?? null,
                                'name' => $caseData['name'] ?? null,
                                'chapter' => $caseData['chapter'] ?? null,
                                'place' => $caseData['place'] ?? null,
                                'datetime' => $caseData['datetime'] ?? null,
                                'division' => $caseData['division'] ?? null,
                                'decision' => $caseData['decision'] ?? null,
                                'description' => $caseData['description'] ?? null,
                                'updated_by' => $caseData['updated_by'] ?? null,
                                'evidence' => $caseData['evidence'] ?? null,
                                'photo_evidence' => $photoEvidencePath,
                            ];

                            $newCase = $suspect->cases()->create($casePayload);
                            $submittedCaseIds[] = $newCase->id;
                        }
                    }
                }

                // Delete cases that were removed from the form
                if (!empty($submittedCaseIds)) {
                    // Get cases to be deleted to clean up their photos
                    $casesToDelete = $suspect->cases()->whereNotIn('id', $submittedCaseIds)->get();

                    // Delete photo_evidence files
                    foreach ($casesToDelete as $caseToDelete) {
                        if ($caseToDelete->photo_evidence && Storage::disk('public')->exists($caseToDelete->photo_evidence)) {
                            Storage::disk('public')->delete($caseToDelete->photo_evidence);
                        }
                    }

                    // Delete the cases
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
            // Delete suspect photo if exists
            if ($suspect->photo && Storage::disk('public')->exists($suspect->photo)) {
                Storage::disk('public')->delete($suspect->photo);
            }

            // Delete all photo_evidence files from cases
            if ($suspect->cases && $suspect->cases->count() > 0) {
                foreach ($suspect->cases as $case) {
                    if ($case->photo_evidence && Storage::disk('public')->exists($case->photo_evidence)) {
                        Storage::disk('public')->delete($case->photo_evidence);
                    }
                }
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
