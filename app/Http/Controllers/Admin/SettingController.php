<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Cache\Factory;
use App\Setting;
use App\Http\Controllers\Admin\Resource\isResource;

class SettingController
{
    use isResource;

    public function __construct(Setting $setting)
    {
        $this->resource = $setting;
    }

    public function index()
    {
        if ($setting = $this->resource->joinLocalization()->first()) {
            $this->resource = $setting;
        }

        $form = $this->getForm();
        return view('admin.resources.create-or-edit', compact('form'));
    }

    private function storeOrUpdate(Factory $cache)
    {
        $form = $this->getForm();
        $form->redirectIfNotValid();
        $this->resource->storeOrUpdate();
        $cache->forget('settings');

        return redirect(action([get_class($this), 'index']));
    }
}
