document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".status-dropdown").forEach(dropdown => {
      
        dropdown.dataset.previous = dropdown.value;

        dropdown.addEventListener("change", function() {
            let reservationId = this.getAttribute("data-id");
            console.log(reservationId);
            let newStatus = this.value;

            if (!confirm(`Are you sure you want to change the status to "${newStatus}"?`)) {
                this.value = this.dataset.previous;  
                return;
            }

            let formData = new FormData();
            formData.append("reservation_id", reservationId);
            formData.append("status", newStatus);

            fetch("update_status.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('success-alert').style.display = 'block';
                        setTimeout(() => {
                            document.getElementById('success-alert').style.display = 'none';
                        }, 5000);
                        this.dataset.previous = newStatus;
                        this.className = `form-select status-dropdown status-${newStatus.toLowerCase()}`;
                    } else {
                        document.getElementById('error-alert').style.display = 'block';
                        setTimeout(() => {
                            document.getElementById('error-alert').style.display = 'none';
                        }, 3000);
                        this.value = this.dataset.previous;  
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    this.value = this.dataset.previous;  
                });
        });
    });
});
