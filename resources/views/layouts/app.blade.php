@extends('layouts/common')

@section('layoutContent')
    <div class="w-full lg:ps-[260px]">
        @include('layouts/sections/cintillo')
    </div>
    @include('layouts/sections/navbar/navbar')
    @include('layouts/sections/sidebar/sidebar')
    <div class="w-full lg:ps-[260px]">
        <main class="min-h-[calc(100vh-177px)]">
            @yield('content')
        </main>
        @include('layouts/sections/footer')
    </div>
@endsection
