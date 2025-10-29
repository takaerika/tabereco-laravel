<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">編集</h2></x-slot>
    <form method="post" action="{{ route('meals.update',$meal) }}" enctype="multipart/form-data" class="p-6 space-y-4">
        @csrf @method('PUT')
        @include('meals._form', ['meal' => $meal])
        <div class="flex gap-3">
            <a href="{{ route('meals.show',$meal) }}" class="px-3 py-2 rounded bg-gray-200">キャンセル</a>
            <button class="px-3 py-2 rounded bg-blue-600 text-white">更新</button>
        </div>
    </form>
    @stack('scripts')
</x-app-layout>