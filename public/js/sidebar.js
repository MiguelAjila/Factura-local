// Sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    
    // Toggle sidebar on hover
    if (sidebar) {
        sidebar.addEventListener('mouseenter', function() {
            sidebar.classList.remove('sidebar-collapsed');
            sidebar.classList.add('sidebar-expanded');
        });
        
        sidebar.addEventListener('mouseleave', function() {
            sidebar.classList.remove('sidebar-expanded');
            sidebar.classList.add('sidebar-collapsed');
        });
    }

    // User settings form submission
    const saveButton = document.getElementById('saveUserSettings');
    if (saveButton) {
        saveButton.addEventListener('click', function() {
            const form = document.getElementById('userSettingsForm');
            const formData = new FormData(form);
            
            // Add CSRF token
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            // Send AJAX request
            fetch('{{ route("user.update") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert('Configuración guardada correctamente');
                    // Reload the page to see changes
                    window.location.reload();
                } else {
                    // Show error message
                    alert('Error: ' + (data.message || 'No se pudo guardar la configuración'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar la configuración');
            });
        });
    }

    // Preview image before upload
    const avatarInput = document.getElementById('avatar');
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.querySelector('.modal-body img');
                    if (img) {
                        img.src = e.target.result;
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
