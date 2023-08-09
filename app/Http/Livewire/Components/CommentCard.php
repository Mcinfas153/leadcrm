<?php

namespace App\Http\Livewire\Components;

use App\Models\Note;
use Livewire\Component;

class CommentCard extends Component
{

    public Note $note;

    public function render()
    {
        return view('livewire.components.comment-card');
    }
}
