<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Schedule Calendar | Admin</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
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

        .sidebar-item {
            position: relative;
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

        .sidebar-link:hover {
            color: var(--primary);
            background-color: rgba(78, 115, 223, 0.1);
            border-left-color: var(--primary);
        }

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

        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        .content-expanded {
            margin-left: 0;
        }

        /* Navbar Styles */
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

        .navbar-toggler {
            border: none;
            font-size: 1.25rem;
        }

        /* Card Styles */
        .card {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            color: var(--dark);
        }

        /* Calendar Custom Styles */
        #calendar {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
        }

        .fc-header-toolbar {
            margin-bottom: 1em;
        }

        .fc-toolbar-title {
            color: var(--dark);
        }

        .fc-button {
            background-color: white;
            border: 1px solid #ced4da;
            color: #495057;
        }

        .fc-button:hover {
            background-color: #e9ecef;
            color: #495057;
        }

        .fc-button-active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .fc-daygrid-day {
            background-color: white;
        }

        .fc-daygrid-day.fc-day-today {
            background-color: rgba(78, 115, 223, 0.1);
        }

        .fc-daygrid-event {
            cursor: pointer;
            font-weight: 500;
            border: none;
        }

        .fc-event-available {
            background-color: var(--success);
            color: white;
        }

        .fc-event-booked {
            background-color: var(--danger);
            color: white;
        }

        /* Status Legend */
        .status-legend {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 15px;
        }

        .legend-item {
            display: flex;
            align-items: center;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            margin-right: 5px;
            border-radius: 3px;
        }

        /* Bulk Actions */
        .bulk-actions {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Style for selected dates */
        .fc-day.selected-date {
            background-color: rgba(78, 115, 223, 0.2) !important;
        }

        /* Toggle Button */
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

        /* Selected Dates Display */
        #selectedDatesDisplay {
            margin-bottom: 20px;
        }

        /* Modal Styles */
        .modal-content {
            background-color: white;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #adb5bd;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6c757d;
        }
    </style>
</head>

<body>
    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar -->
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
                                <a class="dropdown-item" href="#" onclick="logout()">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fas fa-tachometer-alt"></i></span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fas fa-calendar-alt"></i></span>
                    <span class="sidebar-text">Schedule Management</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link active">
                    <span class="sidebar-icon"><i class="fas fa-calendar"></i></span>
                    <span class="sidebar-text">Calendar View</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fas fa-users"></i></span>
                    <span class="sidebar-text">User Management</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <span class="sidebar-icon"><i class="fas fa-cog"></i></span>
                    <span class="sidebar-text">Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="container-fluid">
            <!-- Header -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 mb-0 text-primary">
                        <i class="fas fa-calendar me-2"></i> Grand Schedule Calendar
                    </h1>
                </div>
                <div class="col-md-6 text-end">
                    <a href="#" class="btn btn-outline-primary me-2">
                        <i class="fas fa-list me-1"></i> List View
                    </a>
                </div>
            </div>

            <!-- Status Legend -->
            <div class="status-legend">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--success);"></div>
                    <span>Available</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--danger);"></div>
                    <span>Booked</span>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions">
                <div class="d-flex align-items-center gap-2">
                    <button id="applyBulk" class="btn btn-primary">
                        <i class="fas fa-check-circle me-1"></i> Apply to Selected
                    </button>
                    <button id="clearSelection" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Clear
                    </button>
                </div>
                <div class="text-muted">
                    <i class="fas fa-info-circle me-1"></i> Select dates by clicking and dragging
                </div>
            </div>

            <!-- Selected Dates Display -->
            <div id="selectedDatesDisplay" class="mb-3" style="display: none;">
                <div class="alert alert-info">
                    <strong>Selected Dates:</strong> <span id="selectedDatesList"></span>
                </div>
            </div>

            <!-- Calendar Card -->
            <div class="card shadow">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Details Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">
                        <i class="fas fa-calendar-day me-1"></i> Schedule Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Date:</label>
                        <p class="form-control-static" id="modalDate"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Day Type:</label>
                        <p class="form-control-static" id="modalDayType"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price:</label>
                        <p class="form-control-static" id="modalPrice"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status:</label>
                        <p class="form-control-static" id="modalStatus"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes:</label>
                        <p class="form-control-static" id="modalNotes"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Edit Modal -->
    <div class="modal fade" id="bulkEditModal" tabindex="-1" aria-labelledby="bulkEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkEditModalLabel">
                        <i class="fas fa-edit me-1"></i> Add New Schedule
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="bulkEditForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bulkDayType" class="form-label">Day Type</label>
                            <select class="form-select" id="bulkDayType" required>
                                <option value="weekday_weekend">Weekday & Weekend</option>
                                <option value="special_event">Special Event</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bulkPrice" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="bulkPrice" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="bulkStatusModal" class="form-label">Status</label>
                            <select class="form-select" id="bulkStatusModal" required>
                                <option value="available">Available</option>
                                <option value="booked">Booked</option>
                            </select>
                        </div>

                        <!-- Booked Information Fields (Hidden by Default) -->
                        <div id="bookedInfoFields" style="display: none;">
                            <div class="mb-3">
                                <label for="bulkBookedEmail" class="form-label">Booked Email</label>
                                <input type="email" class="form-control" id="bulkBookedEmail">
                            </div>
                            <div class="mb-3">
                                <label for="bulkBookedPhone" class="form-label">Booked Phone</label>
                                <input type="text" class="form-control" id="bulkBookedPhone">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bulkNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="bulkNotes" rows="3"></textarea>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> This will create schedules for <span
                                id="selectedDatesCount">0</span> selected dates.
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

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var selectedDates = [];
            var currentEvents = [];
            var isDragging = false;

            // Function to format date consistently
            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Function to parse date string and create local date
            function parseDate(dateStr) {
                const parts = dateStr.split('-');
                return new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                selectMirror: true,
                // Fix timezone issues
                timeZone: 'local',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                events: {
                    url: "{{ route('admin.grand-schedules.calendar-data') }}",
                    method: 'GET',
                    failure: function() {
                        alert('Error loading calendar data');
                    },
                    success: function(response) {
                        currentEvents = response;
                    }
                },
                select: function(info) {
                    console.log('Selection info:', info);

                    // Clear previous selection
                    selectedDates = [];

                    // Get start and end dates
                    const startDate = new Date(info.start);
                    const endDate = new Date(info.end);

                    // For all-day events, FullCalendar's end date is exclusive
                    // We need to include all days from start to end-1
                    const currentDate = new Date(startDate);

                    while (currentDate < endDate) {
                        const dateStr = formatDate(currentDate);
                        selectedDates.push(dateStr);
                        console.log('Added date:', dateStr);
                        currentDate.setDate(currentDate.getDate() + 1);
                    }

                    console.log('Selected dates:', selectedDates);
                    updateSelectedDates();
                },
                unselect: function(info) {
                    // Only clear if clicking outside selected dates
                    if (!isDragging) {
                        selectedDates = [];
                        updateSelectedDates();
                    }
                },
                eventClick: function(info) {
                    var event = info.event;
                    $('#modalDate').text(formatDate(event.start));
                    $('#modalDayType').text(event.extendedProps.day_type === 'weekday_weekend' ?
                        'Weekday & Weekend' : 'Special Event');
                    $('#modalPrice').text('Rp ' + event.title);
                    $('#modalStatus').text(event.extendedProps.status === 'available' ? 'Available' :
                        'Booked');
                    $('#modalNotes').text(event.extendedProps.notes || '-');

                    var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                    modal.show();
                },
                eventClassNames: function(arg) {
                    return ['fc-event-' + arg.event.extendedProps.status];
                },
                // Add date click handler for single date selection
                dateClick: function(info) {
                    // Only handle single clicks that aren't part of a drag
                    if (!info.jsEvent.detail || info.jsEvent.detail === 1) {
                        setTimeout(() => {
                            // Check if this was actually a single click (not part of drag)
                            if (selectedDates.length === 0 || selectedDates.length === 1) {
                                const dateStr = info.dateStr;
                                if (selectedDates.includes(dateStr)) {
                                    // Remove from selection
                                    selectedDates = selectedDates.filter(d => d !== dateStr);
                                } else {
                                    // Add to selection
                                    selectedDates = [dateStr];
                                }
                                updateSelectedDates();
                            }
                        }, 10);
                    }
                }
            });

            calendar.render();

            // Improved drag detection
            let mouseDownTime;
            calendarEl.addEventListener('mousedown', function() {
                mouseDownTime = Date.now();
                isDragging = false;
            });

            calendarEl.addEventListener('mousemove', function() {
                if (Date.now() - mouseDownTime > 100) { // Only consider it dragging after 100ms
                    isDragging = true;
                }
            });

            calendarEl.addEventListener('mouseup', function() {
                isDragging = false;
            });

            // Bulk actions
            $('#applyBulk').click(function() {
                if (selectedDates.length === 0) {
                    alert('Please select at least one date by clicking or dragging on the calendar.');
                    return;
                }

                // Initialize modal fields
                $('#bulkDayType').val('weekday_weekend');
                $('#bulkPrice').val('');
                $('#bulkStatusModal').val('available').trigger('change');
                $('#bulkNotes').val('');

                // Status change handler
                $('#bulkStatusModal').off('change').on('change', function() {
                    if ($(this).val() === 'booked') {
                        $('#bookedInfoFields').show();
                        $('#bulkBookedEmail').prop('required', true);
                        $('#bulkBookedPhone').prop('required', true);
                    } else {
                        $('#bookedInfoFields').hide();
                        $('#bulkBookedEmail').prop('required', false);
                        $('#bulkBookedPhone').prop('required', false);
                    }
                });

                // Update the count of selected dates
                $('#selectedDatesCount').text(selectedDates.length);

                // Show the bulk edit modal
                var bulkEditModal = new bootstrap.Modal(document.getElementById('bulkEditModal'));
                bulkEditModal.show();
            });

            // Handle form submission for bulk edit
            $('#bulkEditForm').submit(function(e) {
                e.preventDefault();

                var dayType = $('#bulkDayType').val();
                var price = $('#bulkPrice').val();
                var status = $('#bulkStatusModal').val();
                var notes = $('#bulkNotes').val();
                var bookedEmail = $('#bulkBookedEmail').val();
                var bookedPhone = $('#bulkBookedPhone').val();

                // Validate required fields
                if (!dayType || !price || !status) {
                    alert('Please fill in all required fields.');
                    return;
                }

                if (status === 'booked' && (!bookedEmail || !bookedPhone)) {
                    alert('Please provide both email and phone for booked status.');
                    return;
                }

                // Prepare the data to send
                var data = {
                    _token: "{{ csrf_token() }}",
                    dates: selectedDates,
                    day_type: dayType,
                    price: price,
                    status: status,
                    notes: notes
                };

                // Add booked info if status is booked
                if (status === 'booked') {
                    data.booked_email = bookedEmail;
                    data.booked_phone = bookedPhone;
                }

                // Send the AJAX request
                $.ajax({
                    url: "{{ route('admin.grand-schedules.bulk-store') }}",
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            alert('Successfully updated ' + selectedDates.length + ' dates!');
                            calendar.refetchEvents();

                            // Reset selection and UI
                            selectedDates = [];
                            updateSelectedDates();

                            // Hide the modal
                            var bulkEditModal = bootstrap.Modal.getInstance(document
                                .getElementById('bulkEditModal'));
                            bulkEditModal.hide();

                            // Reset form
                            $('#bulkEditForm')[0].reset();
                            $('#bookedInfoFields').hide();
                        } else {
                            alert('Error: ' + (response.message || 'Operation failed'));
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + (xhr.responseJSON.message || 'Server error'));
                    }
                });
            });

            // Clear selection
            $('#clearSelection').click(function() {
                selectedDates = [];
                updateSelectedDates();
                calendar.unselect();
            });

            // Update selected dates display
            function updateSelectedDates() {
                // Remove all highlights first
                $('.fc-day').removeClass('selected-date');

                // Add highlights to selected dates
                selectedDates.forEach(function(dateStr) {
                    $('.fc-day[data-date="' + dateStr + '"]').addClass('selected-date');
                });

                // Update UI feedback
                $('#clearSelection').toggle(selectedDates.length > 0);

                // Show/hide selected dates display
                if (selectedDates.length > 0) {
                    $('#selectedDatesDisplay').show();
                    $('#selectedDatesList').text(selectedDates.join(', '));
                } else {
                    $('#selectedDatesDisplay').hide();
                }

                console.log('Updated selected dates:', selectedDates);
            }

            // Sidebar toggle functionality
            $('#sidebarToggle').click(function() {
                $('#sidebar').toggleClass('sidebar-collapsed');
                $('#mainContent').toggleClass('content-expanded');
                $(this).html($('#sidebar').hasClass('sidebar-collapsed') ?
                    '<i class="fas fa-bars"></i>' : '<i class="fas fa-times"></i>');
            });

            // Close sidebar when clicking outside on mobile
            $(document).on('click', function(e) {
                if ($(window).width() <= 992 &&
                    !$(e.target).closest('#sidebar, #sidebarToggle').length &&
                    !$('#sidebar').hasClass('sidebar-collapsed')) {
                    $('#sidebar').addClass('sidebar-collapsed');
                    $('#mainContent').addClass('content-expanded');
                    $('#sidebarToggle').html('<i class="fas fa-bars"></i>');
                }
            });
        });

        // Dummy logout function
        function logout() {
            alert('Logout functionality would be implemented here');
        }
    </script>
</body>

</html>
