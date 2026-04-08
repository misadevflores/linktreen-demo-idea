<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $store->name }} - {{ $store->slug }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/24/outline/index.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .fade-in { animation: fadeIn 0.8s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1); }
        .gradient-theme { background: linear-gradient(135deg, {{ $store->color_tema }}20 0%, {{ $store->color_tema }}40 100%); }
    </style>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { primary: '{{ $store->color_tema }}' } } }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto fade-in" x-data="{ showQR: false }">
        {{-- Header --}}
        <div class="text-center mb-16">
            <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden shadow-2xl ring-4 ring-white/50">
                <img src="{{ $store->logo ?: 'https://ui-avatars.com/api/?name=' . urlencode($store->name) . '&size=128&background=3B82F6&color=fff' }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-2">
                {{ $store->name }}
                <span class="text-sm ml-2 text-emerald-500">✓ Verificado</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-md mx-auto">{{ $store->whatsapp ?? 'Tienda premium en Lintreenk' }}</p>
        </div>

        {{-- Links --}}
        <div class="space-y-4 mb-20">
            @foreach ($store->links->sortBy('orden') as $link)
                <a href="{{ $link->path_o_url }}" 
                   target="_blank" 
                   class="block p-8 rounded-3xl gradient-theme border border-white/50 hover-lift text-left shadow-xl backdrop-blur-sm bg-white/80">
                    <div class="flex items-center space-x-4">
                        @if($link->tipo === 'url')
                            <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center text-white shadow-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </div>
                        @elseif($link->tipo === 'pdf')
                            <div class="w-12 h-12 bg-red-500 rounded-2xl flex items-center justify-center text-white shadow-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center text-white shadow-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $link->titulo }}</h3>
                            <p class="text-sm text-gray-500">Abrir en nueva pestaña</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Products Grid --}}
        @if($store->products->count())
        <section class="mb-20">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">Productos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($store->products as $product)
                    <div class="group bg-white rounded-3xl p-6 shadow-xl hover-lift border border-gray-100 overflow-hidden">
                        <div class="w-full h-48 rounded-2xl overflow-hidden mb-4 bg-gray-100 group-hover:scale-105 transition-transform duration-300">
                            <img src="{{ $product->imagen ? Storage::url(str_replace('storage/app/public/', '', $product->imagen)) : 'https://ui-avatars.com/api/?name=' . urlencode($product->nombre) . '&size=256&background=f3f4f6&color=374151' }}" 
                                 alt="{{ $product->nombre }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-semibold text-xl mb-2 text-gray-900 leading-tight">{{ $product->nombre }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->descripcion }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-primary">Bs. {{ number_format($product->precio_bs, 2) }}</span>
                            <a href="https://wa.me/{{ $store->whatsapp }}?text=Hola! Quiero pedir: {{ urlencode($product->nombre) }} - Precio: Bs. {{ $product->precio_bs }}" 
                               target="_blank" 
                               class="px-6 py-3 bg-primary/90 hover:bg-primary text-white rounded-2xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1 whitespace-nowrap">
                                Pedir ahora
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- QR Payment Button & Modal --}}
        @if($store->qr_pago_simple)
        <button @click="showQR = true" 
                class="fixed bottom-8 right-8 w-16 h-16 bg-gradient-to-r from-primary to-primary/80 text-white rounded-full shadow-2xl hover:scale-110 transition-all duration-300 flex items-center justify-center text-2xl z-50 hover:shadow-3xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </button>

        {{-- Modal --}}
        <div x-show="showQR" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4" 
             @click.away="showQR = false">
            <div class="bg-white rounded-3xl p-8 max-w-md w-full max-h-[90vh] overflow-y-auto shadow-2xl fade-in">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Pagar con QR</h3>
                    <button @click="showQR = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex flex-col items-center space-y-4">
                    <div class="w-48 h-48 rounded-2xl overflow-hidden shadow-xl border-4 border-primary/20">
                        <img src="{{ Storage::url(str_replace('storage/app/public/', '', $store->qr_pago_simple)) }}" alt="QR Pago Simple" class="w-full h-full object-contain">
                    </div>
                    <p class="text-center text-gray-600 text-sm">Escanea para pagar fácilmente</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
</html>

