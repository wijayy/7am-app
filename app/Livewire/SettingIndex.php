<?php

namespace App\Livewire;

use App\Models\SetCategory;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Session;

class SettingIndex extends Component
{

    public $title = "Our Configuration", $set_categories, $state;

    public function rules()
    {
        return [
            'state' => "required|array",
            'state.*' => 'nullable',
        ];
    }

    #[Validate('required')]
    public $default_set_category = '';

    public function mount()
    {
        $this->set_categories = SetCategory::all();
        $this->default_set_category = Setting::where('key', 'default_set_category')->value('value');

        $settings = Setting::whereNot('key', 'default_set_category')->get(['key', 'value', 'type']);

        foreach ($settings as $setting) {
            $this->state['settings'][$setting->key] = [
                'key' => $setting->key,
                'value' => $setting->value,
                'type' => $setting->type,
            ];
        }
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();
            Setting::where('key', 'default_set_category')->update(['value' => $this->default_set_category]);

            foreach ($this->state['settings'] as $key => $item) {
                Setting::updateOrCreate(
                    ['key' => $item['key']],
                    [
                        'value' => $item['value'],
                        'type' => $item['type'] ?? 'text',
                    ]
                );
            }
            DB::commit();
            Session::flash('success', 'Configuration Updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false)) throw $th;
            return back()->with('error', '');
        }
    }

    public function render()
    {
        return view('livewire.setting-index')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
