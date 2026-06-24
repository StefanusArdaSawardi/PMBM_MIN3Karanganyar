<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'PMBM MIN 3 Karanganyar')</title>
  @yield('styles')
  <style>
   a,
   button,
   input,
   select,
   h1,
   h2,
   h3,
   h4,
   h5,
   * {
       box-sizing: border-box;
       margin: 0;
       padding: 0;
       border: none;
       text-decoration: none;
       background: none;
       -webkit-font-smoothing: antialiased;
   }
   
   menu, ol, ul {
       list-style-type: none;
       margin: 0;
       padding: 0;
   }
  </style>
</head>
<body>
  @yield('content')
  @yield('scripts')

  <!-- Global Tanya Asisten PMBM Floating Button -->
  <a href="javascript:void(0);" onclick="alert('Fitur Tanya Asisten PMBM akan segera dihubungkan dengan API Chat!')" style="position: fixed; bottom: 30px; right: 30px; background: #005b31; color: #ffffff; padding: 12px 24px; border-radius: 9999px; display: flex; align-items: center; gap: 10px; font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: 14px; font-weight: 700; text-decoration: none; box-shadow: 0px 4px 15px rgba(0, 91, 49, 0.3); z-index: 9999; transition: all 0.3s ease; border: 1px solid rgba(255,255,255,0.1);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0px 6px 20px rgba(0, 91, 49, 0.4)'; this.style.background='#064e3b';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0px 4px 15px rgba(0, 91, 49, 0.3)'; this.style.background='#005b31';">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
      <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"/>
    </svg>
    <span>Tanya Asisten PMBM</span>
  </a>
</body>
</html>
