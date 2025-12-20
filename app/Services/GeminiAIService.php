<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;
use Modules\Booking\Models\Visit;
use Illuminate\Support\Facades\Log;
use Exception;

class GeminiAIService
{
    /**
     * Analyze a visit using Gemini AI
     * 
     * @param Visit $visit
     * @return string|null
     */
    public function analyzeVisit(Visit $visit): ?string
    {
        try {
            $prompt = $this->formatVisitPrompt($visit);

            Log::info('Sending visit data to Gemini AI', [
                'visit_id' => $visit->id,
                'patient_id' => $visit->patient_id
            ]);

            // Send request to Gemini API
            $result = Gemini::generativeModel('gemini-2.5-flash-lite')
                ->generateContent($prompt);

            $response = $result->text();

            Log::info('Received response from Gemini AI', [
                'visit_id' => $visit->id,
                'response_length' => strlen($response)
            ]);

            return $this->handleApiResponse($response);

        } catch (Exception $e) {
            Log::error('Gemini AI Analysis Failed', [
                'visit_id' => $visit->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return null;
        }
    }

    /**
     * Format visit data as AI prompt
     * 
     * @param Visit $visit
     * @return string
     */
    protected function formatVisitPrompt(Visit $visit): string
    {
        $visitData = $visit->getVisitDataForAI();

        $prompt = "You are a medical AI assistant. Please analyze the following patient visit information and provide a comprehensive medical summary and insights. Include any potential concerns, treatment effectiveness observations, or recommendations for follow-up.\n\n";
        $prompt .= "VISIT INFORMATION:\n";
        $prompt .= "==================\n\n";
        $prompt .= $visitData;
        $prompt .= "\n\nPlease provide:\n";
        $prompt .= setting("ai_assistant_prompt");
        return $prompt;
    }

    /**
     * Process and clean AI response
     * 
     * @param string $response
     * @return string
     */
    protected function handleApiResponse(string $response): string
    {
        // Clean up the response if needed
        $response = trim($response);

        // You can add additional processing here
        // For example, removing markdown formatting, extracting specific sections, etc.

        return $response;
    }
}
