<?php $this->extend('Layout/main') ?>

<?php $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
                <h6 class="op-7 mb-2">Quick Summary</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total document</p>
                                    <h4 class="card-title">
                                        <?= esc($documentCount) ?>
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
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Review</p>
                                    <h4 class="card-title"><?= esc($pendingCount) ?></h4>
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
                                    <i class="far fa-check-circle"></i>
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
                                    <i class="fas fa-file-excel"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0 ">
                                <div class="numbers">
                                    <p class="card-category">Reject</p>
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
        <div class="row">
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">User Statistics</div>
                            <div class="card-tools">
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="min-height: 375px">
                            <canvas id="statusChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-round">
                    <div class="card-body">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Documents To Review</div>
                        </div>
                        <div class="card-list py-4">
                            <!-- Example Incoming Document Entries -->
                            <?php foreach ($pendingDocuments as $document): ?>

                                <div class="item-list">
                                    <div class="avatar">
                                        <img src="assets/img/user.png" alt="user-profile" class="avatar-img rounded-circle" />
                                    </div>
                                    <div class="info-user ms-3">
                                        <div class="username">
                                            <?= esc($document['first_name']) ?> <?= esc($document['last_name']) ?>
                                        </div>
                                        <div class="status">
                                            <?= esc($document['document_name']) ?>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <!-- View Button -->
                                        <button class="btn btn-icon btn-link op-8 me-1" data-bs-toggle="modal" data-bs-target="#documentModal"
                                                onclick="showDocument(
                                                    '<?= esc($document['first_name']) ?> <?= esc($document['last_name']) ?>', 
                                                    '<?= esc($document['document_name']) ?>',
                                                    '<?= esc($document['uploaded_at']) ?>',
                                                    '<?= esc($document['id']) ?>')">
                                            <i class="far fa-eye"></i>
                                        </button>

                                        <!-- Download Button -->
                                        <button class="btn btn-icon btn-link op-8 me-1">
                                            <a href="<?= base_url('/admin-dashboard/download/' . $document['file_name']) ?>" style="text-decoration: none; color: white">
                                                <i class="fas fa-download" style="color: blue" style="font-size: 2px"></i>
                                            </a>
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="/admin-dashboard/delete/<?= esc($document['file_name']); ?>" method="post" style="display: inline;">
                                            <?= csrf_field() ?>  <!-- CSRF token to protect against CSRF attacks -->
                                            <button type="submit" style="border-style: none; background-color: #ffffff">
                                                <i class="fas fa-trash" style="color: red;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="documentModalLabel">Document Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('/admin-dashboard/update-status/') ?>" method="post">
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

                <!-- // todo: create a delete page implement it
                // update the page status and implement it
                // do the download button
                // create a statistic chart (line graph) -->
                <script>
                    function showDocument(submitter, details, uploadedAt, docId) {
                        // Set the document details in the modal
                        document.getElementById('docSubmitter').textContent = submitter;
                        document.getElementById('docName').textContent = details;
                        document.getElementById('docUploaded').textContent = uploadedAt;

                        // Set the docId and log it for debugging
                        document.getElementById('docId').value = docId;
                        console.log('docId set to:', docId);  // Debug log

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

                <script>
                    // Prepare the data received from the controller
                    const chartData = <?= json_encode($chartData) ?>;

                    // Get the count of each status
                    const pendingCount = chartData.pending;
                    const approvedCount = chartData.approved;
                    const rejectedCount = chartData.rejected;

                    // Get the context for the chart
                    const ctx = document.getElementById('statusChart').getContext('2d');

                    // Create the chart
                    const statusChart = new Chart(ctx, {
                        type: 'bar', // Change to 'line' or 'pie' for other chart types
                        data: {
                            // Labels for each category\
                            labels: ['Documents'],
                            datasets: [
                                {
                                    label: 'Pending',
                                    data: [pendingCount],  // Data for Pending
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)', 
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Approved',
                                    data: [approvedCount],  // Data for Approved
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Rejected',
                                    data: [rejectedCount],  // Data for Rejected
                                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                                    borderColor: 'rgba(255, 206, 86, 1)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>

            </div>
        </div>
    </div>
    <?php $this->endSection() ?>