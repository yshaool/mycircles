<?php

namespace App\Exports;

use App\CommunityMember;
use Maatwebsite\Excel\Concerns\FromCollection;

class CommunityMemberExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CommunityMember::all();
    }
}
