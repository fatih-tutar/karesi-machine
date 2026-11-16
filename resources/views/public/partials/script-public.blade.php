<script>
(function () {
    var toggler = document.querySelector('.idx2-nav .navbar-toggler');
    var nav = document.getElementById('idx2Nav');
    if (toggler && nav) {
        toggler.addEventListener('click', function () {
            var open = nav.classList.toggle('is-open');
            toggler.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }
})();
</script>
<script>
(function () {
    var gaId = 'G-CWK7CGYGXR';
    var adsId = 'AW-633898622';
    var waSendTo = 'AW-633898622/fYNXCJKQvLAdEP6Moq4C';
    var phoneSendTo = 'AW-633898622/jSDXCJz3wrAdEP6Moq4C';
    var loaded = false;
    var scriptReady = false;
    var readyWaiters = [];

    function flushReady() {
        scriptReady = true;
        while (readyWaiters.length) {
            var cb = readyWaiters.shift();
            try { cb(); } catch (e) {}
        }
    }

    function whenGtagReady(cb) {
        if (scriptReady && typeof window.gtag === 'function') {
            cb();
            return;
        }
        readyWaiters.push(cb);
        loadGa();
    }

    function loadGa() {
        if (loaded) return;
        loaded = true;
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        window.gtag = gtag;
        gtag('js', new Date());
        gtag('config', gaId, { send_page_view: true });
        gtag('config', adsId);

        var s = document.createElement('script');
        s.async = true;
        s.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(gaId);
        s.onload = flushReady;
        s.onerror = flushReady;
        document.head.appendChild(s);
        setTimeout(flushReady, 1500);
    }

    ['pointerdown', 'keydown', 'scroll', 'touchstart'].forEach(function (ev) {
        window.addEventListener(ev, loadGa, { once: true, passive: true });
    });

    function navigateAfterConversion(url, newTab) {
        if (newTab && !newTab.closed) {
            newTab.location.href = url;
            return;
        }
        window.location.href = url;
    }

    function gtag_report_conversion(url, newTab, sendTo) {
        var completed = false;

        function finish() {
            if (completed) return;
            completed = true;
            navigateAfterConversion(url, newTab);
        }

        var fallback = setTimeout(finish, 2500);

        whenGtagReady(function () {
            if (typeof window.gtag !== 'function') {
                clearTimeout(fallback);
                finish();
                return;
            }
            window.gtag('event', 'conversion', {
                send_to: sendTo,
                event_callback: function () {
                    clearTimeout(fallback);
                    finish();
                },
                event_timeout: 2000
            });
        });

        return false;
    }

    window.gtag_report_conversion = function (url, newTab) {
        return gtag_report_conversion(url, newTab, waSendTo);
    };

    document.addEventListener('click', function (event) {
        var link = event.target.closest('a[href]');
        if (!link) return;

        var url;
        try {
            url = new URL(link.href, window.location.href);
        } catch (e) {
            return;
        }

        if (url.hostname === 'wa.me') {
            event.preventDefault();
            var waTab = link.target === '_blank'
                ? window.open('about:blank', '_blank')
                : null;
            gtag_report_conversion(link.href, waTab, waSendTo);
            return;
        }

        if (url.protocol === 'tel:') {
            event.preventDefault();
            gtag_report_conversion(link.href, null, phoneSendTo);
        }
    });
})();
</script>
