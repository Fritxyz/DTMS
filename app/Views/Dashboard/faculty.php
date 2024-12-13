<?php $this->extend('Layout/main') ?>

<?php $this->section('content') ?>
<link rel="stylesheet" href="assets/css/faculty.css">
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Faculty Dashboard</h3>
                <h6 class="op-7 mb-2">Overview of Pending and Reviewed Documents</h6>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-folder"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Documents</p>
                                    <h4 class="card-title">1,294</h4>
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
                                    <p class="card-category">Pending Review</p>
                                    <h4 class="card-title">56</h4>
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
                                    <h4 class="card-title">1,245</h4>
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
                                <div class="icon-big text-center icon-danger bubble-shadow-small">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Rejected</p>
                                    <h4 class="card-title">67</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Incoming Documents Section -->
        <div class="row row-widt">
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Incoming Documents</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <!-- Sample Incoming Document -->
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Research Proposal:</strong> AI Project<br>
                                    <small>Submitted by: Jimmy Denis</small>
                                </div>
                                <div>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#documentModal"
                                        onclick="showDocument('Jimmy Denis', 'AI Project', 'files/ai_project_proposal.pdf')">
                                        View
                                    </button>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#feedbackModal"
                                        onclick="setDocumentFeedback('Jimmy Denis', 'AI Project')">
                                        Review & Feedback
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Viewing Documents -->
        <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="documentModalLabel">Document Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Submitted By:</strong> <span id="docSubmitter"></span></p>
                        <p><strong>Document:</strong> <span id="docDetails"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a id="docDownload" href="#" download class="btn btn-primary">Download</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Feedback (Review & Submit) -->
        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalLabel">Submit Feedback</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="feedbackForm">
                            <div class="mb-3">
                                <label for="feedbackStatus" class="form-label">Status</label>
                                <select class="form-select" id="feedbackStatus" required>
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                </select>
                            </div>
                            <div class="mb-3" id="feedbackTextSection">
                                <label for="feedbackText" class="form-label">Feedback</label>
                                <textarea class="form-control" id="feedbackText" rows="3"
                                    placeholder="Provide feedback on the document"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitFeedback()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Script to Populate Modal -->
<script>
function showDocument(submitter, details, fileUrl) {
    document.getElementById('docSubmitter').textContent = submitter;
    document.getElementById('docDetails').textContent = details;
    document.getElementById('docDownload').href = fileUrl;
}

function setDocumentFeedback(submitter, details) {
    // Set document details in feedback modal
    document.getElementById('feedbackStatus').value = 'approved'; // default to 'approve'
    document.getElementById('feedbackText').value = ''; // Clear feedback input
    document.getElementById('feedbackTextSection').style.display = 'none'; // Hide feedback section initially
}

function submitFeedback() {
    const status = document.getElementById('feedbackStatus').value;
    const feedback = document.getElementById('feedbackText').value;
    if (status === 'rejected' && feedback === '') {
        alert('Please provide feedback if you reject the document.');
        return;
    }

    // Simulate feedback submission (e.g., AJAX to server)
    alert('Feedback Submitted: Status: ' + status + (status === 'rejected' ? ', Feedback: ' + feedback : ''));

    // Close modal
    $('#feedbackModal').modal('hide');
}

document.getElementById('feedbackStatus').addEventListener('change', function() {
    // Toggle visibility of feedback section based on status
    if (this.value === 'rejected') {
        document.getElementById('feedbackTextSection').style.display = 'block';
    } else {
        document.getElementById('feedbackTextSection').style.display = 'none';
    }
});
</script>

<?php $this->endSection() ?>