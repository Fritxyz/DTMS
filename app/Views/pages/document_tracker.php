<?php $this->extend('Layout/main') ?>

<?php $this->section('content') ?>
<link rel="stylesheet" href="assets/css/custom.css" />

<div class="row">
    <!-- Document History Section -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <!-- Document History Table -->
            <table class="table align-items-center mb-0">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Document ID</th>
                        <th scope="col">Title</th>
                        <th scope="col" class="text-end">Date Submitted</th>
                        <th scope="col" class="text-end">Researcher</th>
                        <th scope="col" class="text-end">Current Status</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($documents as $document): ?>
                        <tr>
                            <th scope="row"><?= esc($document['id']) ?></th>
                            <td><?= esc($document['document_name']) ?></td>
                            <td class="text-end"><?= esc($document['uploaded_at']) ?></td>
                            <td class="text-end"><?= esc($document['first_name']) ?> <?= esc($document['last_name']) ?></td>
                            <td class="text-end">
                                <span class="badge bg-<?php echo $document['status'] === 'approved' ? 'success' : 'danger'; ?>"><?= esc($document['status']) ?></span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#historyModal"
                                    onclick="showHistory(
                                        '<?= esc($document['id']) ?>', 
                                        '<?= esc($document['document_name']) ?>', 
                                        '<?= esc($document['first_name']) ?> <?= esc($document['last_name']) ?>',
                                        '<?= esc($document['status']) ?>',
                                        '<?= esc($document['uploaded_at']) ?>',
                                        '<?= esc($document['changed_status_at']) ?>'
                                    )">
                                    View History
                                </button>

                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#documentModal"
                                    onclick="showDocument(
                                        '<?= esc($document['first_name']) ?> <?= esc($document['last_name']) ?>',
                                        '<?= esc($document['document_name']) ?>',                                        
                                        '<?= esc($document['uploaded_at']) ?>',
                                        '<?= esc($document['id']) ?>',
                                    )">
                                    Update Document
                                </button>

                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal">
                                    <a href="<?= base_url('/admin-dashboard/document-tracker/download/' . $document['file_name']) ?>" style="text-decoration: none; color: white">
                                        Download File
                                    </a>
                                </button>

                                <form action="/admin-dashboard/document-tracker/delete/<?= esc($document['file_name']); ?>" method="post" style="display: inline;">
                                    <?= csrf_field() ?>  <!-- CSRF token to protect against CSRF attacks -->
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Delete File
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        
    </div>
</div>

<!-- Modal for Document History -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel">Document History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="historyContent">
                    <!-- Document history will be displayed here dynamically -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel"
                    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="documentModalLabel">Document Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/admin-dashboard/document-tracker/update-status/') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p><strong>Submitted By:</strong> <span id="docSubmitter"></span></p>
                    <p><strong>Document Name:</strong> <span id="docName"></span></p>
                    <p><strong>Uploaded At:</strong> <span id="docUploaded"></span></p>
                    <div>
                        <label for="docActions"><strong>Actions:</strong></label>
                        <select id="docActions" class="form-control" required>
                            <option value="" disabled selected>Select an Action</option>
                            <option value="approved">Approve</option>
                            <option value="rejected">Reject</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">     
            
                    
                    <input type="hidden" name="docId" id="docId" value="">  <!-- Hidden field for document ID -->
                    <input type="hidden" name="actionType" id="actionType" value="">  <!-- Hidden field for action type -->
                    
                    <button type="submit" class="btn btn-primary">Update Document</button>
                
                    
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script to Populate Modal with Document History -->
<script>
    function showHistory(docId, title, researcher, status, uploadedAt, changedStatusAt) {
    // Simulate document history
    const historyContent = `
        <h6><strong>Document ID:</strong> ${docId}</h6>
        <h6><strong>Title:</strong> ${title}</h6>
        <h6><strong>Researcher:</strong> ${researcher}</h6>
        <h6><strong>Status:</strong> <span class="badge bg-${status === 'approved' ? 'success' : 'danger'}">${status}</span></h6>
        <hr>
        <ul>
            <li><strong>${uploadedAt}:</strong> Submitted by the user and will be reviewed by the admin.</li>
            ${status !== 'pending' ? `<li><strong>${changedStatusAt}:</strong> ${status === 'approved' ? 'Document is approved by the admin' : 'Document is rejected by the admin'}</li>` : '<li style="list-style:none"></li>'}
        </ul>`;

        console.log(status);
            document.getElementById('historyContent').innerHTML = historyContent;
    }

    function showDocument(submitter, details, uploadedAt, docId) {
        // Set the document details in the modal
        document.getElementById('docSubmitter').textContent = submitter;
        document.getElementById('docName').textContent = details;
        document.getElementById('docUploaded').textContent = uploadedAt;

        // Set the docId and log it for debugging
        document.getElementById('docId').value = docId;
        console.log('docId set to:', docId);  // Debug log
        console.log(submitter); // Debug

        // Ensure the actionType dropdown is initialized correctly
        const actionTypeDropdown = document.getElementById('docActions');

        // Listen for change event on the dropdown to set actionType hidden field
        actionTypeDropdown.addEventListener('change', function () {
            const actionType = this.value;  // Get the selected value
            document.getElementById('actionType').value = actionType;
            console.log('actionType set to:', actionType);  // Debug log
        });

        // In case the form is submitted, log values to ensure proper population
        const form = document.querySelector('form');
        form.addEventListener('submit', function (event) {
            console.log('Form submitted');
            console.log('docId:', document.getElementById('docId').value);
            console.log('actionType:', document.getElementById('actionType').value);
        });
    }
</script>

<?php $this->endSection() ?>