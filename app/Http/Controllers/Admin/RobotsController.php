<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Robots\Forms\RobotsForm;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Http\Controllers\Admin\Roles\Forms\RoleForm;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use Route;
use Validator;
use Session;

class RobotsController extends Controller
{
    public function index(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(RobotsForm::class, [

        ]);

        return view('admin.resources.create-or-edit', compact('form'));
    }

    public function store(Request $request)
    {
        $content = $request->input('content');
        file_put_contents(public_path('robots.txt'), $content);

        return redirect(action([get_class($this), 'index']));
    }
}
