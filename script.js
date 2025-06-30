document.addEventListener('DOMContentLoaded', function() {
    // Memuat daftar file saat halaman dimuat
    loadFileList();
    
    // Menangani form upload
    document.getElementById('upload-form').addEventListener('submit', function(e) {
        e.preventDefault();
        uploadFile();
    });
});

function loadFileList() {
    fetch('get_files.php')
        .then(response => response.json())
        .then(files => {
            const fileListContainer = document.getElementById('file-list');
            
            if (files.length > 0) {
                let html = '';
                files.forEach(file => {
                    html += `
                    <div class="file-item">
                        <div>
                            <h3>${file.name}</h3>
                            <p>${file.ext.toUpperCase()} (${file.size})</p>
                        </div>
                        <a href="download.php?file=${encodeURIComponent(file.name)}" class="download-btn">Unduh</a>
                    </div>
                    `;
                });
                fileListContainer.innerHTML = html;
            } else {
                fileListContainer.innerHTML = '<p>Tidak ada file yang tersedia untuk diunduh.</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('file-list').innerHTML = '<p>Gagal memuat daftar file.</p>';
        });
}

function uploadFile() {
    const formData = new FormData(document.getElementById('upload-form'));
    const messageContainer = document.getElementById('message');
    
    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(message => {
        messageContainer.innerHTML = `<div class="message ${message.includes('berhasil') ? 'success' : 'error'}">${message}</div>`;
        loadFileList(); // Memuat ulang daftar file setelah upload
        document.getElementById('upload-form').reset();
    })
    .catch(error => {
        console.error('Error:', error);
        messageContainer.innerHTML = '<div class="message error">Terjadi kesalahan saat mengupload file.</div>';
    });
}