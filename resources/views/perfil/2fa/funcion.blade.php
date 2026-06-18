<div class="space-y-3">
    <h3 class="text-2xl">¿Cómo funciona?</h3>
    <p class="text-base text-gray-800 dark:text-neutral-200">
        Consta de tres fases: <x-badge>Primer Factor</x-badge>, <x-badge>Segundo Factor</x-badge> y
        <x-badge>Verificación</x-badge>.
    </p>
    <div class="flex flex-col md:flex-row gap-5 mt-3">
        <div class="w-full flex justify-center items-center">
            <x-card class="size-50 lg:size-60 p-3 dark:!bg-gray-200">
                <x-ilustraciones.otp-female />
            </x-card>
        </div>
        <div>
            <div class="group relative flex gap-x-5">
                <div
                    class="relative group-last:after:hidden after:absolute after:top-8 after:bottom-2 after:start-3 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
                    <div class="relative z-10 size-6 flex justify-center items-center">
                        <x-badge color="sky" class="!font-bold">1</x-badge>
                    </div>
                </div>
                <div class="grow pb-8 group-last:pb-0">
                    <h3 class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                        Primer Factor
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                        Este es la contraseña que el usuario ingresa para acceder a la cuenta.
                    </p>
                </div>
            </div>
            <div class="group relative flex gap-x-5">
                <div
                    class="relative group-last:after:hidden after:absolute after:top-8 after:bottom-2 after:start-3 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
                    <div class="relative z-10 size-6 flex justify-center items-center">
                        <x-badge color="sky" class="!font-bold">2</x-badge>
                    </div>
                </div>
                <div class="grow pb-8 group-last:pb-0">
                    <h3 class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                        Segundo Factor
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                        Eeste puede ser un <strong>código de verificación temporal</strong> enviado al
                        teléfono móvil vía SMS o una aplicación de autenticación que genera estos códigos. También puede
                        ser una
                        <strong>característica biométrica</strong> del usuario como la huella digital o reconocimiento
                        facial.
                    </p>
                </div>
            </div>
            <div class="group relative flex gap-x-5">
                <div
                    class="relative group-last:after:hidden after:absolute after:top-8 after:bottom-2 after:start-3 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
                    <div class="relative z-10 size-6 flex justify-center items-center">
                        <x-badge color="sky" class="!font-bold">2</x-badge>
                    </div>
                </div>
                <div class="grow pb-8 group-last:pb-0">
                    <h3 class="font-semibold text-sm text-gray-800 dark:text-neutral-200">
                        Segundo Factor
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">
                        El sistema verifica ambos factores para confirmar la identidad del usuario y conceder el acceso.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
