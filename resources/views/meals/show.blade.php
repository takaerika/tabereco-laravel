<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">食事詳細</h2></x-slot>
    <div class="p-6 space-y-3">
        <div>{{ $meal->ate_on }} / {{ $meal->meal_type }}</div>
        <div>{{ $meal->note }}</div>
        @if($meal->photo_path)
            <img src="{{ asset('storage/'.$meal->photo_path) }}" class="h-40 object-cover rounded">
        @endif

        <div>
            <h3 class="font-semibold">品目</h3>
            <ul class="list-disc pl-6">
                @foreach($meal->items as $i)
                    <li>{{ $i->name }} <span class="text-gray-500">{{ $i->quantity }}</span></li>
                @endforeach
            </ul>
        </div>

        <div class="flex gap-3 mt-4">
            <a href="{{ route('meals.edit',$meal) }}" class="px-3 py-2 rounded bg-yellow-500 text-white">編集</a>
            <form method="post" action="{{ route('meals.destroy',$meal) }}" onsubmit="return confirm('削除しますか？')">
                @csrf @method('DELETE')
                <button class="px-3 py-2 rounded bg-red-600 text-white">削除</button>
            </form>
            <a href="{{ route('meals.index') }}" class="px-3 py-2 rounded bg-gray-200">一覧へ</a>
        </div>
    </div>
</x-app-layout>