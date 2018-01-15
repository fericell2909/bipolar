<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\HomePost;
use Illuminate\Http\Request;

class HomePostController extends Controller
{
    public function order(Request $request)
    {
        $this->validate($request, ['newOrder' => 'required|array']);

        $newOrder = $request->input('newOrder');

        foreach ($newOrder as $orderKey => $homePostHashId) {
            $homePost = HomePost::findByHash($homePostHashId);
            $homePost->order = $orderKey;
            $homePost->save();
        }

        return response()->json(['success' => true]);
    }
}