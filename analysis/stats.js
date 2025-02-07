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

        
            const usersTable = document.getElementById('usersTable');
            data.users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.name}</td>
                    <td>${user.total_books}</td>
                `;
                usersTable.appendChild(row);
            });

            const booksTable = document.getElementById('booksTable');
            data.books.forEach(book => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${book.Title}</td>
                    <td>${book.Stock}</td>
                `;
                booksTable.appendChild(row);
            });

         
            const userBarChartCtx = document.getElementById('userBarChart').getContext('2d');
            new Chart(userBarChartCtx, {
                type: 'bar',
                data: {
                    labels: data.users.map(user => user.name),
                    datasets: [{
                        label: 'Books Available',
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