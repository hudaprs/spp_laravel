<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content={{ csrf_token() }}>
  <title>Laravel Starter - @yield('title')</title>
  @include('inc.cms.style')
</head>
<body class="hold-transition sidebar-mini">  
  <div class="wrapper">
    {{-- Navbar --}}
    @include('inc.cms.navbar')
        
    {{-- Sidebar --}}
    @include('inc.cms.sidebar')

    <div class="content-wrapper">
      {{-- Header --}}
      @include('inc.cms.header')

      {{-- Main Content --}}
      <div class="content">
        {{-- Modal --}}
        @include('inc.cms.modal')

        {{-- Content --}}
        @include('inc.cms.content')
      </div>
    </div>

    {{-- Footer --}}
    @include('inc.cms.footer')
  </div>

  {{-- Scripts --}}
  @include('inc.cms.script')
</body>
</html>
