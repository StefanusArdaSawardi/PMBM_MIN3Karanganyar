@php
  $allPrograms = \App\Models\Program::all();
@endphp

<section class="relative overflow-hidden px-6 pt-[110px] pb-12 text-center">
  <div class="absolute inset-0 z-0">
    <img src="{{ asset('assets/landing/home/hero-bg.jpg') }}" alt="MIN 3 Karanganyar" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/45"></div>
  </div>
  <div class="relative z-[1]">
    <h1 class="text-white font-bold tracking-[-0.4px] mb-3" style="font-family: 'PlusJakartaSans-Bold', sans-serif; font-size: clamp(22px, 4vw, 30px);">Program Pendaftaran PMBM</h1>
    <p class="text-white max-w-[600px] mx-auto mb-8 leading-[1.6] text-[16px]" style="font-family: 'Roboto-Regular', sans-serif;">Kurikulum yang dirancang khusus untuk mengoptimalkan potensi akademis dan karakter anak didik di era global.</p>

    <div class="flex flex-wrap justify-center gap-4">
      @foreach($allPrograms as $prog)
        @php
          $isActive = false;
          if (isset($activeProgramId) && $activeProgramId == $prog->id_program) {
              $isActive = true;
          } elseif (isset($activeProgram)) {
              $nameLower = strtolower($prog->nama_program);
              if ($activeProgram === 'khusus' && (strpos($nameLower, 'khusus') !== false || strpos($nameLower, 'tahfidz') !== false)) {
                  $isActive = true;
              } elseif ($activeProgram === 'unggulan' && (strpos($nameLower, 'unggulan') !== false || strpos($nameLower, 'sains') !== false)) {
                  $isActive = true;
              } elseif ($activeProgram === 'fullday' && (strpos($nameLower, 'fullday') !== false || strpos($nameLower, 'reguler') !== false)) {
                  $isActive = true;
              }
          }
        @endphp
        <a href="{{ route('landing.program-detail', $prog->id_program) }}"
           class="flex items-center justify-center min-w-[191px] h-[54px] px-5 rounded-lg text-[14px] font-bold text-center border shadow-[0_2px_4px_rgba(0,0,0,0.05)] transition-all duration-300 max-[600px]:min-w-0 max-[600px]:flex-1 max-[600px]:basis-[calc(50%-8px)] max-[600px]:text-[12px] max-[600px]:h-12
           {{ $isActive ? 'border-[#0f7643] bg-[#47a26a] text-white shadow-[0_4px_6px_rgba(0,0,0,0.1)]' : 'border-[#bdcab8] bg-white/90 text-black/60 hover:border-[#298752] hover:text-[#298752]' }}"
           style="font-family: 'PlusJakartaSans-Bold', sans-serif;">
          {{ $prog->nama_program }}
        </a>
      @endforeach
    </div>
  </div>
</section>

<section class="max-w-[1100px] mx-auto px-6 py-12 pb-16">
  <div class="grid grid-cols-[280px_1fr] gap-10 items-center bg-[#d9d9d9] border border-[#bdcab8] rounded-xl shadow-[0px_4px_4px_0px_rgba(255,255,255,0.8)] p-8 max-[800px]:grid-cols-1">
    @php
      $programModel = \App\Models\Program::find($activeProgramId ?? null);
      $programImages = $programModel ? $programModel->images : [];
      if (empty($programImages)) {
          $programImages = [$image];
      }
    @endphp

    @if(count($programImages) > 1)
      <!-- Slider/Carousel Container -->
      <div class="relative overflow-hidden w-full h-[327px] rounded-lg bg-[#3f4940] max-[800px]:h-[240px]" id="program-carousel" style="position: relative; overflow: hidden; width: 100%;">
        <div class="flex transition-transform duration-500 ease-in-out h-full w-full" id="carousel-track" style="display: flex; height: 100%; transition: transform 0.5s ease-in-out;">
          @foreach($programImages as $img)
            <div style="width: 100%; height: 100%; flex-shrink: 0;">
              <img src="{{ asset($img) }}" alt="{{ $title }} Ilustrasi" class="w-full h-full object-cover" style="width: 100%; height: 100%; object-fit: cover;" />
            </div>
          @endforeach
        </div>
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const track = document.getElementById('carousel-track');
          if (!track) return;
          const slides = Array.from(track.children);
          let currentIndex = 0;
          const slideCount = slides.length;

          function nextSlide() {
            currentIndex = (currentIndex + 1) % slideCount;
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
          }

          // Auto scroll every 3 seconds
          setInterval(nextSlide, 3000);
        });
      </script>
    @else
      <img src="{{ asset($programImages[0]) }}" alt="{{ $title }} Ilustrasi" class="w-full h-[327px] object-cover rounded-lg bg-[#3f4940] max-[800px]:h-[240px]" />
    @endif

    <div class="flex flex-col gap-4">
      <h2 class="text-black font-bold tracking-[-0.4px] text-[25px] m-0" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">{{ $title }}</h2>
      <p class="text-black/50 text-[16px] leading-[1.6] m-0" style="font-family: 'Roboto-Regular', sans-serif;">{{ $description }}</p>

      <div class="flex flex-col gap-3.5 mt-2">
        @foreach($features as $feature)
          <div class="flex items-start gap-[13px] text-[#3f4940] text-[15px] leading-[1.5]" style="font-family: 'Roboto-Regular', sans-serif;">
            <svg class="w-[26px] h-[26px] shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" fill="#0f7643"/>
              <path d="M8 12.5l2.5 2.5L16 9" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>{{ $feature }}</span>
          </div>
        @endforeach
      </div>

      <!-- Action Buttons -->
      <div class="flex gap-4 mt-6 flex-wrap">
        <a href="{{ route('student.register') }}" class="inline-flex items-center justify-center bg-[#0f7643] hover:bg-[#0c5c34] text-white font-bold px-6 py-3 rounded-lg text-[14px] transition-colors shadow-md no-underline">
          <span>📝</span> &nbsp; Daftar Sekarang
        </a>
        <a href="{{ route('landing.kontak') }}" class="inline-flex items-center justify-center bg-white border border-[#bdcab8] hover:border-[#0f7643] text-[#3f4940] hover:text-[#0f7643] font-bold px-6 py-3 rounded-lg text-[14px] transition-colors shadow-sm no-underline">
          <span>❓</span> &nbsp; Ada Pertanyaan? Hubungi Kami
        </a>
      </div>
    </div>
  </div>
</section>
