<?php $this->extend('Layout/main') ?>

<?php $this->section('content') ?>
<link rel="stylesheet" href="assets/css/custom.css" />

<div class="row">
    <!-- Document Tracking Section -->
    <div class="card-body p-0">
        <button class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card">
            <span class="fa fa-sync-alt" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Refresh"></span>
        </button>
        <div class="table-responsive">
            <!-- Document Tracking Table -->
            <table class="table align-items-center mb-0">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Document ID</th>
                        <th scope="col">Title</th>
                        <th scope="col" class="text-end">Date Submitted</th>
                        <th scope="col" class="text-end">Document Type</th>
                        <th scope="col" class="text-end">Current Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">RP-00123</th>
                        <td>Research Proposal: AI in Healthcare</td>
                        <td class="text-end">Dec 01, 2024, 3:15 PM</td>
                        <td class="text-end">Research Proposal</td>
                        <td class="text-end">
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1"
                                    data-bs-toggle="dropdown">
                                    Pending Review
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                    <a class="dropdown-item" href="#">Approved</a>
                                    <a class="dropdown-item" href="#">View</a>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">RP-00124</th>
                        <td>Research Project: Data Analysis Tools</td>
                        <td class="text-end">Nov 30, 2024, 10:45 AM</td>
                        <td class="text-end">Research Project</td>
                        <td class="text-end">
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1"
                                    data-bs-toggle="dropdown">
                                    Pending Review
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                    <a class="dropdown-item" href="#">Approved</a>
                                    <a class="dropdown-item" href="#">View</a>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">NP-00125</th>
                        <td>Notice to Proceed: Research Funding Allocation</td>
                        <td class="text-end">Nov 29, 2024, 4:30 PM</td>
                        <td class="text-end">Notice to Proceed</td>
                        <td class="text-end">
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1"
                                    data-bs-toggle="dropdown">
                                    Pending Review
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                    <a class="dropdown-item" href="#">Approved</a>
                                    <a class="dropdown-item" href="#">View</a>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">RP-00126</th>
                        <td>Research Proposal: Quantum Computing</td>
                        <td class="text-end">Nov 28, 2024, 11:00 AM</td>
                        <td class="text-end">Research Proposal</td>
                        <td class="text-end">
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1"
                                    data-bs-toggle="dropdown">
                                    Pending Review
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                    <a class="dropdown-item" href="#">Approved</a>
                                    <a class="dropdown-item" href="#">View</a>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">RP-00127</th>
                        <td>Research Project: Environmental Impact Study</td>
                        <td class="text-end">Nov 27, 2024, 2:00 PM</td>
                        <td class="text-end">Research Project</td>
                        <td class="text-end">
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1"
                                    data-bs-toggle="dropdown">
                                    Pending Review
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                                    <a class="dropdown-item" href="#">Approved</a>
                                    <a class="dropdown-item" href="#">View</a>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<?php $this->endSection() ?>