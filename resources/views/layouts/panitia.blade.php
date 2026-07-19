<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Penguji PMBM')</title>
  @vite(['resources/css/app.css'])
  @yield('styles')
  <style>
    /* Custom Dynamic Background for Dashboard with Cache Buster & Gradient Fallback */
    body {
        background-image: @if(file_exists(public_path('uploads/background/dashboard_bg.jpg'))) 
                            url('{{ asset('uploads/background/dashboard_bg.jpg') }}?t={{ filemtime(public_path('uploads/background/dashboard_bg.jpg')) }}')
                          @else 
                            linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 50%, #a5d6a7 100%) 
                          @endif;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        min-height: 100vh;
    }

    /* Premium Glassmorphism styling for Figma absolute containers */
    .desktop-12, .desktop-13, .desktop-14, .desktop-15, .desktop-16, .desktop-17, .desktop-18, .desktop-19, .desktop-20, .pmbm-program-khusus {
        background: rgba(255, 255, 255, 0.65) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        transition: all 0.2s ease-in-out;
    }

    /* Dynamic UI fixes: stretch top header background full width */
    .rectangle-2 {
        width: 100% !important;
    }
  </style>
</head>
<body class="antialiased text-slate-800">
  @yield('content')
  @yield('scripts')
</body>
</html>