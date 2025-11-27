<?php

namespace App\Livewire;

use App\Models\Bussiness;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class BussinessInfo extends Component
{
    use WithFileUploads;

    public $preview;


    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $address = '';

    #[Validate('required|min:15')]
    public $npwp = '';

    #[Validate('required|uppercase')]
    public $bank = '';

    #[Validate('required')]
    public $account_number = '', $account_name = '';

    #[Validate('required')]
    public $representative = '';

    #[Validate('required|doesnt_start_with:0')]
    public $phone = '';

    #[Validate('required|file|image')]
    public $id_card = '';

    public function save()
    {
        $validated = $this->validate();
        try {
            $validated['user_id'] = Auth::user()->id;

            DB::beginTransaction();

            $validated['id_card'] = $this->id_card->store('id');

            Auth::user()->update(['business' => 'requested']);

            $business = Bussiness::create($validated);
            DB::commit();
            Mail::to(Auth::user()->email)->send(new \App\Mail\Request_User(Auth::user()->id));

            foreach (User::where('role', 'sales-admin')->get() as $key => $item) {
                Mail::to($item->email)->send(new \App\Mail\Request_Admin(Auth::user()->id));
            }

            Session::flash('success', 'Thank you for submitting your business registration. Your request has been received and is currently under review. Please wait up to 24 hours for further confirmation.');
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->bussinesses?->name ?? null;
        $this->npwp = $user->bussinesses?->npwp ?? null;
        $this->address = $user->bussinesses?->address ?? null;
        $this->bank = $user->bussinesses?->bank ?? null;
        $this->account_number = $user->bussinesses?->account_number ?? null;
        $this->account_name = $user->bussinesses?->account_name ?? null;
        $this->preview = $user->bussinesses?->id_card ?? null;
        $this->representative = $user->bussinesses?->representative ?? null;
        $this->phone = $user->bussinesses?->phone ?? null;
    }


    public function render()
    {
        return view('livewire.bussiness-info')->layout('components.layouts.app.header', ['title' => "Bussiness Info"]);
    }
}
