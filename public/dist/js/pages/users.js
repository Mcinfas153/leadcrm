function userStatusChange(userId, currentStatus) {
    Livewire.emit('changeUserStatus', userId, currentStatus)
}

function deleteUser(userId, name) {
    Swal.fire({
        title: name,
        text: "Are you sure want delete this user?",
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
            Livewire.emit('deleteUser', userId)
        }
    })
}