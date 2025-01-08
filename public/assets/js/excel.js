document.getElementById("uploadForm").addEventListener("submit", function (e) {
    const fileInput = document.getElementById("customFile");
    const file = fileInput.files[0];
    const allowedExtensions = ["xlsx", "xls"];
    const fileExtension = file.name.split('.').pop().toLowerCase();

    if (!allowedExtensions.includes(fileExtension)) {
        e.preventDefault();
        alert("Invalid file type. Please upload an Excel file.");
    }
});
