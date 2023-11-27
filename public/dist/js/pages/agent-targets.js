function deleteTarget(id) {
    Swal.fire({
        title: "Delete Target",
        text: "Are you sure want delete this target?",
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
            Livewire.emit('deleteTarget', id);
        }
    })
}

function changeTargetStatus(id, currentStatus) {
    Livewire.emit('changeTargetStatus', id, currentStatus);
}