<?php $this->extend('Layout/main') ?>

<?php $this->section('content') ?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Researcher Dashboard</h3>
                <h6 class="op-7 mb-2">Manage your document submissions and track their progress</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    Upload Document
                </button>
            </div>
        </div>

        <!-- Document Stats -->
        <div class="row">
            <!-- Document Stats -->
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                </div>

                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Uploaded</p>
                                        <h4 class="card-title">
                                            <?= esc($documentCount)?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Pending Review</p>
                                        <h4 class="card-title">
                                            <?= esc($pendingCount)?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Approved</p>
                                        <h4 class="card-title">
                                            <?= esc($approvedCount) ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Rejected</p>
                                        <h4 class="card-title">
                                            <?= esc($rejectedCount) ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document List -->
        <div class="row">
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Uploaded Documents</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Status</th>
                                    <th>Uploaded At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($documents as $document): ?>
                                    <tr>
                                        <td>
                                            <?= esc($document['document_name']); ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                <?= esc($document['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= esc($document['uploaded_at']); ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal">
                                                <a href="<?= base_url('/researcher-dashboard/download/' . $document['file_name']) ?>" style="text-decoration: none; color: white">
                                                    Download File
                                                </a>
                                            </button>
                                            <form action="/researcher-dashboard/delete/<?= esc($document['file_name']); ?>" method="post" style="display: inline;">
                                                <?= csrf_field() ?>  <!-- CSRF token to protect against CSRF attacks -->
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Delete File
                                                </button>
                                            </form>
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
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                <!-- More rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Document Modal -->
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
    
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/upload-document" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="documentTitle" class="form-label">Document Title</label>
                            <input type="text" name="documentTitle" id="documentTitle" class="form-control"
                                placeholder="Enter document title" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="documentFile" class="form-label">Select Document</label>
                            <input type="file" name="documentFile" id="documentFile" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showHistory(docId, title, researcher, status, uploadedAt, changedStatusAt) {
            // Simulate document history
            const historyContent = `
                <h6><strong>Document ID:</strong> ${docId}</h6>
                <h6><strong>Title:</strong> ${title}</h6>
                <h6><strong>Researcher:</strong> ${researcher}</h6>
                <h6><strong>Status:</strong> <span class="badge bg-${status === 'approved' ? 'success' : 'warning'}">${status}</span></h6>
                <hr>
                <ul>
                    <li><strong>${uploadedAt}:</strong> Submitted by the user and will be reviewed by the admin.</li>
                    ${status !== 'pending' ? `<li><strong>${changedStatusAt}:</strong> ${status === 'approved' ? 'Document is approved by the admin' : 'Document is rejected by the admin'}</li>` : '<li style="list-style:none"></li>'}
                </ul>`;

                console.log(status);
                    document.getElementById('historyContent').innerHTML = historyContent;
        }

        function viewDocument(name, status, fileName) {
            document.getElementById('docName').textContent = name;
            document.getElementById('docStatus').textContent = status;
            document.getElementById('docFileName').textContent = fileName;

            const downloadLink = document.getElementById('docFileName').textContent;

            downloadLink.href = '<?= base_url('writable/uploads/') ?>' + fileName;
        

            // todo: ayusin ang download link please lang tangina ahhashdkajshdfwqjh
        }    
    </script>
</div>

<?php $this->endSection() ?>