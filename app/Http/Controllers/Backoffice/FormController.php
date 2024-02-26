<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\Form\UpdateFormRequest;
use App\Models\Form;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function edit(Form $form)
    {
        return view('backoffice.forms.editForm', compact('form'));
    }
}
