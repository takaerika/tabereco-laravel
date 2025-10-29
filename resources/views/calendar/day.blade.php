<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl">{{ $date }} の記録</h2></x-slot>
  <div class="p-6 space-y-4">
    <a href="{{ route('calendar.index',['month'=>\Carbon\Carbon::parse($date)->startOfMonth()->toDateString()]) }}" class="underline">← カレンダーへ</a>

    @forelse($meals as $meal)
      <div class="border rounded p-4">
        <div class="text-sm text-gray-500">{{ $meal->ate_on }} / {{ $meal->meal_type }}</div>
        <div class="mt-2">{{ $meal->note }}</div>
        <div class="mt-2 text-sm text-gray-600">
          品目: {{ $meal->items->pluck('name')->filter()->implode('、') ?: '—' }}
        </div>
        <div class="mt-3"><a href="{{ route('meals.show',$meal) }}" class="underline">詳細</a></div>
      </div>
    @empty
      <p>記録はありません。</p>
    @endforelse
  </div>
</x-app-layout>