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
                                            <a href="<?= base_url('inspect') ?>" class="nav-link">Inspect</a>
                                            <a href="<?= base_url('query') ?>" class="nav-link active">Query</a>
                                        </div>
                                        <h4 class="mb-4 pb-3">Inspection History</h4>
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

<!-- Inspection History Modal -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: #2a2b38; color: #c4c3ca;">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="historyModalLabel" style="color: #ffeba7;">Inspection History</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-4 text-center">
                        <img id="itemImage" src="" alt="Item Image" class="img-fluid mb-3" style="max-height: 200px; width: auto;">
                        <h5 id="itemName" style="color: #ffeba7;"></h5>
                        <p id="itemType" class="text-muted"></p>
                    </div>
                    <div class="col-md-8">
                        <div id="inspectionHistory" class="inspection-history">
                            <!-- Inspection history will be dynamically inserted here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reuse existing styles from inspect.php */
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

    .modal-content {
        border: none;
        box-shadow: 0 8px 24px 0 rgba(0,0,0,.2);
    }

    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

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
        padding-bottom: 100%;
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

    /* New styles for inspection history */
    .inspection-history {
        max-height: 400px;
        overflow-y: auto;
    }

    .inspection-entry {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

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

    .inspection-meta {
        color: #8e8e96;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .inspection-notes {
        color: #c4c3ca;
        font-style: italic;
        margin-top: 8px;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 0.5rem;
        }
    }
</style>

<script>
// Dummy data for items with inspection history
const itemsData = [
    {
        id: 1,
        name: "LNG Pipeline Section A",
        type: "LNG Pipe",
        image: "https://dblqzuaaavvrvueuxaua.supabase.co/storage/v1/object/sign/temporary-image/LNGPipe.png?token=eyJraWQiOiJzdG9yYWdlLXVybC1zaWduaW5nLWtleV9lODhjZDZkMS1jZDgxLTRlOGUtYjA2YS05OGVjZjI3NmUwMzQiLCJhbGciOiJIUzI1NiJ9.eyJ1cmwiOiJ0ZW1wb3JhcnktaW1hZ2UvTE5HUGlwZS5wbmciLCJpYXQiOjE3NDkyOTQ3ODksImV4cCI6NTYyODIyMjc4OX0.d9CeMOv4C1h3Y290do1IfUD9U8GOPBoYTLIai-IndWs",
        inspectionHistory: [
            {
                date: "2025-06-07 14:30:00",
                inspector: "John Smith",
                notes: "Regular maintenance check completed. All parameters within normal range.",
                status: "Accept"
            },
            {
                date: "2025-06-04 09:15:00",
                inspector: "Sarah Johnson",
                notes: "Minor wear detected on section B. Requires monitoring.",
                status: "Repair"
            },
            {
                date: "2025-06-01 11:20:00",
                inspector: "Mike Brown",
                notes: "Pressure test passed. No leaks detected.",
                status: "Accept"
            }
        ]
    },
    {
        id: 2,
        name: "Heavy Duty Chain Set B",
        type: "Heavy Lifting Chains",
        image: "https://dblqzuaaavvrvueuxaua.supabase.co/storage/v1/object/sign/temporary-image/$_57.JPG?token=eyJraWQiOiJzdG9yYWdlLXVybC1zaWduaW5nLWtleV9lODhjZDZkMS1jZDgxLTRlOGUtYjA2YS05OGVjZjI3NmUwMzQiLCJhbGciOiJIUzI1NiJ9.eyJ1cmwiOiJ0ZW1wb3JhcnktaW1hZ2UvJF81Ny5KUEciLCJpYXQiOjE3NDkyOTQ3NzUsImV4cCI6NTYyODIyMjc3NX0.QNjkBbX0p7jhgXxtGWv4dF2sP-JhNOXWP9OYBYkfkrA",
        inspectionHistory: [
            {
                date: "2025-06-04 09:15:00",
                inspector: "Sarah Johnson",
                notes: "Chain links showing minimal wear.",
                status: "Accept"
            },
            {
                date: "2025-06-01 13:45:00",
                inspector: "John Smith",
                notes: "Critical stress points identified. Immediate replacement needed.",
                status: "Failed"
            },
            {
                date: "2025-06-01 10:30:00",
                inspector: "Mike Brown",
                notes: "Load test completed successfully.",
                status: "Accept"
            }
        ]
    }
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

// Function to show inspection history in modal
function showInspectionHistory(itemId) {
    const item = itemsData.find(i => i.id === itemId);
    if (!item) return;

    document.getElementById('itemImage').src = item.image;
    document.getElementById('itemName').textContent = item.name;
    document.getElementById('itemType').textContent = item.type;

    const historyHtml = item.inspectionHistory.map(inspection => `
        <div class="inspection-entry">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="status-badge status-${inspection.status}">${inspection.status}</span>
                <div class="inspection-meta text-end">
                    ${formatDate(inspection.date)}
                </div>
            </div>
            <div class="inspection-meta">
                Inspector: ${inspection.inspector}
            </div>
            <div class="inspection-notes">
                ${inspection.notes}
            </div>
        </div>
    `).join('');

    document.getElementById('inspectionHistory').innerHTML = historyHtml;

    const modal = new bootstrap.Modal(document.getElementById('historyModal'));
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
            showInspectionHistory(itemId);
        }
    });
});
</script>

<?= $this->endSection() ?>
