<?= $this->extend('template/index') ?>
<?= $this->section('page-content') ?>

<!-- Add Bootstrap JS and Popper.js CDN -->
<script src="<?= base_url('js/popper.min.js') ?>"></script>
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
<!-- Add SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="section">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-12 text-center">
                <a href="/" class="logo mb-4 d-inline-block">
                    <img src="<?= base_url('img/oilid.png') ?>" alt="" style="width: 75px; height: 50px;" />
                </a>
            </div>
        </div>
        <div class="row full-height justify-content-center">
            <div class="col-12 text-center align-self-center py-5">
                <div class="section pb-5 pt-5 pt-sm-2 text-center">
                    <div class="card-3d-wrap mx-auto">
                        <div class="card-3d-wrapper">
                            <div class="card-front">
                                <div class="center-wrap">
                                    <div class="section text-center">
                                        <div class="nav-links mb-4">
                                            <a href="<?= base_url('inspect') ?>" class="nav-link active">Inspect</a>
                                            <a href="<?= base_url('query') ?>" class="nav-link">Query</a>
                                        </div>
                                        <h4 class="mb-4 pb-3">Select Item to Inspect</h4>
                                        <div class="items-grid">
                                            <div id="itemsContainer" class="row g-4">
                                                <!-- Items will be dynamically inserted here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Item Details Modal -->
<div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: #2a2b38; color: #c4c3ca;">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="itemModalLabel" style="color: #ffeba7;">Item Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="itemImage" src="" alt="Item Image" class="img-fluid mb-4" style="max-height: 200px; width: auto;">
                <div class="item-details">
                    <div class="mb-3">
                        <span class="detail-label" style="color: #ffeba7;">Item Name:</span>
                        <h5 id="itemName" class="d-inline ms-2" style="color: #c4c3ca;"></h5>
                    </div>
                    <div class="mb-3">
                        <span class="detail-label" style="color: #ffeba7;">Item Type:</span>
                        <p id="itemType" class="d-inline ms-2 mb-0"></p>
                    </div>
                    <div class="mb-3">
                        <span class="detail-label" style="color: #ffeba7;">Last Inspection:</span>
                        <div id="lastInspection" class="inspection-section mt-2"></div>
                    </div>
                    <hr class="border-light">
                    <form id="inspectionForm" class="text-start">
                        <input type="hidden" id="itemId" name="itemId">
                        <div class="mb-3">
                            <label for="inspectionStatus" class="form-label" style="color: #ffeba7;">Inspection Status</label>
                            <select class="form-select bg-dark text-light" id="inspectionStatus" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Accept">Accept</option>
                                <option value="Repair">Repair</option>
                                <option value="Failed">Failed</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="inspectionNotes" class="form-label" style="color: #ffeba7;">Inspection Notes</label>
                            <textarea class="form-control bg-dark text-light" id="inspectionNotes" name="notes" rows="3" placeholder="Enter inspection notes..." required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn" style="background: linear-gradient(to right, #ffeba7 0%, #f5ce62 100%); color: #102770;">
                                Submit Inspection
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nfc-scan-button {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(to right, #ffeba7 0%, #f5ce62 100%);
        border: none;
        cursor: pointer;
        transition: all 0.4s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .nfc-scan-button:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 24px 0 rgba(16, 39, 112, .2);
    }

    .nfc-scan-button i {
        font-size: 48px;
        color: #102770;
    }

    .scanning .nfc-scan-button {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(245, 206, 98, 0.7);
        }

        70% {
            transform: scale(1.05);
            box-shadow: 0 0 0 20px rgba(245, 206, 98, 0);
        }

        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(245, 206, 98, 0);
        }
    }

    /* Modal Styles */
    .modal-content {
        border: none;
        box-shadow: 0 8px 24px 0 rgba(0,0,0,.2);
    }
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    /* Add these new styles */
    .item-details {
        text-align: left;
        padding: 0 20px;
    }
    .detail-label {
        font-weight: 600;
        font-size: 1.1rem;
    }
    #itemName, #itemType {
        font-size: 1.1rem;
    }

    .loading-spinner {
        margin-top: 20px;
        text-align: center;
    }

    .spinner {
        width: 40px;
        height: 40px;
        margin: 0 auto;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #ffeba7;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loading-spinner p {
        margin-top: 10px;
        color: #ffeba7;
    }

    /* Add these new styles */
    .form-select, .form-control {
        border: 1px solid #ffeba7;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #f5ce62;
        box-shadow: 0 0 0 0.25rem rgba(245, 206, 98, 0.25);
    }
    
    .form-select option {
        background-color: #2a2b38;
        color: #c4c3ca;
    }
    
    hr.border-light {
        border-color: rgba(255,255,255,0.1);
        margin: 1.5rem 0;
    }

    /* Add these new styles for status badges */
    .status-badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-weight: 600;
        display: inline-block;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-Accept {
        background-color: rgba(40, 167, 69, 0.2);
        color: #28a745;
        border: 1px solid #28a745;
    }
    
    .status-Repair {
        background-color: rgba(255, 193, 7, 0.2);
        color: #ffc107;
        border: 1px solid #ffc107;
    }
    
    .status-Failed {
        background-color: rgba(220, 53, 69, 0.2);
        color: #dc3545;
        border: 1px solid #dc3545;
    }
    .inspection-section {
        background-color: rgba(255, 255, 255, 0.05);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    .inspection-notes {
        font-style: italic;
        color: #a9a9b1;
        margin-top: 8px;
    }
    .inspection-meta {
        font-size: 0.9rem;
        color: #8e8e96;
        margin-top: 5px;
    }

    /* Add styles for test mode section */
    .test-mode-section {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 20px;
        margin-top: 20px;
    }

    .test-mode-section h5 {
        color: #ffeba7;
        font-weight: 500;
    }

    /* Add these new styles for navigation */
    .nav-links {
        margin: 20px 0;
    }

    .nav-links .nav-link {
        display: inline-block;
        padding: 8px 20px;
        margin: 0 10px;
        color: #c4c3ca;
        text-decoration: none;
        transition: all 0.3s ease;
        border-radius: 4px;
    }

    .nav-links .nav-link:hover {
        color: #ffeba7;
        transform: translateY(-2px);
    }

    .nav-links .nav-link.active {
        color: #ffeba7;
        background: rgba(255, 235, 167, 0.1);
    }

    .logo {
        display: block;
        margin: 0 auto;
        transition: transform 0.3s ease;
    }

    .logo:hover {
        transform: scale(1.05);
    }

    /* Add new styles for the items grid */
    .items-grid {
        padding: 20px;
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .item-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .item-image-container {
        width: 100%;
        padding-bottom: 100%; /* Makes it square */
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    
    .item-card img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    .item-card h5 {
        color: #ffeba7;
        margin: 10px 0;
        font-size: 1.1rem;
        text-align: center;
    }

    /* Make the grid responsive */
    @media (max-width: 768px) {
        .items-grid {
            padding: 10px;
        }
        
        .item-card {
            padding: 10px;
        }

        .item-card h5 {
            font-size: 0.9rem;
            margin: 8px 0;
        }
    }

    @media (max-width: 576px) {
        .items-grid {
            padding: 8px;
        }

        .item-card {
            padding: 8px;
            margin-bottom: 10px;
        }

        .item-card h5 {
            font-size: 0.8rem;
            margin: 6px 0;
        }

        #itemsContainer {
            margin: 0 -4px;
        }

        #itemsContainer > div {
            padding: 0 4px;
            margin-bottom: 8px;
        }
    }
</style>

<script>
// Dummy data for items
const itemsData = [
    {
        id: 1,
        name: "LNG Pipeline Section A",
        type: "LNG Pipe",
        image: "https://dblqzuaaavvrvueuxaua.supabase.co/storage/v1/object/sign/temporary-image/LNGPipe.png?token=eyJraWQiOiJzdG9yYWdlLXVybC1zaWduaW5nLWtleV9lODhjZDZkMS1jZDgxLTRlOGUtYjA2YS05OGVjZjI3NmUwMzQiLCJhbGciOiJIUzI1NiJ9.eyJ1cmwiOiJ0ZW1wb3JhcnktaW1hZ2UvTE5HUGlwZS5wbmciLCJpYXQiOjE3NDkyOTQ3ODksImV4cCI6NTYyODIyMjc4OX0.d9CeMOv4C1h3Y290do1IfUD9U8GOPBoYTLIai-IndWs",
        lastInspection: {
            date: "2025-06-07 14:30:00",
            notes: "Regular maintenance check completed. All parameters within normal range.",
            inspector: "John Smith",
            status: "Accept"
        }
    },
    {
        id: 2,
        name: "Heavy Duty Chain Set B",
        type: "Heavy Lifting Chains",
        image: "https://dblqzuaaavvrvueuxaua.supabase.co/storage/v1/object/sign/temporary-image/$_57.JPG?token=eyJraWQiOiJzdG9yYWdlLXVybC1zaWduaW5nLWtleV9lODhjZDZkMS1jZDgxLTRlOGUtYjA2YS05OGVjZjI3NmUwMzQiLCJhbGciOiJIUzI1NiJ9.eyJ1cmwiOiJ0ZW1wb3JhcnktaW1hZ2UvJF81Ny5KUEciLCJpYXQiOjE3NDkyOTQ3NzUsImV4cCI6NTYyODIyMjc3NX0.QNjkBbX0p7jhgXxtGWv4dF2sP-JhNOXWP9OYBYkfkrA",
        lastInspection: {
            date: "2025-06-04 09:15:00",
            notes: "Chain links showing minimal wear.",
            inspector: "Sarah Johnson",
            status: "Repair"
        }
    },
];

// Function to create item cards
function createItemCards() {
    const container = document.getElementById('itemsContainer');
    itemsData.forEach(item => {
        const col = document.createElement('div');
        col.className = 'col-6';
        col.innerHTML = `
            <div class="item-card" data-item-id="${item.id}">
                <div class="item-image-container">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                <h5>${item.name}</h5>
            </div>
        `;
        container.appendChild(col);
    });
}

// Function to format date
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleString();
}

// Function to show item details in modal
function showItemDetails(itemId) {
    const item = itemsData.find(i => i.id === itemId);
    if (!item) return;

    document.getElementById('itemImage').src = item.image;
    document.getElementById('itemName').textContent = item.name;
    document.getElementById('itemType').textContent = item.type;
    document.getElementById('itemId').value = item.id;
    
    const lastInspectionHtml = `
        <div class="mb-2">
            <strong>Status:</strong> 
            <span class="status-badge status-${item.lastInspection.status}">
                ${item.lastInspection.status}
            </span>
        </div>
        <div class="mb-2">
            <strong>Date:</strong> ${formatDate(item.lastInspection.date)}
        </div>
        <div class="mb-2">
            <strong>Inspector:</strong> ${item.lastInspection.inspector}
        </div>
        <div class="inspection-notes">
            <strong>Notes:</strong> ${item.lastInspection.notes}
        </div>
    `;
    document.getElementById('lastInspection').innerHTML = lastInspectionHtml;

    const modal = new bootstrap.Modal(document.getElementById('itemModal'));
    modal.show();
}

// Event listeners
document.addEventListener('DOMContentLoaded', () => {
    createItemCards();

    // Add click event listeners to item cards
    document.getElementById('itemsContainer').addEventListener('click', (e) => {
        const card = e.target.closest('.item-card');
        if (card) {
            const itemId = parseInt(card.dataset.itemId);
            showItemDetails(itemId);
        }
    });

    // Handle form submission
    document.getElementById('inspectionForm').addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Here you would normally send the data to the server
        // For demo purposes, we'll just show a success message
        const modal = bootstrap.Modal.getInstance(document.getElementById('itemModal'));
        modal.hide();
        
        Swal.fire({
            title: 'Success!',
            text: 'Inspection has been submitted successfully',
            icon: 'success',
            confirmButtonColor: '#ffeba7'
        });
    });
});
</script>

<?= $this->endSection() ?>
