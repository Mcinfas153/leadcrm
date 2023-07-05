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

window.addEventListener('modalClose', event => {
    statusModal.hide()
    agentModal.hide()
});