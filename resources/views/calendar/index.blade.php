<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl">カレンダー</h2></x-slot>

  <div class="p-6 space-y-4">
    <div class="flex items-center justify-between">
      <a href="{{ route('calendar.index',['month'=>$month->copy()->subMonth()->toDateString()]) }}" class="underline">← 前月</a>
      <div class="text-lg font-semibold">{{ $month->format('Y年n月') }}</div>
      <a href="{{ route('calendar.index',['month'=>$month->copy()->addMonth()->toDateString()]) }}" class="underline">翌月 →</a>
    </div>

    @php
      $cursor = $start->copy();
    @endphp

    <div class="grid grid-cols-7 gap-2">
      @foreach (['日','月','火','水','木','金','土'] as $w)
        <div class="text-center text-sm text-gray-500">{{ $w }}</div>
      @endforeach

      @while($cursor <= $end)
        @php
          $dateStr = $cursor->toDateString();
          $inMonth = $cursor->month === $month->month;
          $count = $counts[$dateStr] ?? 0;
        @endphp
        <a href="{{ route('calendar.day',$dateStr) }}"
           class="border rounded p-3 h-24 flex flex-col justify-between {{ $inMonth ? '' : 'bg-gray-50 text-gray-400' }}">
          <div class="text-right text-sm">{{ $cursor->day }}</div>
          <div class="text-xs {{ $count ? 'text-blue-600' : 'text-gray-400' }}">
            {{ $count ? "記録 {$count} 件" : '—' }}
          </div>
        </a>
        @php $cursor->addDay(); @endphp
      @endwhile
    </div>
  </div>
</x-app-layout>