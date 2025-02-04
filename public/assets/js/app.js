document.addEventListener('DOMContentLoaded', function() {
    // Date selector handling
    const dateSelector = document.getElementById('dateSelector');
    if (dateSelector) {
        dateSelector.addEventListener('change', function(e) {
            fetch(`/?date=${e.target.value}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = document.querySelector('.animals-grid');
                    document.querySelector('.animals-grid').innerHTML = newContent.innerHTML;
                })
                .catch(error => console.error('Error:', error));
        });
    }

    // Capital modal handling
    const updateCapitalBtn = document.getElementById('updateCapital');
    const capitalModal = document.getElementById('capitalModal');
    const capitalForm = document.getElementById('capitalForm');

    if (updateCapitalBtn && capitalModal) {
        updateCapitalBtn.addEventListener('click', function() {
            capitalModal.style.display = 'flex';
        });

        capitalModal.addEventListener('click', function(e) {
            if (e.target === capitalModal) {
                capitalModal.style.display = 'none';
            }
        });

        if (capitalForm) {
            capitalForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const amount = document.getElementById('amount').value;

                fetch('/transactions/update-capital', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ amount }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        }
    }
});