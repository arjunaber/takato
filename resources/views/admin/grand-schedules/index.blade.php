<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Schedule Management | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #36b9cc;
            --dark: #343a40;
            --light: #f8f9fa;
        }

        body {
            background-color: #f8f9fa;
            color: #212529;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: white;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s;
            z-index: 1000;
            padding-top: 70px;
        }

        .sidebar-collapsed {
            margin-left: -250px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #495057;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            color: var(--primary);
            background-color: rgba(78, 115, 223, 0.1);
            border-left-color: var(--primary);
        }

        .sidebar-icon {
            margin-right: 10px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-text {
            flex-grow: 1;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        .content-expanded {
            margin-left: 0;
        }

        /* Navbar */
        .navbar {
            height: 70px;
            background: white;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 0 20px;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
        }

        /* Utility Classes */
        .bg-gradient-primary {
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            background-size: cover;
        }

        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1100;
            background: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            cursor: pointer;
        }

        /* Status Badge Colors */
        .badge-event {
            background-color: #F59E0B;
            /* Gold/Orange */
            color: white;
        }
    </style>
</head>

<body>
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">TAKATO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> Admin
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fas fa-tachometer-alt"></i></span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.grand-schedules.index') }}" class="sidebar-link active">
                    <span class="sidebar-icon"><i class="fas fa-calendar-alt"></i></span>
                    <span class="sidebar-text">Schedule Management</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.grand-schedules.calendar') }}" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fas fa-calendar"></i></span>
                    <span class="sidebar-text">Calendar View</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content" id="mainContent">
        <div class="container-fluid">
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 mb-0 text-primary">
                        <i class="fas fa-calendar-alt me-2"></i> Grand Schedule Management
                    </h1>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-plus-circle me-1"></i> Add New Schedule
                    </h6>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="bulkAddToggle">
                        <label class="form-check-label" for="bulkAddToggle">Bulk Add Mode</label>
                    </div>
                </div>
                <div class="card-body">
                    <form id="addScheduleForm" action="{{ route('admin.grand-schedules.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="col-md-2">
                                <label for="day_type" class="form-label">Day Type</label>
                                <select class="form-select" id="day_type" name="day_type" required>
                                    @foreach ($dayTypes as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="price" class="form-label">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="price" name="price"
                                        min="0" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select status-select" id="status" name="status" required>
                                    @foreach ($statuses as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="notes" class="form-label">Notes</label>
                                <input type="text" class="form-control" id="notes" name="notes"
                                    placeholder="Optional">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-plus me-1"></i> Add
                                </button>
                            </div>
                        </div>

                        <div class="booking-details-fields row g-3 mt-1"
                            style="display: none; background-color: #fff3cd; padding: 10px; border-radius: 5px;">
                            <div class="col-md-6">
                                <label class="form-label text-warning-emphasis fw-bold">Booked Name</label>
                                <input type="text" class="form-control" name="booked_name"
                                    placeholder="Nama Tamu / Pemesan">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-warning-emphasis fw-bold">Contact Info</label>
                                <input type="text" class="form-control" name="booked_contact"
                                    placeholder="No. WA / Email">
                            </div>
                        </div>

                        <div id="bulkAddFields" class="row g-3 mt-3" style="display: none;">
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                            <div class="col-md-9">
                                <label class="form-label">Days of Week</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                id="day_{{ strtolower($day) }}" name="days[]"
                                                value="{{ strtolower($day) }}"
                                                @if (in_array(strtolower($day), ['saturday', 'sunday'])) checked @endif>
                                            <label class="form-check-label"
                                                for="day_{{ strtolower($day) }}">{{ substr($day, 0, 3) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-1"></i> Schedules List
                    </h6>
                    <div class="d-flex">
                        <input type="text" id="searchInput" class="form-control form-control-sm me-2"
                            placeholder="Search...">
                        <select id="statusFilter" class="form-select form-select-sm" style="width: 140px;">
                            <option value="">All Status</option>
                            @foreach ($statuses as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="schedulesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Notes / Booked By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->date->format('Y-m-d') }}</td>
                                        <td>{{ $schedule->date->format('D') }}</td>
                                        <td>{{ $dayTypes[$schedule->day_type] ?? $schedule->day_type }}</td>
                                        <td>Rp {{ number_format($schedule->price) }}</td>
                                        <td>
                                            @if ($schedule->status == 'available')
                                                <span class="badge bg-success">Available</span>
                                            @elseif($schedule->status == 'booked')
                                                <span class="badge bg-danger">Booked</span>
                                            @elseif($schedule->status == 'event')
                                                <span class="badge badge-event">Event</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $schedule->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($schedule->status == 'booked' && $schedule->booked_name)
                                                <strong>{{ $schedule->booked_name }}</strong><br>
                                                <small class="text-muted">{{ $schedule->booked_contact }}</small>
                                            @else
                                                {{ $schedule->notes ?? '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary edit-btn"
                                                data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="{{ $schedule->id }}"
                                                data-date="{{ $schedule->date->format('Y-m-d') }}"
                                                data-day_type="{{ $schedule->day_type }}"
                                                data-price="{{ $schedule->price }}"
                                                data-status="{{ $schedule->status }}"
                                                data-notes="{{ $schedule->notes }}"
                                                data-booked_name="{{ $schedule->booked_name ?? '' }}"
                                                data-booked_contact="{{ $schedule->booked_contact ?? '' }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $schedules->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="fas fa-edit me-1"></i> Edit Schedule
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_date" class="form-label">Date</label>
                            <input type="text" class="form-control" id="edit_date" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit_day_type" class="form-label">Day Type</label>
                            <select class="form-select" id="edit_day_type" name="day_type" required>
                                @foreach ($dayTypes as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="edit_price" name="price"
                                    min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select status-select" id="edit_status" name="status" required>
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="booking-details-fields mb-3 p-3 bg-light border rounded" style="display: none;">
                            <div class="mb-2">
                                <label class="form-label fw-bold">Booked Name</label>
                                <input type="text" class="form-control" id="edit_booked_name" name="booked_name">
                            </div>
                            <div>
                                <label class="form-label fw-bold">Contact Info</label>
                                <input type="text" class="form-control" id="edit_booked_contact"
                                    name="booked_contact">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_notes" class="form-label">Notes</label>
                            <input type="text" class="form-control" id="edit_notes" name="notes">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#schedulesTable').DataTable({
                responsive: true,
                dom: '<"top"f>rt<"bottom"lip><"clear">',
                pageLength: 25,
                ordering: false, // Matikan sorting JS karena data sudah di-sort backend (pagination)
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search...",
                }
            });

            // Status filter
            $('#statusFilter').change(function() {
                table.column(4).search(this.value).draw();
            });

            // Search input
            $('#searchInput').keyup(function() {
                table.search($(this).val()).draw();
            });

            // Bulk add toggle
            $('#bulkAddToggle').change(function() {
                if (this.checked) {
                    $('#bulkAddFields').show();
                    $('#date').attr('name', 'start_date');
                } else {
                    $('#bulkAddFields').hide();
                    $('#date').attr('name', 'date');
                }
            });

            // Show/Hide Booking Fields Logic
            function toggleBookingFields(selectElement) {
                var form = $(selectElement).closest('form');
                if ($(selectElement).val() === 'booked') {
                    form.find('.booking-details-fields').slideDown();
                } else {
                    form.find('.booking-details-fields').slideUp();
                    // Optional: Clear fields when hidden
                    // form.find('.booking-details-fields input').val('');
                }
            }

            // Bind change event to all status selects
            $('.status-select').change(function() {
                toggleBookingFields(this);
            });

            // Edit modal handler
            $('.edit-btn').click(function() {
                var route = "{{ route('admin.grand-schedules.update', ':id') }}";
                route = route.replace(':id', $(this).data('id'));

                $('#editForm').attr('action', route);
                $('#edit_date').val($(this).data('date'));
                $('#edit_day_type').val($(this).data('day_type'));
                $('#edit_price').val($(this).data('price'));

                var status = $(this).data('status');
                $('#edit_status').val(status);

                $('#edit_notes').val($(this).data('notes'));
                $('#edit_booked_name').val($(this).data('booked_name'));
                $('#edit_booked_contact').val($(this).data('booked_contact'));

                // Trigger manual change to show/hide fields correctly
                toggleBookingFields($('#edit_status'));
            });

            // Sidebar toggle functionality
            $('#sidebarToggle').click(function() {
                $('#sidebar').toggleClass('sidebar-collapsed');
                $('#mainContent').toggleClass('content-expanded');

                if ($('#sidebar').hasClass('sidebar-collapsed')) {
                    $(this).html('<i class="fas fa-bars"></i>');
                } else {
                    $(this).html('<i class="fas fa-times"></i>');
                }
            });

            // Close sidebar when clicking outside on mobile
            $(document).click(function(e) {
                if ($(window).width() <= 992) {
                    if (!$(e.target).closest('#sidebar, #sidebarToggle').length &&
                        !$('#sidebar').hasClass('sidebar-collapsed')) {
                        $('#sidebar').addClass('sidebar-collapsed');
                        $('#mainContent').addClass('content-expanded');
                        $('#sidebarToggle').html('<i class="fas fa-bars"></i>');
                    }
                }
            });
        });
    </script>
</body>

</html>
