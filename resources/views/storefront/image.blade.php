@php
 $reference = str_starts_with($source, '/reyana/look-');
 if ($reference && !config('reyana.preview')) $source = '/reyana/placeholder.svg';
 $stem = pathinfo($source, PATHINFO_FILENAME);
 $responsive = $reference && config('reyana.preview');
@endphp
<img src="{{ url($responsive ? '/reyana/'.$stem.'-medium.webp' : $source) }}" @if($responsive) srcset="{{ url('/reyana/'.$stem.'-small.webp') }} 400w, {{ url('/reyana/'.$stem.'-medium.webp') }} 750w, {{ url($source) }} 1000w" sizes="{{ $imageSizes ?? '(max-width: 767px) 45vw, (max-width: 1100px) 30vw, 23vw' }}" @endif alt="{{ $altText }}" width="1000" height="1250" @if($eager ?? false) fetchpriority="high" @else loading="lazy" @endif>
