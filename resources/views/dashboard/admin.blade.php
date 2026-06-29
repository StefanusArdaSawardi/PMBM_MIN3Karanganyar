@extends('layouts.admin')

@section('title', 'Admin Dashboard - CMS PMBM')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/admin/dashboard/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/dashboard/style.css') }}">
@endsection

@section('content')
  <div class="relative min-h-screen flow-root">
    <!-- Admin Sidebar Included -->
    @include('components.sidebar-admin', ['activeFolder' => 'dashboard'])

    <!-- Main Content Wrapper -->
    <div class="absolute left-[340px] top-[138px] right-10 flex flex-col gap-6 z-10 max-[1024px]:left-5 max-[1024px]:right-5 max-[1024px]:top-[150px]">

      <!-- Stats Grid Section -->
      <div class="flex flex-row gap-4 items-stretch max-[1024px]:flex-wrap">
        <!-- Total Peserta Card -->
        <a href="{{ route('scores.index') }}" class="flex-1 min-w-[200px] no-underline text-inherit">
          <div class="bg-white border border-[#becabe] rounded-xl p-6 flex flex-col gap-1 w-full h-full transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(0,91,49,0.12)] hover:border-[#005b31]">
            <div class="flex flex-row items-start justify-between w-full">
              <img class="w-[38px] h-[39px]" src="{{ asset('assets/admin/dashboard/background1.svg') }}" alt="">
              <div class="bg-[#dcfce7] rounded-full px-2 py-1">
                <div class="text-[#15803d] text-[12px] font-semibold">+12%</div>
              </div>
            </div>
            <div class="pt-3">
              <div class="text-[#3f4940] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">Total Peserta</div>
            </div>
            <div class="text-[#121c2a] text-[24px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">{{ number_format($totalPeserta) }}</div>
          </div>
        </a>

        <!-- Total Keterima Card -->
        <a href="{{ route('scores.index', ['status' => 'lulus']) }}" class="flex-1 min-w-[200px] no-underline text-inherit">
          <div class="bg-white border border-[#becabe] rounded-xl p-6 flex flex-col gap-1 w-full h-full transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(0,91,49,0.12)] hover:border-[#005b31]">
            <div class="flex flex-row items-start justify-between w-full">
              <img class="w-9 h-10" src="{{ asset('assets/admin/dashboard/background7.svg') }}" alt="">
              <div class="bg-[#dcfce7] rounded-full px-2 py-1">
                <div class="text-[#15803d] text-[12px] font-semibold">+8%</div>
              </div>
            </div>
            <div class="pt-3">
              <div class="text-[#3f4940] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">Total Keterima</div>
            </div>
            <div class="text-[#121c2a] text-[24px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">{{ number_format($totalKeterima) }}</div>
          </div>
        </a>

        <!-- Total Tidak Keterima Card -->
        <a href="{{ route('scores.index', ['status' => 'tidak_lulus']) }}" class="flex-1 min-w-[200px] no-underline text-inherit">
          <div class="bg-white border border-[#becabe] rounded-xl p-6 flex flex-col gap-1 w-full h-full transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(185,28,28,0.12)] hover:border-[#b91c1c]">
            <div class="flex flex-row items-start justify-between w-full">
              <img class="w-9 h-[43px]" src="{{ asset('assets/admin/dashboard/background3.svg') }}" alt="">
              <div class="bg-[#fee2e2] rounded-full px-2 py-1">
                <div class="text-[#b91c1c] text-[12px] font-semibold">+3%</div>
              </div>
            </div>
            <div class="pt-3">
              <div class="text-[#3f4940] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">Total Tidak Keterima</div>
            </div>
            <div class="text-[#121c2a] text-[24px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">{{ number_format($totalTidakKeterima) }}</div>
          </div>
        </a>

        <!-- Rate Card -->
        <div class="flex-1 min-w-[200px] bg-white border border-[#becabe] rounded-xl p-6 flex flex-col gap-1">
          <div class="flex flex-row items-start justify-between w-full">
            <img class="w-[38px] h-10" src="{{ asset('assets/admin/dashboard/background5.svg') }}" alt="">
            <div class="bg-[#dcfce7] rounded-full px-2 py-1">
              <div class="text-[#15803d] text-[12px] font-semibold">+5%</div>
            </div>
          </div>
          <div class="pt-3">
            <div class="text-[#3f4940] text-[14px] font-semibold tracking-[0.7px]" style="font-family: 'WorkSans-SemiBold', sans-serif;">Tingkat Kelulusan</div>
          </div>
          <div class="text-[#121c2a] text-[24px] font-bold" style="font-family: 'PlusJakartaSans-Bold', sans-serif;">{{ $tingkatKelulusan }}%</div>
        </div>
      </div>

      <!-- Charts Grid Section -->
      <div class="flex flex-row gap-6 items-stretch max-[900px]:flex-col">
        <!-- Pendaftar Chart -->
        <div class="flex-1 bg-white border border-[#becabe] rounded-xl p-8 flex flex-col gap-8">
          <div class="text-[#121c2a] text-[20px] font-semibold" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">Jumlah Pendaftar Per Tahun</div>
          <div class="border-b border-[#becabe] h-[200px] flex flex-row gap-3 items-end pb-6 w-full">
            @foreach($charts['pendaftar'] as $year => $count)
              <div class="flex flex-col gap-2 items-center">
                <div class="bg-[#005b31] w-10 rounded-t" style="height: {{ ($count / max(max(array_values($charts['pendaftar'])), 1)) * 100 }}px;"></div>
                <div class="text-[#121c2a] text-[12px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">{{ $year }}</div>
                <div class="text-[10px] font-bold text-gray-500">{{ $count }}</div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Keterima Chart -->
        <div class="flex-1 bg-white border border-[#becabe] rounded-xl p-8 flex flex-col gap-8">
          <div class="text-[#121c2a] text-[20px] font-semibold" style="font-family: 'PlusJakartaSans-SemiBold', sans-serif;">Jumlah Keterima Per Tahun</div>
          <div class="border-b border-[#becabe] h-[200px] flex flex-row gap-3 items-end pb-6 w-full">
            @foreach($charts['keterima'] as $year => $count)
              <div class="flex flex-col gap-2 items-center">
                <div class="bg-[#064e3b] w-10 rounded-t" style="height: {{ ($count / max(max(array_values($charts['keterima'])), 1)) * 100 }}px;"></div>
                <div class="text-[#121c2a] text-[12px] font-medium" style="font-family: 'WorkSans-Medium', sans-serif;">{{ $year }}</div>
                <div class="text-[10px] font-bold text-gray-500">{{ $count }}</div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
