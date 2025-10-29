<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SupportCalendarController extends Controller
{
    public function index(Request $request, User $user)
    {
        $month = Carbon::parse($request->get('month', now()->startOfMonth()->toDateString()));
        $start = $month->copy()->startOfMonth()->startOfWeek();
        $end   = $month->copy()->endOfMonth()->endOfWeek();

        $counts = Meal::where('user_id', $user->id)
            ->whereBetween('ate_on', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('ate_on, count(*) as cnt')
            ->groupBy('ate_on')
            ->pluck('cnt','ate_on');

        return view('calendar.index', compact('month','start','end','counts')); // 同じビューを再利用OK
    }

    public function day(User $user, string $date)
    {
        $meals = Meal::with('items')
            ->where('user_id', $user->id)
            ->whereDate('ate_on', $date)
            ->orderBy('created_at','desc')
            ->get();

        return view('calendar.day', compact('meals','date'));
    }
}
