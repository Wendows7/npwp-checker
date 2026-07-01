<?php

namespace App\Services;

use App\Models\Unity;

class UnityService
{
protected $unity;
    public function __construct(Unity $unity)
    {
        $this->unity = $unity;
    }

    public function getAll()
    {
        return $this->unity->latest();
    }

    public function addUnity($validateData)
    {
        return $this->unity->create($validateData);
    }

    public function updateUnity($validateData, $id)
    {
        return $this->unity->where('id', $id)->update($validateData);
    }
}
