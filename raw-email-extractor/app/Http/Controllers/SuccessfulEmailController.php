<?php

namespace App\Http\Controllers;

use App\Models\SuccessfulEmail;
use App\Helpers\EmailHelper;
use Illuminate\Http\Request;

class SuccessfulEmailController extends Controller
{
    public function storeEmail(Request $request)
    {
        $validatedData = $request->validate([
            'affiliate_id' => 'required|integer',
            'envelope' => 'required|string',
            'from' => 'required|string',
            'subject' => 'required|string',
            'email' => 'required|string',
            'sender_ip' => 'required|string',
            'to' => 'required|string',
        ]);

        $email = SuccessfulEmail::create($validatedData);

        $email->raw_text = EmailHelper::extractPlainText($email->email);
        $email->save();

        return response()->json($email, 201);
    }

    public function getEmailById($id)
    {
        $email = SuccessfulEmail::findOrFail($id);
        return response()->json($email);
    }

    public function updateEmail(Request $request, $id)
    {
        $request->validate([
            'affiliate_id' => 'required|integer',
            'envelope' => 'required|string',
            'from' => 'required|string',
            'subject' => 'required|string',
            'email' => 'required|string',
            'sender_ip' => 'required|string',
            'to' => 'required|string',
        ]);

        $email = SuccessfulEmail::findOrFail($id);
        $email->update($request->all());

        return response()->json($email);
    }

    public function getAllEmails(Request $request)
    {
        $emails = SuccessfulEmail::whereNull('raw_text');
        return response()->json($emails);
    }

    public function deleteEmailById($id)
    {
        $email = SuccessfulEmail::findOrFail($id);
        $email->delete();

        return response()->json(null, 204);
    }

    public function getCsrfToken()
    {
        $token = csrf_token();

        return response()->json(['csrf_token' => $token]);
    }
}
