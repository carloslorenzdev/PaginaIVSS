<div class="p-5">
    <x-card.title>
        <i class='bx bx-log-in-circle'></i>
        Accesos
    </x-card.title>
    <x-card.subtitle>
        Últimos ingresos al sistema.
    </x-card.subtitle>
    <div class="flex flex-col mt-5">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                    IP
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                    Ingreso
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">
                                    Salida
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                            @forelse ($accesos as $acceso)
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                                        {{ $acceso->ip }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                        <x-tooltip titulo="{{ $acceso->formatoNormal('login') }}">
                                            {{ $acceso->fechaHumanos('login') ?: '-' }}
                                        </x-tooltip>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                        <x-tooltip titulo="{{ $acceso->formatoNormal('logout') }}">
                                            {{ $acceso->fechaHumanos('logout') ?: '-' }}
                                        </x-tooltip>
                                    </td>
                                </tr>
                            @empty
                                <x-table.empty colspan="3" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
