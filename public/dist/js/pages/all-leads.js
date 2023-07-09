const statusModal = new bootstrap.Modal(document.getElementById('status-change-modal'))
const agentModal = new bootstrap.Modal(document.getElementById('agent-change-modal'))

function changeStatus(leadId, statusId) {
    statusModal.show()
    Livewire.emit('leadIdSelect', leadId, statusId)
}

function changeAgent(leadId, agentId) {
    agentModal.show()
    Livewire.emit('leadAgentIdSelect', leadId, agentId)
}

function makeCall(phoneNumber) {
    Swal.fire({
        title: phoneNumber,
        text: "Are you sure want to call this number?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, call it',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `tel:${phoneNumber}`
        }
    })
}

function sentEmail(email) {
    Swal.fire({
        title: email,
        text: "Are you sure want to send email to this address?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, sent it',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `mailto:${email}`
        }
    })
}

function exportLeads(url) {
    Swal.fire({
        title: 'Export Leads',
        text: "Are you sure want export leads?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, export it',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url
        }
    })
}

window.addEventListener('modalClose', event => {
    statusModal.hide()
    agentModal.hide()
});