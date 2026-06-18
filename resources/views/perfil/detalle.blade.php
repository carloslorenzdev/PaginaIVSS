@extends('layouts/app')

@section('titulo', 'Perfil')

@section('content')
    <x-section class="space-y-4 p-4 sm:space-y-6 sm:p-6">
        <x-titulo titulo="Mi Perfil" />
        <x-card>
            <div class="h-[180px]">
                <figure>
                    <svg class="w-full" preserveAspectRatio="none" width="1113" height="161" viewBox="0 0 1113 161"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_666_220723)">
                            <rect x="0.5" width="1112" height="161" rx="12" fill="white"></rect>
                            <rect x="1" width="1112" height="348" fill="#D9DEEA"></rect>
                            <path
                                d="M512.694 359.31C547.444 172.086 469.835 34.2204 426.688 -11.3096H1144.27V359.31H512.694Z"
                                fill="#C0CBDD"></path>
                            <path
                                d="M818.885 185.745C703.515 143.985 709.036 24.7949 726.218 -29.5801H1118.31V331.905C1024.49 260.565 963.098 237.945 818.885 185.745Z"
                                fill="#8192B0"></path>
                            <defs>
                                <clipPath id="clip0_666_220723">
                                    <rect x="0.5" width="1112" height="161" rx="12" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </g>
                    </svg>
                </figure>
            </div>
            <div class="-mt-24 pb-5">
                <div class="flex justify-center">
                    <div
                        class="size-32 flex items-center justify-center border-8 border-white dark:border-neutral-900 bg-blue-200 rounded-full">
                        <p class="text-[3rem] text-center font-bold text-gray-800 select-none">
                            {{ $user->iniciales }}
                        </p>
                    </div>
                </div>
                <div class="text-center">
                    <h1 class="text-2xl font-bold dark:text-white">
                        {{ $user->nombre }}
                    </h1>
                    <p class="text-gray-500 dark:text-neutral-500">
                        {{ $user->usuario }}
                    </p>
                </div>
            </div>
        </x-card>
        <x-card>
            @include('perfil/detalle/info')
        </x-card>
        @includeWhen($user->entidad->isFuncionario(), 'perfil/detalle/funcionario', [
            'entidad' => $user->entidad->entidadtable,
        ])
        @includeWhen($user->entidad->isPatrono(), 'perfil/detalle/empresa', [
            'entidad' => $user->entidad->entidadtable,
        ])
        <div class="grid grid-cols-1 md:grid-cols-2 gap-1 md:gap-7">
            <x-card>
                @include('perfil/detalle/form-password')
            </x-card>
            <x-card>
                @include('perfil/detalle/ultimos-accesos')
            </x-card>
            <x-card class="p-5">
                @include('perfil/detalle/lista-2fa')
            </x-card>
        </div>
    </x-section>
@endsection
