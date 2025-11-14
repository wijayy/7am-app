<?php

namespace App\Livewire;

use App\Models\Outlet;
use App\Models\OutletImage;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class OutletCreate extends Component
{
    use WithFileUploads;

    public $title = "", $image, $preview, $sections = [], $images = [], $id, $delete_images = [];

    #[Validate('required')]
    public $name = '', $address = '', $description = '', $start_time, $end_time;

    #[Validate('required|url')]
    public $link_grab = '', $link_gojek;

    protected function rules()
    {
        // $this->images[] = ['image' => null];
        return [
            'image' => [$this->id ? 'nullable' : 'required', 'image', 'max:2048'],
        ];
    }

    public function addImage()
    {
        $this->images[] = ['image' => null, 'id' => null, 'temp_id' => uniqid('img_'),];
    }

    public function addSection()
    {
        $this->sections[] = ['name' => null, 'id' => null];
    }

    public function deleteImage($index)
    {
        // dd($this->images[$index]);
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function deleteSection($index)
    {
        unset($this->sections[$index]);
        $this->sections = array_values($this->sections);
    }

    public function mount($slug = null)
    {
        if ($slug) {
            $outlet = Outlet::where('slug', $slug)->first();

            // $this->resetValidation();
            $this->id = $outlet->id;
            $this->name = $outlet->name;
            $this->address = $outlet->address;
            $this->description = $outlet->description;
            $this->link_grab = $outlet->link_grab;
            $this->link_gojek = $outlet->link_gojek;
            $this->preview = $outlet->image;
            $this->start_time = $outlet->start_time ? \Carbon\Carbon::parse($outlet->start_time)->format('H:i') : '';
            $this->end_time = $outlet->end_time ? \Carbon\Carbon::parse($outlet->end_time)->format('H:i') : '';

            $this->title = "Edit Outlet $this->name";

            $this->sections = $outlet->sections()->get(['name', 'id'])->toArray();
            $this->images = $outlet->images()->get(['image', 'id'])->toArray();
        } else {

            $this->id = null;
            $this->name = '';
            $this->address = '';
            $this->description = '';
            $this->link_grab = '';
            $this->link_gojek = '';
            $this->start_time = null;
            $this->end_time = null;
            $this->sections = [];
            $this->images = [];
            $this->preview = null;

            $this->addSection();
            $this->addImage();

            $this->title = "Add New Outlet";
        }

        // dd($this->images);
    }

    public function save()
    {
        $validated = $this->validate();

        // dd(collect($this->sections)->pluck('id'));

        try {
            DB::beginTransaction();
            if ($this->image) {
                // Hapus file lama jika ada (saat edit)

                $this->delete_images[] = $this->preview;

                // Buat instance manager dengan driver GD
                $manager = new ImageManager(Driver::class);

                // Baca file dan kompres
                $image = $manager->read($this->image->getRealPath())->toJpeg(70);

                // dd($image);

                // Simpan file yang sudah dikompres
                $image_path = 'outlet/' . time() . '.jpg';
                Storage::disk('public')->put($image_path, (string) $image);
            } else {
                $image_path = $this->preview;
            }

            $validated['image'] = $image_path;

            $outlet = Outlet::updateOrCreate(['id' => $this->id], $validated);

            $section_ids = [];

            foreach ($this->sections as $item) {
                $section = Section::updateOrCreate(
                    ['id' => $item['id'] ?? null],
                    ['name' => $item['name'], 'outlet_id' => $outlet->id]
                );

                $section_ids[] = $section->id; // pastikan ID sudah pasti ada
            }

            // 2. Baru hapus section lain yang tidak termasuk
            Section::where('outlet_id', $outlet->id)
                ->whereNotIn('id', $section_ids)
                ->delete();

            $image_ids = [];

            foreach ($this->images as $key => $item) {

                // Cek apakah ada 'image' dan apakah itu file upload baru
                if (isset($item['image']) && $item['image'] instanceof TemporaryUploadedFile) {

                    // Buat instance manager dengan driver GD
                    $manager = new ImageManager(Driver::class);

                    // Baca file dan kompres

                    // dd($item['image']->getRealPath());
                    $image = $manager->read($item['image']->getRealPath())->toJpeg(50);

                    // dd($image);

                    // Simpan file yang sudah dikompres
                    $image_path = 'outlet/' . time() . '.jpg';
                    $store = Storage::disk('public')->put($image_path, (string) $image);
                    // dd($store);
                    $image = OutletImage::updateOrCreate(
                        ['id' => $item['id'] ?? null],
                        ['image' => $image_path, 'outlet_id' => $outlet->id]
                    );
                    $image_ids[] = $image->id;
                } elseif (isset($item['image']) && is_string($item['image'])) {
                    $image_path = $item['image'];
                    $image_ids[] = $item['id'];
                } else {
                    $image_path = null;
                }
            }

            // dd($image_ids, Outlet::where('id', $outlet->id)->first()->images);

            OutletImage::where('outlet_id', $outlet->id)->whereNotIn('id', $image_ids)
                ->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug', false)) throw $th;
            return back()->with('error', '');
        }
    }

    public function render()
    {
        return view('livewire.outlet-create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
