<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EmailTemplate::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:email_templates,name',
            'subject' => 'required|string',
            'body' => 'required|string',
            'type' => 'nullable|string|in:user,admin',
        ]);

        $template = EmailTemplate::create($validated);

        return response()->json($template, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailTemplate $emailTemplate)
    {
        return $emailTemplate;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validated = $request->validate([
            'name' => 'string|unique:email_templates,name,' . $emailTemplate->id,
            'subject' => 'string',
            'body' => 'string',
            'type' => 'string|in:user,admin',
        ]);

        $emailTemplate->update($validated);

        return response()->json($emailTemplate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        return response()->json(null, 204);
    }
}
