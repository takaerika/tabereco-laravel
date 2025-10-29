<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Meal $meal)
    {
        abort_unless(auth()->user()?->isSupporter(), 403);

        $validated = $request->validate([
            'body' => ['required','string','max:2000'],
        ]);

        Comment::create([
            'meal_id'      => $meal->id,
            'supporter_id' => auth()->id(),
            'body'         => $validated['body'],
        ]);

        return back()->with('success', 'コメントを投稿しました');
    }

    public function destroy(Meal $meal, Comment $comment)
    {
        abort_unless(auth()->user()?->isSupporter(), 403);
        abort_unless($comment->supporter_id === auth()->id(), 403); // 自分のものだけ削除

        $comment->delete();
        return back()->with('success', 'コメントを削除しました');
    }
}