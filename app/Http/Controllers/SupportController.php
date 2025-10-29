<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function meals(User $user)
    {
        abort_unless(auth()->user()->isSupporter(), 403);
        $meals = Meal::with('items')
            ->where('user_id', $user->id)
            ->orderByDesc('ate_on')
            ->paginate(20);

        return view('support.meals.index', compact('user','meals'));
    }
}