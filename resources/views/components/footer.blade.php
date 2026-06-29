@php
  $addressContact = $schoolContacts->firstWhere('platform_name', 'Alamat');
  $phoneContact = $schoolContacts->firstWhere('platform_name', 'Telepon') ?? $schoolContacts->firstWhere('platform_name', 'WhatsApp');
  $emailContact = $schoolContacts->firstWhere('platform_name', 'Email');
@endphp

<!-- Footer Component -->
<footer class="site-footer">
  <div class="footer-columns">
    <div class="footer-col footer-col-brand">
      <div class="footer-heading footer-heading-accent">PMBM SCHOOL</div>
      <p class="footer-text footer-text-muted">
        Lembaga pendidikan unggulan yang berkomitmen melahirkan generasi cerdas,
        berintegritas tinggi, berakhlak mulia, dan siap bersaing di kancah global.
      </p>
    </div>

    <div class="footer-col">
      <div class="footer-heading">JELAJAH</div>
      <ul class="footer-list">
        <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
        <li><a href="{{ route('landing.program-khusus') }}" class="footer-link">Program Studi</a></li>
        <li><a href="{{ route('home') }}#alur-pmb" class="footer-link">Alur PMB</a></li>
        <li><a href="{{ route('landing.cek-kelulusan') }}" class="footer-link">Cek Kelulusan</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <div class="footer-heading">GUIDE</div>
      <ul class="footer-list">
        <li><a href="{{ route('landing.guide') }}" class="footer-link">Syarat Pendaftaran</a></li>
        <li><a href="{{ route('landing.guide') }}" class="footer-link">Jadwal Pendaftaran</a></li>
        <li><a href="{{ route('student.register') }}" class="footer-link">Pendaftaran PMBM</a></li>
        <li><a href="{{ route('landing.guide') }}" class="footer-link">Panduan Booklet</a></li>
        <li><a href="{{ route('landing.cek-kelulusan') }}" class="footer-link">Cek Kelulusan</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <div class="footer-heading">HUBUNGI KAMI</div>
      <ul class="footer-list footer-contact-list">
        <li class="footer-contact-item">
          <svg class="footer-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s-7-7.5-7-12a7 7 0 1 1 14 0c0 4.5-7 12-7 12z" stroke="#f8f9ff" stroke-width="1.5"/><circle cx="12" cy="9" r="2.5" stroke="#f8f9ff" stroke-width="1.5"/></svg>
          @if($addressContact)
            <a href="{{ $addressContact->link }}" target="_blank" class="footer-link">{{ $addressContact->value }}</a>
          @else
            <span class="footer-link">{{ $landingContent['address'] ?? 'Sroyo, Kec. Jaten, Kabupaten Karanganyar, Jawa Tengah 57731' }}</span>
          @endif
        </li>
        <li class="footer-contact-item">
          <svg class="footer-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 5c0-1.1.9-2 2-2h2.2c.5 0 1 .4 1.1.9l1 4a1 1 0 0 1-.3 1L7.6 10c1 2 2.9 4 5 5l1.1-1.4a1 1 0 0 1 1-.3l4 1c.5.1.9.6.9 1.1V18c0 1.1-.9 2-2 2h-1C9.5 20 4 14.5 4 7V6" stroke="#f8f9ff" stroke-width="1.5"/></svg>
          @if($phoneContact)
            <a href="{{ $phoneContact->link }}" class="footer-link">{{ $phoneContact->value }}</a>
          @else
            <span class="footer-link">{{ $landingContent['phone'] ?? '0812-2667-6554' }}</span>
          @endif
        </li>
        <li class="footer-contact-item">
          <svg class="footer-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="16" height="16" rx="2" stroke="#f8f9ff" stroke-width="1.5"/><path d="M4 6l8 6 8-6" stroke="#f8f9ff" stroke-width="1.5"/></svg>
          @if($emailContact)
            <a href="{{ $emailContact->link }}" class="footer-link">{{ $emailContact->value }}</a>
          @else
            <span class="footer-link">{{ $landingContent['email'] ?? 'min3kra@gmail.com' }}</span>
          @endif
        </li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="footer-copyright">© 2026 PMBM School. All Rights Reserved.</div>
    <div class="footer-credit">
      <span>Designed with</span>
      <img src="{{ asset('assets/landing/' . $activeFolder . '/container5.svg') }}" alt="Heart" class="footer-heart-icon" />
      <span>for Education</span>
    </div>
  </div>
</footer>

<style>
  .site-footer {
    background: #064e3b;
    color: #f8f9ff;
    padding: 56px 40px 24px;
    margin-top: 60px;
  }
  .footer-columns {
    max-width: 1280px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1.4fr 1fr 1fr 1.2fr;
    gap: 32px;
  }
  .footer-col {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }
  .footer-heading {
    font-family: "WorkSans-Regular", sans-serif;
    font-size: 16px;
    color: #f8f9ff;
  }
  .footer-heading-accent {
    font-family: "PlusJakartaSans-Regular", sans-serif;
    color: #7ed99c;
  }
  .footer-text {
    font-family: "WorkSans-Regular", sans-serif;
    font-size: 16px;
    line-height: 1.5;
    color: #f8f9ff;
    margin: 0;
  }
  .footer-text-muted {
    opacity: 0.7;
  }
  .footer-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
    opacity: 0.8;
  }
  .footer-link {
    color: #f8f9ff;
    font-family: "WorkSans-Regular", sans-serif;
    font-size: 16px;
    text-decoration: none;
  }
  .footer-link:hover {
    text-decoration: underline;
  }
  .footer-contact-list {
    opacity: 1;
    gap: 16px;
  }
  .footer-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
  }
  .footer-icon {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
    margin-top: 2px;
  }
  .footer-bottom {
    max-width: 1280px;
    margin: 40px auto 0;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
  }
  .footer-copyright {
    font-family: "WorkSans-Regular", sans-serif;
    font-size: 14px;
    opacity: 0.5;
  }
  .footer-credit {
    display: flex;
    align-items: center;
    gap: 4px;
    font-family: "WorkSans-Regular", sans-serif;
    font-size: 14px;
    opacity: 0.6;
  }
  .footer-heart-icon {
    width: 10px;
    height: auto;
  }

  @media (max-width: 1024px) {
    .footer-columns {
      grid-template-columns: 1fr 1fr;
      gap: 32px 24px;
    }
  }

  @media (max-width: 640px) {
    .site-footer {
      padding: 40px 20px 20px;
    }
    .footer-columns {
      grid-template-columns: 1fr;
      gap: 28px;
    }
    .footer-bottom {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>
