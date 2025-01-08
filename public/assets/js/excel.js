function uploadFile() {
    const fileInput = document.getElementById('customFile');
    const file = fileInput.files[0];

    if (!file) {
        alert('Please select a file first!');
        return;
    }

    const formData = new FormData();
    formData.append('file', file);

    fetch('upload.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        console.log('Upload successful:', data);
    })
    .catch(error => {
        console.error('Error uploading file:', error);
    });
}
