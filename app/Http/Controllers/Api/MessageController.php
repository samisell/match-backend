<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return Message::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_read' => 'boolean',
            'sent_at' => 'date',
        ]);

        $message = Message::create($request->all());

        return $message;
    }

    public function show(Message $message)
    {
        return $message;
    }

    public function update(Request $request, Message $message)
    {
        $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'is_read' => 'boolean',
        ]);

        $message->update($request->all());

        return $message;
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return response()->json(null, 204);
    }
}