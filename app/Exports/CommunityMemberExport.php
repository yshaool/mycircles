<?php

namespace App\Exports;

use App\CommunityMember;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class CommunityMemberExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct(int $community_id)
    {
        $this->community_id = $community_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return CommunityMember::select('name','email','phone')->where('community_id',$this->community_id);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
        ];
    }
}
