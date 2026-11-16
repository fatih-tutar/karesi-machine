<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

class MachineController extends Controller
{
    public function index(): View
    {
        return view('admin.machines.index', [
            'machines' => Machine::active()->orderByDesc('sort_order')->orderByDesc('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $image = $request->file('image') ? $this->storeImage($request->file('image')) : null;

        Machine::create([
            ...$data,
            'image' => $image,
            'recorded_on' => now()->toDateString(),
            'sort_order' => $data['sort_order'] ?? 0,
            'is_deleted' => false,
        ]);

        return redirect()->route('machines.index')->with('status', 'Makine eklendi.');
    }

    public function update(Request $request, Machine $machine): RedirectResponse
    {
        $data = $this->validated($request);
        $images = (string) $machine->image;

        if ($request->file('image')) {
            $new = $this->storeImage($request->file('image'));
            $images = $images !== '' ? $images.','.$new : $new;
        }

        $machine->update([
            ...$data,
            'image' => $images !== '' ? $images : null,
            'sort_order' => $data['sort_order'] ?? $machine->sort_order,
        ]);

        return redirect()->route('machines.index')->with('status', 'Makine güncellendi.');
    }

    public function destroy(Machine $machine): RedirectResponse
    {
        $machine->softDeleteFlag();

        return redirect()->route('machines.index')->with('status', 'Makine silindi.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'video_url' => ['nullable', 'string', 'max:2000'],
            'speed' => ['nullable', 'string', 'max:255'],
            'length' => ['nullable', 'string', 'max:255'],
            'height' => ['nullable', 'string', 'max:255'],
            'width' => ['nullable', 'string', 'max:255'],
            'weight_info' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'image' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:8192'],
        ]);

        unset($data['image']);

        return $data;
    }

    /**
     * Store an uploaded image in public/img and return the file name.
     */
    private function storeImage(UploadedFile $file): string
    {
        $dir = public_path(config('tradeops.machine_image_dir', 'img'));
        $name = 'machine_'.time().'_'.random_int(1000, 9999).'.'.$file->extension();

        $file->move($dir, $name);

        return $name;
    }
}
