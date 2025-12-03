<?php

namespace App\Livewire;

// use Livewire\Attributes\Rule;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AdminCreate extends Component
{

    public $title = "", $email, $password, $id, $outlets = [], $phone, $roles = ['admin', 'sales-admin', 'outlet-admin'];

    #[Validate('required')]
    public $name = '', $role;

    #[Validate('nullable')]
    public $outlet_id;

    public function rules()
    {
        // Jika sedang edit, misalnya ada properti $userId
        $userId = $this->id ?? null;

        return [
            'email' => [
                'required',
                'email',
                // Email harus unik, tapi abaikan user yang sedang diedit
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'phone' => [
                'required',
                'string',
                'doesnt_start_with:0',
                // Email harus unik, tapi abaikan user yang sedang diedit
                Rule::unique('users', 'phone')->ignore($userId),
            ],

            'password' => [
                // Saat create: wajib diisi
                // Saat edit: hanya diisi jika user mau mengganti password
                $userId ? 'nullable' : 'required',
                'string',
                'min:8',
            ],
        ];
    }

    public function messages()
    {
        return [
            'phone.doesnt_start_with' => "Phone number must start with a country code"
        ];
    }

    #[On('createModal')]
    public function openCreateModal()
    {
        // dd('sadfas');
        $this->resetValidation();

        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->outlet_id = null;
        $this->role = null;
        $this->id = null;
        $this->outlets = Outlet::where('is_active', true)->get();
        $this->title = "Add New Admin";

        $this->dispatch('modal-show', name: 'admin-create');
    }

    #[On('editModal')]
    public function openEditModal($id)
    {
        $this->resetValidation();

        $admin = User::where('id', $id)->first();

        if (!$admin) {
            return;
        }
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->password = '';
        $this->phone = $admin->phone;
        $this->outlet_id = $admin->outlet_id;
        $this->role = $admin->role;
        $this->id = $admin->id;
        $this->outlets = Outlet::where('is_active', true)->get();
        $this->title = "Edit Admin $this->name";

        $this->dispatch('modal-show', name: 'admin-create');
    }

    public function save()
    {
        $validated = $this->validate();
        try {
            DB::beginTransaction();
            if (!$this->id) {
                $admin = User::create($validated);
                event(new Registered($admin));
            } else {
                $user = User::where('id', $this->id)->first();
                // $admin->update($validated);
                $user->fill($validated);

                if ($user->isDirty('email')) {
                    $user->email_verified_at = null;
                }

                $user->save();
            }
            DB::commit();
            session()->flash('success', $this->id ? 'Admin updated successfully!' : 'Admin created successfully!');
            $this->dispatch('updateAdmins');
            $this->dispatch('modal-close', name: 'admin-create');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false)) throw $th;
            return back()->with('error', '');
        }
    }


    public function render()
    {
        return view('livewire.admin-create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
