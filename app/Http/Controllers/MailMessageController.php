<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MailMessage;

class MailMessageController extends Controller
{
    public function index()
    {
        $mail_messages = MailMessage::orderBy('id', 'desc')->paginate(50);
        return view('mail.mail_message', compact('mail_messages'));
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,sent,failed',
        ]);

        $mailMessage = MailMessage::findOrFail($id);
        $mailMessage->update(['status' => $request->status]);

        return response()->json(['message' => 'Status updated successfully!', 'data' => $mailMessage]);
    }

    public function destroy($id)
    {
        $message = MailMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('mail-messages.index')->with('success', 'Mail message deleted successfully!');
    }
}
