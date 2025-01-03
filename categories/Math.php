<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ely Gian Ga">
    <meta name="description" content="System">
    <link rel="stylesheet" href="public/assets/css/bootstrap.min.css">  
    <title>Math Section</title>
</head>
<body>
    <div class="container mt-5">
        <!-- Add Math Book  -->
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-success"  data-toggle="modal" data-target="#addBookModal">Add Math Book
                </button>
            </div>

            <!-- Search Bar for Math Book -->
            <div class="d-flex justify-content-center my-3">
                <div class="input-group w-50">
                    <input type="search" data-name="books" id="Search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <button type="button" class="btn btn-outline-primary">Search</button>
                </div>
        </div>
          <!--  desktop POV  -->
        <table class="table table-striped text-center">
        <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Genre</th>
                    <th>Published Date</th>
                    <th>Language</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</body>
</html>