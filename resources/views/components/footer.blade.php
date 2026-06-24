<!-- Footer Component -->
<div id="footer-group-wrapper" style="position: absolute; left: 0; top: 0; width: 100%; height: 100%; pointer-events: none;">
  <style>
    #footer-group-wrapper * {
      pointer-events: auto;
    }
  </style>
  <div class="rectangle-16"></div>
  <div class="container">
    <div class="heading-5">
      <div class="informasi">INFORMASI</div>
    </div>
    <div class="list">
      <div class="item">
        <a href="{{ route('landing.guide') }}" class="syarat-daftar" style="color: inherit;">Syarat Daftar</a>
      </div>
      <div class="item">
        <a href="{{ route('landing.guide') }}" class="biaya-pendidikan" style="color: inherit;">Biaya Pendidikan</a>
      </div>
      <div class="item">
        <a href="#" class="brosur-digital" style="color: inherit;" onclick="alert('Brosur digital sedang dipersiapkan!');">Brosur Digital</a>
      </div>
      <div class="item">
        <a href="#" class="panduan-siswa" style="color: inherit;" onclick="alert('Panduan siswa sedang dipersiapkan!');">Panduan Siswa</a>
      </div>
    </div>
  </div>

  <div class="sroyo-kec-jaten-kabupaten-karanganyar-jawa-tengah-57731">
    {{ $landingContent['address'] ?? 'Sroyo, Kec. Jaten, Kabupaten Karanganyar, Jawa Tengah 57731' }}
  </div>
  <div class="_0812-2667-6554">{{ $landingContent['phone'] ?? '0812-2667-6554' }}</div>
  <div class="min-3-kra-gmail-com">{{ $landingContent['email'] ?? 'min3kra@gmail.com' }}</div>
  <div class="hubungi-kami">HUBUNGI KAMI</div>

  <div class="container2">
    <div class="heading-4">
      <div class="pmbm-school">PMBM SCHOOL</div>
    </div>
    <div class="container3">
      <div class="lembaga-pendidikan-unggulan-yang-berkomitmen-melahirkan-generasi-cerdas-berintegritas-tinggi-berakhlak-mulia-dan-siap-bersaing-di-kancah-global">
        Lembaga pendidikan unggulan yang
        <br />
        berkomitmen melahirkan generasi cerdas,
        <br />
        berintegritas tinggi, berakhlak mulia, dan
        <br />
        siap bersaing di kancah global.
      </div>
    </div>
  </div>

  <div class="container4">
    <div class="heading-5">
      <div class="jelajah">JELAJAH</div>
    </div>
    <div class="list">
      <div class="item">
        <a href="{{ route('home') }}" class="beranda" style="color: inherit; font-size: inherit; font-family: inherit;">Beranda</a>
      </div>
      <div class="item">
        <a href="{{ route('landing.program-khusus') }}" class="program-studi" style="color: inherit; font-size: inherit; font-family: inherit;">Program Studi</a>
      </div>
      <div class="item">
        <a href="{{ route('home') }}#alur-pmb" class="alur-pmb" style="color: inherit; font-size: inherit; font-family: inherit;">Alur PMB</a>
      </div>
      <div class="item">
        <a href="{{ route('landing.cek-kelulusan') }}" class="{{ Request::routeIs('landing.cek-kelulusan') ? 'cek-kelulusan3' : 'cek-kelulusan' }}" style="color: inherit; font-size: inherit; font-family: inherit;">Cek Kelulusan</a>
      </div>
    </div>
  </div>

  <div class="_2026-pmbm-school-all-rights-reserved">
    © 2026 PMBM School. All Rights Reserved.
  </div>

  <div class="container5">
    <span class="text">Designed with</span>
    <img class="container6" src="{{ asset('assets/landing/' . $activeFolder . '/container5.svg') }}" alt="Heart" />
    <span class="text">for Education</span>
  </div>

  <img class="pin-duotone-line" src="{{ asset('assets/landing/' . $activeFolder . '/pin-duotone-line0.svg') }}" alt="Address Pin" />
  <img class="phone-fill" src="{{ asset('assets/landing/' . $activeFolder . '/phone-fill0.svg') }}" alt="Phone" />
  <img class="message" src="{{ asset('assets/landing/' . $activeFolder . '/message0.svg') }}" alt="Email Message" />
</div>
