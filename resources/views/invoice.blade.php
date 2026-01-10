<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;600;700;900&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary-text: #000000;
            --secondary-text: #4b5563;
            --footer-bg: #111827;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: white;
            color: var(--primary-text);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            padding: 0;
        }

        @page {
            size: A5;
            margin: 0;
        }

        .container {
            width: 148mm;
            height: 210mm;
            margin: 0 auto;
            position: relative;
            padding: 30px 20px 80px 20px;
            /* Add background image - Fixed path */
            background-image: url('{{ asset('storage/' . setting_lang('prescription_logo')) }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Add overlay for better text readability */
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.85);
            z-index: 0;
            pointer-events: none;
        }

        /* Ensure all content is above the overlay */
        .container>* {
            position: relative;
            z-index: 1;
        }

        /* Header */
        .header-section {
            text-align: center;
            margin-bottom: 1.2rem;
        }

        .main-title {
            font-size: 28px;
            font-weight: 900;
            color: #000;
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .sub-title {
            font-size: 11px;
            font-weight: 600;
            color: var(--secondary-text);
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .header-divider {
            border-top: 1px solid #000;
            margin: 6px auto;
            width: 100%;
        }

        .credentials {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            text-align: center;
            color: #fff;
            background-color: #000;
            margin: 10px 0;
            /* Top and bottom spacing */
            letter-spacing: 0.5px;
            padding: 6px 0;
            display: flex;
            justify-content: center;
            gap: 90px;
            /* Increased gap between spans from 25px to 40px */
        }

        .header-sub-divider {
            border-bottom: 3px solid #000;
            margin: 0 auto 1.8rem auto;
            width: 100%;
        }

        /* Patient Info */
        .patient-info {
            display: flex;
            /*justify-content: space-between;
            align-items: flex-end; */
            justify-content: right;
            /* margin-bottom: 2rem; */
            font-weight: 700;
            padding: 0 5px;
        }

        .age-section {
            text-align: left;
        }

        .age-label {
            font-size: 11px;
            color: var(--secondary-text);
            font-weight: 600;
        }

        .age-value {
            font-size: 20px;
            margin-right: 5px;
        }

        .patient-details {
            text-align: left;
            direction: ltr;
        }

        .patient-name {
            font-size: 16px;
            margin-bottom: 2px;
        }

        .patient-date {
            font-size: 10px;
            color: var(--secondary-text);
            font-weight: 600;
        }

        /* Rx Section */
        .rx-section {
            margin-bottom: -30px;
            padding: 0 10px;
            min-height: 250px;
            position: relative;
        }

        .rx-symbol {
            font-family: serif;
            font-size: 42px;
            font-weight: 900;
            font-style: italic;
            margin-bottom: 1rem;
            text-decoration: underline;
            text-decoration-thickness: 2px;
            text-underline-offset: 5px;
            line-height: 1;
        }

        .medicine-list {
            padding: 0 15px;
            margin-bottom: 20px;
        }

        .medicine-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: .5rem;
            font-weight: 600;
            font-size: 13px;
            line-height: 1;
        }

        .medicine-number {
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
            min-width: 18px;
            text-align: center;
            margin-top: 1.5px;
        }

        /* QR Code Section */
        .qr-code-section {
            display: flex;
            justify-content: right;
            gap: 25px;
            margin-top: 30px;
            margin-right: 30px;
            padding: 10px 0;
        }

        .qr-code-section img {
            width: 65px;
            height: 65px;
            object-fit: contain;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
        }

        /* Footer */
        .footer-section {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            color: white;
            font-size: 10px;
            font-weight: 600;
        }

        .footer-contact {
            background-color: var(--footer-bg);
            padding: 8px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .phone-section {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .phone-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .icon-svg {
            width: 12px;
            height: 12px;
        }

        .footer-social {
            background-color: #000;
            text-align: center;
            padding: 6px 15px;
            margin: 0 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        /* RTL-specific adjustments */
        [dir="rtl"] .medicine-number {
            margin-left: 0;
            margin-right: 10px;
        }

        [dir="rtl"] .phone-item {
            direction: rtl;
        }

        [dir="rtl"] .qr-code-section {
            flex-direction: row-reverse;
        }

        .social-icons {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .icon-svg {
            width: 14px;
            height: 14px;
            fill: white;
        }

        .social-title {
            font-size: 9px;
            font-weight: 600;
        }

        .website {
            font-size: 9px;
            font-weight: 600;
        }

        /* Kurdish font support */
        .kurdish-text,
        [lang="ku"],
        .text-kurdish {
            font-family: 'Noto Sans Arabic', 'Cairo', sans-serif !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <header class="header-section">
            <h1 class="main-title">{!! setting('prescription_name', 'عيادة د. أزاد حسن خدر') !!}</h1>

            <div class="sub-title">
                {!! setting('prescription_title', 'Neurology, psychiatry & psychology Clinic') !!}
            </div>

            <div class="header-divider"></div>

            <div class="sub-title">
                {!! setting('prescription_sub_title', 'الطب النفسي والعصبي') !!}
            </div>

            <div class="header-divider"></div>

            <div class="credentials">
                <span>{{ __('M.B.Ch.B') }}</span>
                <span>{{ __('H.D.(M.Sc.)') }}</span>
                <span>{{ __('F.K.B.M.S(Neurology)') }}</span>
            </div>

            <div class="header-sub-divider"></div>
        </header>

        <!-- Patient Info -->
        <div class="patient-info">
            <div class="patient-details">
                <div class="patient-name">{{ $record->patient->name ?? 'Dlshad Mhamad Amin Aziz' }}</div>
                <div class="patient-date">
                    {{ isset($record->created_at) ? $record->created_at->format('Y/m/d') : '2025/10/26' }}
                </div>
            </div>
        </div>
        <div class="patient-info">

            <div class="age-section">
                <span class="age-label">{{ __('Age') }}:</span>
                <span class="age-value">{{ $record->patient->age ?? '20' }} Years</span>
            </div>
        </div>

        <!-- Rx Section -->
        <div class="rx-section">
            <div class="rx-symbol">{{ __('Rx') }}</div>

            <div class="medicine-list">
                @php
                    $medicines = collect((array) $record->treatment)
                        ->flatMap(fn($item) => is_string($item) ? array_map('trim', explode(',', $item)) : [$item])
                        ->filter()
                        ->unique()
                        ->values();
                @endphp
                @if ($medicines->isNotEmpty())
                    @foreach ($medicines as $index => $medicine)
                        <div class="medicine-item">
                            <span class="medicine-number">{{ $index + 1 }}.</span>
                            <span>{{ $medicine }}</span>
                        </div>
                    @endforeach

                @endif
            </div>


        </div>

        <!-- Footer -->
        <footer class="footer-section">
            <!-- QR Code Section - Added here -->
            <div class="qr-code-section">
                <img src="{{ asset('storage/' . setting_lang('prescription_qr_code_one')) }}" alt="QR Code 1">
                <img src="{{ asset('storage/' . setting_lang('prescription_qr_code_two')) }}" alt="QR Code 2">
            </div>
            <div class="footer-contact">
                <div class="phone-section">
                    <div class="phone-item">
                        <svg class="icon-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <div>
                            <div>{{ setting('prescription_phone_one', '07503504571') }}</div>
                            <div>{{ setting('prescription_phone_two', '07739250505') }}</div>
                            <div>{{ setting('prescription_phone_three', '07739250505') }}</div>
                        </div>
                    </div>
                </div>

                <div class="text-right" style="direction: rtl;">
                    <div class="kurdish-text">{{ strip_tags(setting_lang('address', null, 'ku')) }}</div>
                    <div>{{ strip_tags(setting_lang('address', null, 'ar')) }}</div>
                </div>
            </div>

            <div class="footer-social">
                <div class="social-icons">
                    <svg class="icon-svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg class="icon-svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.597 0-2.917-.01-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" />
                    </svg>
                    <svg class="icon-svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                </div>
                <div class="social-title">{{ setting('prescription_social_title', 'Follow Us') }}</div>
                <div class="website">{{ setting('prescription_website', 'www.azadhasan.com') }}</div>
            </div>
        </footer>
    </div>
</body>

</html>
