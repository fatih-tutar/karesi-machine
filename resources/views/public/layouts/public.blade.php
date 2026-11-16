<!DOCTYPE html>
<html lang="tr">
<head>
@include('public.partials.head')
@stack('head')
</head>
<body class="{{ $bodyClass ?? 'index2 idx2-subpage' }}">

@include('public.partials.nav')

<main id="ana-icerik">
@yield('content')

@include('public.partials.footer')
</main>

@stack('schema')
@include('public.partials.script-public')
@stack('scripts')
</body>
</html>
