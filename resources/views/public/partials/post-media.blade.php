@php($attachments = $post->meta['media'] ?? [])
@if(is_array($attachments) && count($attachments))
<section class="block page-media-section" aria-label="Медиаматериалы публикации">
  <p class="eyebrow">Материалы публикации</p>
  <h2>Фотографии, видео, аудио и документы</h2>
  <div class="page-media-grid">
    @foreach($attachments as $media)
      @if(!empty($media['path']) && in_array($media['type'] ?? '', ['image','audio','video','document'], true))
        @php($url = asset('storage/'.$media['path']))
        <figure class="page-media-item">
          @if($media['type'] === 'image')
            <a href="{{ $url }}" target="_blank" rel="noopener"><img loading="lazy" src="{{ $url }}" alt="{{ $media['title'] ?? $post->title }}"></a>
          @elseif($media['type'] === 'audio')
            <audio controls preload="none" src="{{ $url }}">Ваш браузер не поддерживает аудио.</audio>
          @elseif($media['type'] === 'video')
            <video controls preload="metadata" playsinline src="{{ $url }}">Ваш браузер не поддерживает видео.</video>
          @elseif($media['type'] === 'document')
            <a class="cms-document-link" href="{{ $url }}" target="_blank" rel="noopener" download><span aria-hidden="true">📄</span> {{ $media['title'] ?? basename($media['path']) }} — скачать</a>
            @if(strtolower(pathinfo($media['path'], PATHINFO_EXTENSION)) === 'pdf')<a href="{{ $url }}" target="_blank" rel="noopener">Открыть PDF в браузере</a>@endif
          @endif
          @if(!empty($media['title']))<figcaption>{{ $media['title'] }}</figcaption>@endif
        </figure>
      @endif
    @endforeach
  </div>
</section>
@endif
