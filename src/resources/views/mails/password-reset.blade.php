@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# @lang('layout-ui::auth.password-reset-email-greeting-error')
@else
# @lang('layout-ui::auth.password-reset-email-greeting')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('layout-ui::auth.password-reset-email-salutation'),<br><i>{{ config('app.name') }}</i>
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
@lang('layout-ui::auth.password-reset-email-problems', [
    'actionText' => $actionText,
    'actionURL' => $actionUrl
])
@endcomponent
@endisset
@endcomponent
