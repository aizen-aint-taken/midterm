
document.getElementById("customFile").addEventListener("change", function () {
    const fileInput = this;
    const file = fileInput.files[0];
    if (file) {
        alert(`You have selected: ${file.name}`);
    } else {
        alert("No file selected.");
    }
});