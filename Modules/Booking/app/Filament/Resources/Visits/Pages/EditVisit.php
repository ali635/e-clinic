<?php

namespace Modules\Booking\Filament\Resources\Visits\Pages;

use App\Services\GeminiAIService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Modules\Booking\Filament\Resources\Visits\VisitResource;
use Modules\Room\Filament\Pages\RoomView;

class EditVisit extends EditRecord
{
    protected static string $resource = VisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('goToRoom')
                ->label(__('Go to Room'))
                ->icon('heroicon-o-building-office-2')
                ->color('info')
                ->url(
                    fn() => $this->record->room_id
                    ? RoomView::getUrl(['roomId' => $this->record->room_id])
                    : null
                )
                ->visible(fn() => $this->record->room_id !== null),
            DeleteAction::make(),
        ];
    }

    protected function beforeSave()
    {
        // Check if visit status is completed and trigger AI analysis
        if (isset($this->record->status) && $this->record->status === 'complete') {
            try {
                // Get the full Visit record
                $visit = $this->record;

                // Only process if AI result hasn't been generated yet
                if (empty($visit->result_ai)) {
                    Log::info('Triggering Gemini AI analysis for completed visit', [
                        'visit_id' => $visit->id,
                        'patient_id' => $visit->patient_id
                    ]);

                    // Use the Gemini AI Service to analyze the visit
                    $geminiService = new GeminiAIService();
                    $aiResult = $geminiService->analyzeVisit($visit);

                    // Store the AI result if successfully generated
                    if ($aiResult) {
                        $this->record->result_ai = $aiResult;
                        Log::info('Gemini AI analysis completed and stored', [
                            'visit_id' => $visit->id
                        ]);
                    } else {
                        Log::warning('Gemini AI analysis returned empty result', [
                            'visit_id' => $visit->id
                        ]);
                    }
                } else {
                    Log::info('Skipping AI analysis - result already exists', [
                        'visit_id' => $visit->id
                    ]);
                }
            } catch (\Exception $e) {
                // Log error but don't block the form from loading
                Log::error('Failed to process Gemini AI analysis', [
                    'visit_id' => $this->record->id ?? null,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }
    }
}
