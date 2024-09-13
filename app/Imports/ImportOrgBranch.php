<?php

namespace App\Imports;

use Brian2694\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Org\Entities\OrgBranch;
use Illuminate\Support\Collection;

class ImportOrgBranch implements WithStartRow, WithHeadingRow, ToCollection
{

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function collection(Collection $rows)
    {

        $serial = OrgBranch::count();
        $rows = $rows->sortBy('name');

        foreach ($rows as $row) {
            $parent_id = 0;
            if (empty($row['name'])) {
                Toastr::error(trans('org.Group Name is required'), trans('common.Error'));

            }
            if (empty($row['code'])) {
                Toastr::error(trans('org.Group Code is required'), trans('common.Error'));

            }
            if (!empty($row['parent_code'])) {
                $parent = OrgBranch::where('code', $row['parent_code'])->first();
                if (!$parent) {
                    Toastr::error($row['parent_code'] . ' ' . trans('org.Is a invalid parent code'), trans('common.Error'));

                } else {
                    $parent_id = $parent->id;
                }
            }

            $check = OrgBranch::where('code', $row['code'])->first();
            if ($check) {
                Toastr::error($row['code'] . ' ' . trans('org.Is a already added'), trans('common.Error'));

            } else {
                OrgBranch::create([
                    'group' => $row['name'],
                    'code' => $row['code'],
                    'parent_id' => $parent_id,
                    'order' => $serial,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $serial++;
            }

        }
    }
}
