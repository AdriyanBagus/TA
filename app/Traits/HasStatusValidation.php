<?php

namespace App\Traits;

use Illuminate\Validation\Rule;

trait HasStatusValidation
{
    public function validateStatusRequest($request)
    {
        $request->validate([
            'status' => ['required', Rule::in(['Diproses', 'Disetujui', 'Ditolak'])],
        ]);
    }

    public function updateStatus($model, $status, $catatan = null)
    {
        $model->update([
            'status' => $status,
            'catatan' => $status === 'ditolak' ? $catatan : null,
        ]);
    }
}
