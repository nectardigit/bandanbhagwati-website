@php
    $__t = trim($text ?? '');
    $__lines = preg_split('/\r\n|\r|\n/', $__t);
    $__lines = array_values(array_filter(
        array_map(fn ($l) => trim(preg_replace('/^\s*[>\-\*•·≡»–]+\s*/u', '', $l)), $__lines),
        fn ($l) => $l !== ''
    ));
@endphp
@if (count($__lines) > 1)
    <ul class="feat-list">
        @foreach ($__lines as $__l)<li>{{ $__l }}</li>@endforeach
    </ul>
@else
    <p>{{ $__t }}</p>
@endif
