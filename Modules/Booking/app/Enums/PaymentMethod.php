<?php

namespace Modules\Booking\Enums;

enum PaymentMethod: string
{

    case Cash = 'cash';
    case Fib = 'fib';

    public function label(): string
    {
        return match ($this) {
            self::Cash => __('Cash'),
            self::Fib => __('FIB'),
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [$case->value => $case->label()])
            ->toArray();
    }
    
}
