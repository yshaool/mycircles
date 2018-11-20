<?php

namespace App\Imports;

use App\CommunityMember;
use Maatwebsite\Excel\Concerns\ToModel;

class CommunityMemberImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CommunityMember([
            //
        ]);
    }
}
