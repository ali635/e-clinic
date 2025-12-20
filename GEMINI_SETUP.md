# Gemini AI Integration - Setup Instructions

## Step 1: Get Your Gemini API Key

1. Go to [Google AI Studio](https://aistudio.google.com)
2. Sign in with your Google account
3. Click "Get API Key" in the left sidebar
4. Create a new API key or use an existing one
5. Copy the API key

## Step 2: Install the Package

The `google-gemini-php/laravel` package should already be installed. If not, run:

```bash
composer require google-gemini-php/laravel
```

Then publish the configuration:

```bash
php artisan gemini:install
```

## Step 3: Configure Your Environment

1. Add your API key to the `.env` file:

```env
GEMINI_API_KEY=your_api_key_here
GEMINI_MODEL=gemini-2.0-flash-exp
GEMINI_REQUEST_TIMEOUT=30
```

2. Clear the configuration cache:

```bash
php artisan config:clear
```

## Step 4: How It Works

When a visit's status is changed to "completed":

1. The system automatically collects all visit data including:

    - Patient information (name, age, gender)
    - Vital signs (blood pressure, pulse rate)
    - Anthropometric measurements (weight, height, BMI)
    - Chief complaint
    - Notes
    - Past medical history
    - Diagnosis
    - Doctor description and treatment notes
    - Prescribed medicines
    - Laboratory tests and imaging results

2. This data is sent to Gemini AI for analysis

3. The AI generates a comprehensive medical summary including:

    - Visit summary
    - Key clinical findings
    - Analysis of vital signs
    - Treatment plan assessment
    - Recommendations

4. The result is stored in the `result_ai` column of the visit record

## Step 5: Testing

1. Navigate to a visit in the admin panel
2. Fill in the visit details
3. Change the status to "completed" and save
4. Check the `result_ai` field in the database to see the AI-generated analysis
5. Review logs in `storage/logs/laravel.log` for detailed information

## Important Notes

-   The AI analysis only runs once per visit (when first marked as completed)
-   If an error occurs, it's logged but won't prevent the form from saving
-   API calls may take 2-5 seconds depending on data size
-   Check Google AI pricing for usage costs

## Troubleshooting

**Issue**: No AI result generated

-   Check that `GEMINI_API_KEY` is set in `.env`
-   Verify the API key is valid
-   Check `storage/logs/laravel.log` for errors

**Issue**: Timeout errors

-   Increase `GEMINI_REQUEST_TIMEOUT` in `.env`
-   Check your internet connection

**Issue**: Invalid API response

-   Verify you're using a supported model (gemini-2.0-flash-exp recommended)
-   Check API quota limits in Google AI Studio
