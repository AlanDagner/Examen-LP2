<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class Posts extends Component
{
    public $posts, $codigo, $nombre, $apellidos, $direccion, $numero, $post_id;
    public $isOpen = false;

    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->codigo = '';
        $this->nombre = '';
        $this->apellidos = '';
        $this->direccion = '';
        $this->numero = '';
        $this->post_id = '';
    }

    public function store()
    {
        $this->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'apellidos' => 'required',
            'direccion' => 'required',
            'numero' => 'required',
        ]);
   
        Post::updateOrCreate(['id' => $this->post_id], [
            'codigo' => $this->codigo,
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'direccion' => $this->direccion,
            'numero' => $this->numero
        ]);
  
        session()->flash('message', 
            $this->post_id ? 'Post Updated Successfully.' : 'Post Created Successfully.');
  
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->codigo = $post->codigo;
        $this->nombre = $post->nombre;
        $this->apellidos = $post->apellidos;
        $this->direccion = $post->direccion;
        $this->numero = $post->numero;
    
        $this->openModal();
    }
    
    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }
}
