<?php

namespace App\Exports;

use App\Models\ParticipantLPS;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ParticipantLPSExport implements FromCollection,WithHeadings
{
    private $participantType;

    public function __construct(string $participantType)
    {
        $this->participantType = $participantType;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->participantType === 'CBPL') {
            return collect(ParticipantLPS::getCbplParticipants());
        } elseif ($this->participantType === 'LPS') {
            return collect(ParticipantLPS::getAwarenessParticipants());
        }
        return collect([]);
        // return ParticipantLPS::all();
        // return collect(ParticipantLPS::getAwarenessParticipants());
    }
    public function headings():array
    {
        if ($this->participantType === 'CBPL') {
            return [
                'Name',
                'Father',
                'Gender',
                'IdentityCode',
                'Identity',
                'Contact',
                'District',
                'Camp',
                'Date',
                'Conduct',
                'ActivityID'
            ];
        } elseif ($this->participantType === 'LPS') {
            return [
                'Name',
                'Father',
                'Gender',
                'IdentityCode',
                'Identity',
                'Contact',
                'District',
                'Camp',
                'Date',
                'ActivityID'
            ];
        }

        // Default headings if the type is not recognized
        return [];

    } 
}
