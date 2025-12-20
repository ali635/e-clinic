<?php

namespace Modules\Booking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Modules\Booking\Services\ReportService;

class PatientReportExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $reportService = new ReportService();
        $data = $reportService->getPatientReportData($this->filters);

        return $data->map(function ($item) {
            return [
                'name' => $item['name'],
                'patient_type' => $item['patient_type'],
                'city' => $item['city'],
                'referral_source' => $item['referral_source'],
                'visits_count' => $item['visits_count'],
                'latest_diagnosis' => $item['latest_diagnosis'],
                'last_visit_date' => $item['last_visit_date'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Patient Name',
            'Patient Type',
            'City',
            'Referral Source',
            'Total Visits',
            'Latest Diagnosis',
            'Last Visit Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0'],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Name
            'B' => 15, // Type
            'C' => 20, // City
            'D' => 20, // Referral
            'E' => 15, // Visits
            'F' => 40, // Diagnosis
            'G' => 18, // Last Visit
        ];
    }
}
