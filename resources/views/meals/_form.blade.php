@php
    $types = ['breakfast'=>'朝食','lunch'=>'昼食','dinner'=>'夕食','snack'=>'間食'];
@endphp

<div class="space-y-4">
    <div>
        <label class="block text-sm">日付</label>
        <input type="date" name="ate_on" value="{{ old('ate_on', $meal->ate_on ?? now()->toDateString()) }}" class="border rounded w-full p-2">
        @error('ate_on') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm">区分</label>
        <select name="meal_type" class="border rounded w-full p-2">
            @foreach($types as $key=>$label)
                <option value="{{ $key }}" @selected(old('meal_type', $meal->meal_type ?? '')===$key)>{{ $label }}</option>
            @endforeach
        </select>
        @error('meal_type') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm">写真</label>
        <input type="file" name="photo" accept="image/*" class="border rounded w-full p-2">
        @error('photo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        @isset($meal->photo_path)
            <img src="{{ asset('storage/'.$meal->photo_path) }}" class="mt-2 h-24 object-cover rounded">
        @endisset
    </div>
    <div>
        <label class="block text-sm">メモ</label>
        <textarea name="note" rows="3" class="border rounded w-full p-2">{{ old('note', $meal->note ?? '') }}</textarea>
        @error('note') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <div class="flex items-center justify-between">
            <label class="text-sm">品目</label>
            <button type="button" id="addRow" class="px-2 py-1 rounded bg-gray-200">＋行追加</button>
        </div>
        <div id="items" class="mt-2 space-y-2">
            @php
                $oldItems = collect(old('items', isset($meal) ? $meal->items->map(fn($i)=>['name'=>$i->name,'quantity'=>$i->quantity])->all() : [['name'=>'','quantity'=>'']]));
            @endphp
            @foreach($oldItems as $i => $row)
                <div class="flex gap-2 item-row">
                    <input name="items[{{ $i }}][name]" placeholder="料理名" value="{{ $row['name'] ?? '' }}" class="border rounded w-1/2 p-2">
                    <input name="items[{{ $i }}][quantity]" placeholder="数量" value="{{ $row['quantity'] ?? '' }}" class="border rounded w-1/3 p-2">
                    <button type="button" class="removeRow px-2 py-1 rounded bg-red-100">✕</button>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const addBtn = document.getElementById('addRow');
  const wrap = document.getElementById('items');
  let index = wrap.querySelectorAll('.item-row').length;

  addBtn?.addEventListener('click', () => {
    const div = document.createElement('div');
    div.className = 'flex gap-2 item-row mt-2';
    div.innerHTML = `
      <input name="items[${index}][name]" placeholder="料理名" class="border rounded w-1/2 p-2">
      <input name="items[${index}][quantity]" placeholder="数量" class="border rounded w-1/3 p-2">
      <button type="button" class="removeRow px-2 py-1 rounded bg-red-100">✕</button>
    `;
    wrap.appendChild(div);
    index++;
  });

  wrap?.addEventListener('click', (e) => {
    if (e.target.classList.contains('removeRow')) {
      e.target.closest('.item-row').remove();
    }
  });
});
</script>
@endpush