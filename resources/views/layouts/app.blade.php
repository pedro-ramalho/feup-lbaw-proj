<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/common/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common/popCommunity.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common/preview_post.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/common/sort.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pages/profile.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pages/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/previews/preview_post.css') }}" rel="stylesheet">
    <link href="{{ asset('css/previews/preview_user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pages/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common/comment.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common/aboutcommunity.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common/communityrules.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pages/post.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pages/post_edit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pages/post_submit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pages/search.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pages/profile_edit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common/footer.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css" integrity="sha512-FA9cIbtlP61W0PRtX36P6CGRy0vZs0C2Uw26Q1cMmj3xwhftftymr0sj8/YeezDnRwL9wtWw8ZwtCiTDXlXGjQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('css/pages/community2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pages/community-edit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common/aboutcommunity.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common/communityrules.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pages/community_edit.css') }}" rel="stylesheet">

    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer> </script>
    <script src={{ asset('js/dropdown.js') }} defer></script>
    <script src={{ asset('js/profile.js') }} defer></script>
    <script src={{ asset('js/like_dislike.js') }} defer></script>
    <script src={{ asset('js/popular_communities.js') }} defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-white font-sans"> 
    @include('layouts.header')
    <main>
        @yield('content')
    </main>
    @include('partials.footer')
  </body>
</html>
