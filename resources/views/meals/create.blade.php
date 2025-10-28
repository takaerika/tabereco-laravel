<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">新規作成</h2></x-slot>
    <form method="post" action="{{ route('meals.store') }}" enctype="multipart/form-data" class="p-6 space-y-4">
        @csrf
        @include('meals._form')
        <div class="flex gap-3">
            <a href="{{ route('meals.index') }}" class="px-3 py-2 rounded bg-gray-200">戻る</a>
            <button class="px-3 py-2 rounded bg-blue-600 text-white">保存</button>
        </div>
    </form>
    @stack('scripts')
</x-app-layout>