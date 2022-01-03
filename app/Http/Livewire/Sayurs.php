<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sayur;
use App\Models\Type;
use Livewire\WithPagination;

class Sayurs extends Component
{
    use WithPagination;
    public $search;
    //public $sayurs;
    public $sayurId, $sayur, $type, $harga;
    public $isOpen = 0;
    public function render()
    {
        $types = Type::all();
        $this->sayurs = Sayur::with('type');
        $searchParams = '%' . $this->search . '%';
        //$this->sayurs = Sayur::all();
        return view('livewire.sayurs', [
            'sayurs' => Sayur::where('sayur', 'like', $searchParams)->latest()
                ->orWhere('type', 'like', $searchParams)->latest()->paginate(5)
        ], compact('types'));
    }

    public function showModal()
    {
        $this->isOpen = true;
    }

    public function hideModal()
    {
        $this->isOpen = false;
    }

    public function store()
    {


        $types = Type::all();

        $this->validate(
            [
                'sayur' => 'required',
                'type' => 'required',
                'harga' => 'required',
            ]
        );

        Sayur::updateOrCreate(['id' => $this->sayurId], [
            'sayur' => $this->sayur,
            'type' => $this->type,
            'harga' => $this->harga,
        ]);

        $this->hideModal();

        session()->flash('info', $this->sayurId ? 'Sayur Update Successfully' : 'Post Created Successfully');

        $this->sayurId = '';
        $this->sayur = '';
        $this->type = '';
        $this->harga = '';
    }

    public function edit($id)
    {
        $sayurs = Sayur::findOrFail($id);
        $this->sayurId = $id;
        $this->sayur = $sayur->sayur;
        $this->type = $sayur->type;
        $this->harga = $sayur->harga;

        $this->showModal();
    }

    public function delete($id)
    {
        Sayur::find($id)->delete();
        session()->flash('delete', 'Sayur Deleted Successfully');
    }
}