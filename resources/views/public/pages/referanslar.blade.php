@extends('public.layouts.public', ['bodyClass' => 'index2 idx2-subpage'])

@section('content')
<section class="idx2-page-hero idx2-page-hero--compact">
    <div class="idx2-hero-bg" aria-hidden="true">
        <div class="idx2-hero-bg-blob-tr"></div>
        <div class="idx2-hero-bg-blob-bl"></div>
        <div class="idx2-hero-bg-dots"></div>
        <div class="idx2-hero-bg-line"></div>
    </div>
    <div class="container py-4 pb-2">
        <nav class="idx2-breadcrumb mb-3" aria-label="Sayfa konumu">
            <a href="{{ url('/') }}">Ana sayfa</a>
            <span aria-hidden="true">/</span>
            <span>Referanslar</span>
        </nav>
        <h1 class="idx2-page-title mb-2">Referanslar</h1>
        <p class="idx2-page-lead col-lg-8 px-0 mb-0">
            İşletmelerde çalışan simit makinesi uygulamalarını izleyin.
            {{ $refCount > 0 ? htmlspecialchars((string) $refCount, ENT_QUOTES, 'UTF-8') . ' referans videosu' : 'Videolar yakında eklenecek' }}.
        </p>
    </div>
</section>

<section class="idx2-section pt-3">
    <div class="container">
        @if (empty($refVideos))
            <div class="idx2-ref-empty text-center py-5">
                <p class="mb-3" style="color: var(--muted);">Henüz listelenecek referans videosu yok.</p>
                <a class="btn idx2-hero-primary px-4" href="{{ url('/iletisim') }}">İletişime geçin</a>
            </div>
        @else
            <div class="idx2-yt" id="idx2YtWatch" data-active-id="{{ $refActiveId }}">
                <div class="idx2-yt-primary">
                    <div class="idx2-yt-player-wrap">
                        <iframe
                            id="idx2YtPlayer"
                            class="idx2-yt-player"
                            title="{{ $refActiveLabel }}"
                            src="https://www.youtube-nocookie.com/embed/{{ $refActiveId }}?rel=0&modestbranding=1"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen"
                            allowfullscreen
                            loading="eager"></iframe>
                    </div>
                    <h2 class="idx2-yt-now-title" id="idx2YtNowTitle">{{ $refActiveLabel }}</h2>
                </div>

                <aside class="idx2-yt-rail" aria-label="Diğer referans videoları">
                    <p class="idx2-yt-rail-heading">Sıradaki videolar</p>
                    <div class="idx2-yt-rail-list" id="idx2YtRail">
                        @foreach ($refVideos as $i => $v)
@php
                            $vid = (string) ($v['id'] ?? '');
                            $label = (string) ($v['label'] ?? 'Video');
                            if ($vid === '') {
                                continue;
                            }
                            $isActive = ($vid === $refActiveId);
                            $thumb = 'https://img.youtube.com/vi/' . rawurlencode($vid) . '/mqdefault.jpg';
@endphp
                            <button type="button"
                                    class="idx2-yt-rail-item{{ $isActive ? ' is-active' : '' }}"
                                    data-video-id="{{ $vid }}"
                                    data-video-title="{{ $label }}"
                                    aria-pressed="{{ $isActive ? 'true' : 'false' }}">
                                <span class="idx2-yt-rail-thumb">
                                    <img src="{{ $thumb }}" alt="" width="168" height="94" loading="{{ $i < 6 ? 'eager' : 'lazy' }}" decoding="async">
                                    <span class="idx2-yt-rail-play" aria-hidden="true"><i class="bi bi-play-fill"></i></span>
                                </span>
                                <span class="idx2-yt-rail-meta">
                                    <span class="idx2-yt-rail-title">{{ $label }}</span>
                                    <span class="idx2-yt-rail-sub">Karesi Makine</span>
                                </span>
                            </button>
                        @endforeach
                    </div>
                </aside>
            </div>

            <div class="idx2-yt-grid-wrap mt-4 mt-lg-5">
                <h2 class="idx2-yt-grid-heading">Tüm referans videoları</h2>
                <div class="idx2-yt-grid" id="idx2YtGrid">
                    @foreach ($refVideos as $i => $v)
@php
                        $vid = (string) ($v['id'] ?? '');
                        $label = (string) ($v['label'] ?? 'Video');
                        if ($vid === '') {
                            continue;
                        }
                        $isActive = ($vid === $refActiveId);
                        $thumb = 'https://img.youtube.com/vi/' . rawurlencode($vid) . '/hqdefault.jpg';
@endphp
                        <button type="button"
                                class="idx2-yt-card{{ $isActive ? ' is-active' : '' }}"
                                data-video-id="{{ $vid }}"
                                data-video-title="{{ $label }}"
                                aria-pressed="{{ $isActive ? 'true' : 'false' }}">
                            <span class="idx2-yt-card-thumb">
                                <img src="{{ $thumb }}" alt="{{ $label }}" width="480" height="360" loading="lazy" decoding="async">
                                <span class="idx2-yt-card-play" aria-hidden="true"><i class="bi bi-play-fill"></i></span>
                            </span>
                            <span class="idx2-yt-card-title">{{ $label }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

@endsection

@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@graph": [
        {
            "@@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@@type": "ListItem",
                    "position": 1,
                    "name": "Ana sayfa",
                    "item": "{{ $seoSiteUrl }}/"
                },
                {
                    "@@type": "ListItem",
                    "position": 2,
                    "name": "Referanslar",
                    "item": "{{ $seoCanonical }}"
                }
            ]
        },
        {
            "@@type": "CollectionPage",
            "@@id": "{{ $seoCanonical }}#webpage",
            "url": "{{ $seoCanonical }}",
            "name": {!! json_encode($seoTitle, JSON_UNESCAPED_UNICODE) !!},
            "description": {!! json_encode($seoDescription, JSON_UNESCAPED_UNICODE) !!},
            "isPartOf": { "@@id": "{{ $seoSiteUrl }}/#website" },
            "inLanguage": "tr-TR"
        }
        @if (!empty($refVideos))
        ,{
            "@@type": "ItemList",
            "name": "Karesi Makine referans videoları",
            "numberOfItems": {{ (int) $refCount }},
            "itemListElement": [
                @foreach ($refVideos as $i => $v)
                {
                    "@@type": "VideoObject",
                    "position": {{ $i + 1 }},
                    "name": {!! json_encode((string) $v['label'], JSON_UNESCAPED_UNICODE) !!},
                    "thumbnailUrl": "https://img.youtube.com/vi/{{ rawurlencode((string) $v['id']) }}/hqdefault.jpg",
                    "embedUrl": "https://www.youtube.com/embed/{{ rawurlencode((string) $v['id']) }}",
                    "url": "https://www.youtube.com/watch?v={{ rawurlencode((string) $v['id']) }}"
                }{{ $i < $refCount - 1 ? ',' : '' }}
                @endforeach
            ]
        }
        @endif
    ]
}
</script>
@endpush

@push('scripts')
@if (!empty($refVideos))
<script>
(function () {
    var root = document.getElementById('idx2YtWatch');
    var player = document.getElementById('idx2YtPlayer');
    var titleEl = document.getElementById('idx2YtNowTitle');
    if (!root || !player || !titleEl) return;

    function selectVideo(id, title, trigger) {
        if (!id) return;
        root.setAttribute('data-active-id', id);
        player.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) + '?rel=0&modestbranding=1&autoplay=1';
        player.title = title || 'Referans videosu';
        titleEl.textContent = title || 'Referans videosu';

        document.querySelectorAll('.idx2-yt-rail-item, .idx2-yt-card').forEach(function (el) {
            var on = el.getAttribute('data-video-id') === id;
            el.classList.toggle('is-active', on);
            el.setAttribute('aria-pressed', on ? 'true' : 'false');
        });

        if (trigger && trigger.classList.contains('idx2-yt-card')) {
            root.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-video-id]');
        if (!btn || (!btn.classList.contains('idx2-yt-rail-item') && !btn.classList.contains('idx2-yt-card'))) return;
        e.preventDefault();
        selectVideo(btn.getAttribute('data-video-id'), btn.getAttribute('data-video-title'), btn);
    });
})();
</script>
@endif
@endpush
