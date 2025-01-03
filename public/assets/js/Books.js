$(document).ready(function () {
 
    $("#Search").on("input", function () {
        let query = $(this).val().toLowerCase();
        // console.log(query);
        $("table tbody tr, .card").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
        });
    });

    $(document).on('click', '.delete-btn', function () {
        $('#deleteBookId').val($(this).data('id'));
    });

 
    $(document).on('click', '.edit-btn', function () {
        $('#editBookId').val($(this).data('id'));
        $('#editBookTitle').val($(this).data('title'));
        $('#editBookAuthor').val($(this).data('author'));
        $('#editBookPublisher').val($(this).data('publisher'));
        $('#editBookGenre').val($(this).data('genre'));
        $('#editBookPublishedDate').val($(this).data('published'));
        $('#editBookLanguage').val($(this).data('language'));
        $('#editBookStock').val($(this).data('stock'));
    });
});

document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        const bookId = this.getAttribute('data-id');
        document.getElementById('deleteBookId').value = bookId;
    });
});



    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("Search");
        console.log(searchInput);
        const tableRows = document.querySelectorAll("table tbody tr");
        
        searchInput.addEventListener("input", function() {
            const searchQuery = searchInput.value.toLowerCase();
            
            tableRows.forEach(row => {
                const titleCell = row.cells[1].textContent.toLowerCase(); 
                
               
                if (titleCell.includes(searchQuery)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

        
        searchInput.addEventListener("focus", function() {
            if (searchInput.value === "") {
                tableRows.forEach(row => {
                    row.style.display = "";
                });
            }
        });
    });


