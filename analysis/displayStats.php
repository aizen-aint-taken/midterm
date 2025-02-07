<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data And Statistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../analysis/stats.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
</head>

<style>
    /* General Layout */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fb;
        color: #333;
    }

    .container-fluid {
        text-align: center;
        margin-right: 30px;
    }


    /* Main Content */
    .col-md-10 {
        padding: 30px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Header */
    h2 {
        font-size: 28px;
        color: #343a40;
        font-weight: 600;
        margin-bottom: 20px;
    }

    /* Search Bar */
    #searchInput {
        border-radius: 20px;
        padding-left: 20px;
        font-size: 16px;
        border: 1px solid #ddd;
        transition: all 0.3s;
    }

    #searchInput:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    }

    /* Table */
    table {
        font-size: 16px;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    th,
    td {
        padding: 12px 15px;
        text-align: left;
        vertical-align: middle;
        border: 1px solid #ddd;
    }

    th {
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }

    th:hover {
        background-color: #0056b3;
    }

    td {
        background-color: #f9f9f9;
    }

    tbody tr:hover {
        background-color: #f1f1f1;
    }


    .chart-container {
        margin-top: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    canvas {
        border-radius: 10px;
        background-color: #ffffff;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    /* Responsive Styling */
    @media (max-width: 768px) {
        .container-fluid {
            margin-top: 15px;
        }

        .col-md-10 {
            padding: 15px;
        }

        h2 {
            font-size: 24px;
        }

        table {
            font-size: 14px;
        }
    }
</style>



<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="row">


            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="card shadow-sm rounded-3 p-4 w-100">
                    <h2 class="text-center mb-4">Users and Books Statistics</h2>

                    <!-- Users Table -->
                    <h4 class="text-center">Users & Their Books</h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Name</th>
                                    <th>Books Acquired</th>
                                </tr>
                            </thead>
                            <tbody id="usersTable"></tbody>
                        </table>
                    </div>

                    <!-- Books Table -->
                    <h4 class="text-center">Books & Stock</h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>Title</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody id="booksTable"></tbody>
                        </table>
                    </div>

                    <!-- Bar Graphs -->
                    <div class="chart-container">
                        <h3 class="text-center">Users vs. Books Acquired</h3>
                        <canvas id="userBarChart"></canvas>
                    </div>

                    <div class="chart-container mt-4">
                        <h3 class="text-center">Book Stock Distribution</h3>
                        <canvas id="bookBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            fetch('../admin/analytics.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data fetched successfully:', data);

                    // Populate Users Table
                    const usersTable = document.getElementById('usersTable');
                    data.users.forEach(user => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${user.name}</td>
                    <td>${user.total_books}</td>
                `;
                        usersTable.appendChild(row);
                    });

                    // Populate Books Table
                    const booksTable = document.getElementById('booksTable');
                    data.books.forEach(book => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${book.Title}</td>
                    <td>${book.Stock}</td>
                `;
                        booksTable.appendChild(row);
                    });

                    // User Bar Chart
                    const userBarChartCtx = document.getElementById('userBarChart').getContext('2d');
                    new Chart(userBarChartCtx, {
                        type: 'bar',
                        data: {
                            labels: data.users.map(user => user.name),
                            datasets: [{
                                label: 'Books Acquired',
                                data: data.users.map(user => user.total_books),
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    formatter: (value) => value,
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    });

                    const bookBarChartCtx = document.getElementById('bookBarChart').getContext('2d');
                    new Chart(bookBarChartCtx, {
                        type: 'bar',
                        data: {
                            labels: data.books.map(book => book.Title),
                            datasets: [{
                                label: 'Stock',
                                data: data.books.map(book => book.Stock),
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    formatter: (value) => value,
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    console.error('Error details:', error.message);
                });
        });
    </script>
</body>

</html>