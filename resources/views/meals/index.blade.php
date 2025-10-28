<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">直近7日の食事</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('meals.create') }}" class="px-3 py-2 rounded bg-blue-600 text-white">＋新規作成</a>

        @if (session('success'))
            <div class="mt-4 p-3 bg-green-100 border">{{ session('success') }}</div>
        @endif

        <div class="mt-6 space-y-4">
            @forelse ($meals as $meal)
                <div class="border rounded p-4">
                    <div class="text-sm text-gray-500">{{ $meal->ate_on }} / {{ $meal->meal_type }}</div>
                    <div class="mt-2">{{ Str::limit($meal->note, 120) }}</div>
                    <div class="mt-2 text-sm text-gray-600">
                        品目: {{ $meal->items->pluck('name')->filter()->implode('、') ?: '—' }}
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('meals.show',$meal) }}" class="underline">詳細を見る</a>
                    </div>
                </div>
            @empty
                <p>記録がありません。</p>
            @endforelse
        </div>

        <div class="mt-6">{{ $meals->links() }}</div>
    </div>
</x-app-layout>