<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
  @include('partials.head')
</head>

<body class="min-h-screen antialiased">
  {{-- Background Pattern untuk Tema ISBN --}}
  <div
    class="fixed inset-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-950 dark:via-blue-950 dark:to-indigo-950">
    {{-- Animated Book Pattern --}}
    <div class="absolute inset-0 opacity-5 dark:opacity-10">
      <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <pattern id="book-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
            {{-- Book Icon Pattern --}}
            <path d="M20 10L30 10L30 40L20 40ZM32 10L42 10L42 40L32 40Z" fill="currentColor" opacity="0.3" />
            <path d="M60 30L70 30L70 60L60 60ZM72 30L82 30L82 60L72 60Z" fill="currentColor" opacity="0.2" />
          </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#book-pattern)" class="text-blue-600 dark:text-blue-400" />
      </svg>
    </div>

    {{-- Gradient Overlay --}}
    <div
      class="absolute inset-0 bg-gradient-to-t from-white/80 via-transparent to-white/50 dark:from-gray-950/80 dark:via-transparent dark:to-gray-950/50">
    </div>
  </div>

  {{-- Content --}}
  <div class="relative flex min-h-screen flex-col items-center justify-center gap-6 p-6 md:p-10">
    <div class="flex w-full max-w-lg flex-col gap-2">
      {{-- Logo dengan Efek Glow --}}
      <img src="/unsap-1.png" alt="Logo Universitas Sebelas April" class="mx-auto mb-4 w-32 h-auto" />

      <div class="flex flex-col gap-6 mt-4">
        {{ $slot }}
      </div>
    </div>

    {{-- Copyright Footer --}}
    <div class="absolute bottom-6 text-center text-xs text-gray-500 dark:text-gray-400">
      <p>&copy; {{ date('Y') }} Universitas Sebelas April. All rights reserved.</p>
    </div>
  </div>
  @fluxScripts
</body>

</html>