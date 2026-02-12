<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = EmailTemplate::all();
        return view('admin.email_templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.email_templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:email_templates,name|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|string|in:user,admin',
        ]);

        EmailTemplate::create($validatedData);

        Log::info('Email template created: ' . $validatedData['name']);

        return redirect()->route('admin.email_templates.index')->with('success', 'Email template created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailTemplate $emailTemplate)
    {
        return view('admin.email_templates.show', compact('emailTemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email_templates.edit', compact('emailTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:email_templates,name,' . $emailTemplate->id,
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|string|in:user,admin',
        ]);

        $emailTemplate->update($validatedData);

        Log::info('Email template updated: ' . $emailTemplate->name);

        return redirect()->route('admin.email_templates.index')->with('success', 'Email template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        Log::info('Email template deleted: ' . $emailTemplate->name);

        return redirect()->route('admin.email_templates.index')->with('success', 'Email template deleted successfully.');
    }
}