function deleteNote(id) {
    Swal.fire({
        title: 'Delete Note',
        text: "Are you sure want delete this note?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('deleteNote', id)
        }
    })
}

function deleteAllActivities(leadId) {
    Swal.fire({
        title: 'Delete All Activities',
        text: "Are you sure want delete all activities?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete all',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('deleteAllActivities', leadId)
        }
    })
}

function deleteAllComments(leadId) {
    Swal.fire({
        title: 'Delete All Comments',
        text: "Are you sure want delete all comments?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete all',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('deleteAllComments', leadId)
        }
    })
}