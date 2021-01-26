<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Cache\Factory;
use App\Setting;
use App\Http\Controllers\Admin\Resource\isResource;

class SettingController
{
    use isResource;

    protected $cache;

    public function __construct(Setting $setting, Factory $cache)
    {
        $this->resource = $setting;
        $this->cache = $cache;
    }

    public function index()
    {
        if ($setting = $this->resource->joinLocalization()->first()) {
            $this->resource = $setting;
        }

        $form = $this->getForm();
        return view('admin.resources.create-or-edit', compact('form'));
    }

    private function storeOrUpdate()
    {
        $form = $this->getForm();
        $form->redirectIfNotValid();
        $this->resource->storeOrUpdate();
        $this->cache->forget('settings');

        return redirect(action([get_class($this), 'index']));
    }
}
