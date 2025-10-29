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
  <hr class="my-6">

<h3 class="font-semibold">コメント</h3>

<div class="space-y-3 mt-3">
  @forelse($meal->comments()->latest()->get() as $c)
    <div class="border rounded p-3">
      <div class="text-xs text-gray-500">
        {{ $c->created_at->format('Y/m/d H:i') }} / by {{ $c->supporter->name }}
      </div>
      <div class="mt-1 whitespace-pre-line">{{ $c->body }}</div>

      @if(auth()->user()?->isSupporter() && auth()->id() === $c->supporter_id)
        <form method="post" action="{{ route('meals.comments.destroy', [$meal, $c]) }}"
              onsubmit="return confirm('削除しますか？')" class="mt-2">
          @csrf @method('DELETE')
          <button class="px-2 py-1 rounded bg-red-100">削除</button>
        </form>
      @endif
    </div>
  @empty
    <p class="text-gray-500">まだコメントはありません。</p>
  @endforelse
</div>

@if(auth()->user()?->isSupporter())
  <form method="post" action="{{ route('meals.comments.store', $meal) }}" class="mt-4 space-y-2">
    @csrf
    <textarea name="body" rows="3" class="border rounded w-full p-2"
              placeholder="フィードバックを入力">{{ old('body') }}</textarea>
    @error('body') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    <button class="px-3 py-2 rounded bg-blue-600 text-white">コメント投稿</button>
  </form>
@endif
</x-app-layout>