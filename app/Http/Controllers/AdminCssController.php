<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminCssController extends Controller
{
    private string $filePath;

    public function __construct()
    {
        $this->filePath = public_path('css/admin.css');

        if (!file_exists($this->filePath)) {
            touch($this->filePath);
        }
    }

    public function render()
    {
        $content = file_get_contents($this->filePath);

        return view('backoffice.adminCss', compact('content'));
    }

    public function update(Request $request): RedirectResponse
    {
        file_put_contents($this->filePath, $request->get('content'));

        return redirect()->back()->with('success', 'Admin.css updated !');
    }
}
