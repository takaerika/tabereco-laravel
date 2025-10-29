<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index(Request $request)
    {
        $meals = Meal::with('items')
            ->where('user_id', auth()->id())
            ->whereBetween('ate_on', [now()->subDays(6)->toDateString(), now()->toDateString()])
            ->orderByDesc('ate_on')
            ->paginate(10);

        return view('meals.index', compact('meals'));
    }

    public function create()
    {
        return view('meals.create');
    }

    public function store(StoreMealRequest $request)
    {
        $meal = Meal::create([
            'user_id'   => auth()->id(),
            'ate_on'    => $request->ate_on,
            'meal_type' => $request->meal_type,
            'note'      => $request->note,
            'photo_path'=> $request->file('photo')?->store('meals','public'),
        ]);

        foreach ($request->items ?? [] as $row) {
            if (!empty($row['name'])) {
                $meal->items()->create([
                    'name' => $row['name'],
                    'quantity' => $row['quantity'] ?? null,
                ]);
            }
        }

        return redirect()->route('meals.show', $meal)->with('success','作成しました');
    }

    public function show(Meal $meal)
    {
        abort_if($meal->user_id !== auth()->id(), 403);
        $meal->load('items');
        return view('meals.show', compact('meal'));
    }

    public function edit(Meal $meal)
    {
        abort_if($meal->user_id !== auth()->id(), 403);
        $meal->load('items');
        return view('meals.edit', compact('meal'));
    }

    public function update(UpdateMealRequest $request, Meal $meal)
    {
        abort_if($meal->user_id !== auth()->id(), 403);

        $meal->update([
            'ate_on'    => $request->ate_on,
            'meal_type' => $request->meal_type,
            'note'      => $request->note,
        ]);

        if ($request->hasFile('photo')) {
            $meal->update(['photo_path' => $request->file('photo')->store('meals','public')]);
        }

        $meal->items()->delete();
        foreach ($request->items ?? [] as $row) {
            if (!empty($row['name'])) {
                $meal->items()->create([
                    'name' => $row['name'],
                    'quantity' => $row['quantity'] ?? null,
                ]);
            }
        }

        return redirect()->route('meals.show', $meal)->with('success','更新しました');
    }

    public function destroy(Meal $meal)
    {
        abort_if($meal->user_id !== auth()->id(), 403);
        $meal->delete();
        return redirect()->route('meals.index')->with('success','削除しました');
    }
}