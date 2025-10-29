<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = Carbon::parse($request->get('month', now()->startOfMonth()->toDateString()));
        $start = $month->copy()->startOfMonth()->startOfWeek(); // 月表示の先頭（週の頭）
        $end   = $month->copy()->endOfMonth()->endOfWeek();

        $counts = Meal::where('user_id', auth()->id())
            ->whereBetween('ate_on', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('ate_on, count(*) as cnt')
            ->groupBy('ate_on')
            ->pluck('cnt','ate_on'); 

        return view('calendar.index', compact('month','start','end','counts'));
    }

    public function day(string $date)
    {
        $meals = Meal::with('items')
            ->where('user_id', auth()->id())
            ->whereDate('ate_on', $date)
            ->orderBy('created_at','desc')
            ->get();

        return view('calendar.day', compact('meals','date'));
    }
}