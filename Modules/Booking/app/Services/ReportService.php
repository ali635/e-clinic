<?php

namespace Modules\Booking\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Booking\Models\Visit;
use Modules\Patient\Models\Patient;

class ReportService
{
    /**
     * Get patient type statistics (New vs Old)
     * New = 1 visit, Old = 2+ visits
     */
    public function getPatientTypeStats($startDate = null, $endDate = null)
    {
        $query = Patient::query()
            ->withCount([
                'visits' => function ($q) use ($startDate, $endDate) {
                    if ($startDate && $endDate) {
                        $q->whereBetween('created_at', [$startDate, $endDate]);
                    }
                }
            ]);

        if ($startDate && $endDate) {
            $query->whereHas('visits', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }

        $patients = $query->get();

        $newPatients = $patients->where('visits_count', 1)->count();
        $oldPatients = $patients->where('visits_count', '>', 1)->count();

        return [
            'new' => $newPatients,
            'old' => $oldPatients,
            'total' => $newPatients + $oldPatients,
        ];
    }

    /**
     * Get visits over time grouped by period
     */
    public function getVisitsOverTime($startDate, $endDate, $groupBy = 'day')
    {
        $query = Visit::whereBetween('created_at', [$startDate, $endDate]);

        switch ($groupBy) {
            case 'day':
                $data = $query->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                break;

            case 'week':
                $data = $query->select(
                    DB::raw('YEARWEEK(created_at) as week'),
                    DB::raw('COUNT(*) as count')
                )
                    ->groupBy('week')
                    ->orderBy('week')
                    ->get();
                break;

            case 'month':
                $data = $query->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('COUNT(*) as count')
                )
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
                break;

            case 'year':
                $data = $query->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('COUNT(*) as count')
                )
                    ->groupBy('year')
                    ->orderBy('year')
                    ->get();
                break;

            default:
                $data = collect();
        }

        return $data;
    }

    /**
     * Get patients grouped by city
     */
    public function getPatientsByCity($startDate = null, $endDate = null, $limit = 10)
    {
        $query = Patient::with('city')
            ->select('city_id', DB::raw('COUNT(*) as count'))
            ->groupBy('city_id');

        if ($startDate && $endDate) {
            $query->whereHas('visits', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }

        return $query->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'city' => $item->city->name ?? 'Unknown',
                    'count' => $item->count,
                ];
            });
    }

    /**
     * Get patients grouped by referral source
     */
    public function getPatientsByReferral($startDate = null, $endDate = null)
    {
        $query = Patient::with('referral')
            ->select('referral_id', DB::raw('COUNT(*) as count'))
            ->groupBy('referral_id');

        if ($startDate && $endDate) {
            $query->whereHas('visits', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }

        return $query->orderByDesc('count')
            ->get()
            ->map(function ($item) {
                return [
                    'referral' => $item->referral->name ?? 'Unknown',
                    'count' => $item->count,
                ];
            });
    }

    /**
     * Get diagnosis distribution
     */
    public function getDiagnosisDistribution($startDate = null, $endDate = null, $limit = 10)
    {
        $query = Visit::whereNotNull('diagnosis');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $visits = $query->get();
        $diagnosisCount = [];

        foreach ($visits as $visit) {
            if (is_array($visit->diagnosis)) {
                foreach ($visit->diagnosis as $diagnosis) {
                    if (!isset($diagnosisCount[$diagnosis])) {
                        $diagnosisCount[$diagnosis] = 0;
                    }
                    $diagnosisCount[$diagnosis]++;
                }
            }
        }

        arsort($diagnosisCount);
        $diagnosisCount = array_slice($diagnosisCount, 0, $limit, true);

        return collect($diagnosisCount)->map(function ($count, $diagnosis) {
            return [
                'diagnosis' => $diagnosis,
                'count' => $count,
            ];
        })->values();
    }

    /**
     * Get detailed patient report data
     */
    public function getPatientReportData($filters = [])
    {
        $query = Patient::with([
            'city',
            'referral',
            'visits' => function ($q) use ($filters) {
                if (isset($filters['start_date']) && isset($filters['end_date'])) {
                    $q->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
                }
                $q->orderBy('created_at', 'desc');
            }
        ]);

        // Apply date filter
        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereHas('visits', function ($q) use ($filters) {
                $q->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
            });
        }

        // Apply city filter
        if (isset($filters['city_id']) && $filters['city_id']) {
            $query->where('city_id', $filters['city_id']);
        }

        // Apply referral filter
        if (isset($filters['referral_id']) && $filters['referral_id']) {
            $query->where('referral_id', $filters['referral_id']);
        }

        $patients = $query->get();

        return $patients->map(function ($patient) use ($filters) {
            $visitsCount = $patient->visits->count();
            $latestVisit = $patient->visits->first();

            return [
                'id' => $patient->id,
                'name' => $patient->name,
                'patient_type' => $visitsCount === 1 ? 'New' : 'Old',
                'city' => $patient->city->name ?? 'N/A',
                'referral_source' => $patient->referral->name ?? 'N/A',
                'visits_count' => $visitsCount,
                'latest_diagnosis' => $latestVisit && is_array($latestVisit->diagnosis)
                    ? implode(', ', $latestVisit->diagnosis)
                    : 'N/A',
                'last_visit_date' => $latestVisit ? $latestVisit->created_at->format('Y-m-d') : 'N/A',
            ];
        });
    }

    /**
     * Determine time grouping based on date range
     */
    public function determineTimeGrouping($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $diffInDays = $start->diffInDays($end);

        if ($diffInDays <= 7) {
            return 'day';
        } elseif ($diffInDays <= 60) {
            return 'week';
        } elseif ($diffInDays <= 365) {
            return 'month';
        } else {
            return 'year';
        }
    }
}
