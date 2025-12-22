<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} Siêu Thị Vina - {{ __('Công ty TNHH thương mại Siêu Thị Vina') }}<br>
{{ __('Địa chỉ: 801/2A Phạm Thế Hiển, Phường 4, Quận 8, Thành phố Hồ Chí Minh') }}<br>
{{ __('MST: 0918326706 - Đại diện: Trần Bá Hộ') }}<br>
{{ __('Hotline: 0918326706 - Email: support@sieuthivina.com') }}

</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
