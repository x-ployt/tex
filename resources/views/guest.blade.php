<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CSS --}}
    @include('include.css')
    @include('include.guest-css')
    
    <!-- CSRF Token for AJAX Requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5 bg-transparent">
        <!-- Centered Logo -->
        <div class="d-flex justify-content-center">
            <img src="{{ asset('photos/salveowell-logo.png') }}" alt="Salveowell Logo" class="img-fluid" style="max-width: 200px;">
        </div>
    
        <!-- Track and Trace Title -->
        <h2 class="text-center text-black mb-4 fw-bold fs-2">Track and Trace</h2>
    
        <!-- Tracking Form -->
        <form id="trackOrderForm">
            <div class="input-group mb-3">
                <input type="text" name="order_no" id="order_no" class="form-control form-control-lg" placeholder="Enter Order No" style="font-size: 16px;" required>
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    
        <!-- Tracking Card (Initially Hidden) -->
        <div class="card p-4 d-none" id="trackingCard">
            <!-- Tracking Result Section -->
            <div id="trackingResult" class="d-none">
                <h5 class="text-center text-muted" id="trackingAddress"></h5>
                <div class="timeline mt-3" id="trackingEntries"></div>
            </div>
    
            <!-- Error Message Section -->
            <div id="orderError" class="alert alert-danger d-none mt-3"></div>
        </div>
    </div>
    
    

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("trackOrderForm");
        const orderNoInput = document.getElementById("order_no");
        const trackingCard = document.getElementById("trackingCard");
        const trackingResult = document.getElementById("trackingResult");
        const trackingEntries = document.getElementById("trackingEntries");
        const orderError = document.getElementById("orderError");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        form.addEventListener("submit", function (e) {
            e.preventDefault();
            let orderNo = orderNoInput.value.trim();

            // Clear previous tracking results before fetching new data
            trackingEntries.innerHTML = "";
            trackingResult.classList.add("d-none");
            orderError.classList.add("d-none");

            // Show tracking card after successful search
            trackingCard.classList.remove("d-none");

            fetch("{{ route('track.order.search') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ order_no: orderNo })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    orderError.classList.remove("d-none");
                    orderError.textContent = data.error;
                    return;
                }

                let latestEntry = data.history.length > 0 ? data.history[0] : null;

                trackingEntries.innerHTML = data.history.map((step, index) => {
                    let dateObj = new Date(step.updated_at);
                    let formattedDate = new Intl.DateTimeFormat("en-US", { weekday: "long", month: "long", day: "numeric", year: "numeric" }).format(dateObj);
                    let formattedTime = new Intl.DateTimeFormat("en-US", { hour: "numeric", minute: "2-digit", hour12: true }).format(dateObj);

                    let iconClass = {
                        "For Delivery": "fa-truck-fast bg-blue",
                        "Re-Schedule Delivery": "fa-clock bg-yellow",
                        "Delivered": "fa-check bg-green",
                        "RTS": "fa-times bg-red"
                    }[step.order_status] || "fa-info-circle bg-secondary";

                    let showRiderDetailsButton = latestEntry && latestEntry.order_status === "Re-Schedule Delivery" && index === 0;

                    return `
                        <div class="time-label">
                            <span class="text-black">${formattedDate}</span>
                        </div>
                        <div>
                            <i class="fas ${iconClass}"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> ${formattedTime}</span>
                                <h3 class="timeline-header text-black">${step.order_status}</h3>
                                <div class="timeline-body">
                                    ${step.delivery_remarks ? `<p class="text-italic"><i>${step.delivery_remarks}</i></p>` : ''}
                                    ${showRiderDetailsButton ? ` 
                                        <button class="btn btn-sm btn-secondary viewRiderDetails" data-order-id="${data.order_no}">
                                            View Rider Details
                                        </button>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                }).join("");

                trackingResult.classList.remove("d-none");

                document.querySelectorAll(".viewRiderDetails").forEach(button => {
                    button.addEventListener("click", function () {
                        let orderId = this.getAttribute("data-order-id");

                        Swal.fire({
                            title: "Authenticate Order",
                            input: "text",
                            inputPlaceholder: "Enter your contact number",
                            showCancelButton: true,
                            confirmButtonText: "Verify",
                            cancelButtonText: "Cancel",
                            inputAttributes: {
                                minlength: "12",
                                maxlength: "12",
                                autocapitalize: "off",
                                autocorrect: "off",
                                autocomplete: "off"
                            },
                            preConfirm: (contactNumber) => {
                                return fetch("{{ route('track.order.verify') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": csrfToken
                                    },
                                    body: JSON.stringify({ order_no: orderId, customer_contact_number: contactNumber })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.error) {
                                        Swal.showValidationMessage(data.error);
                                        return false;
                                    }
                                    return data;
                                })
                                .catch(() => {
                                    Swal.showValidationMessage("An error occurred. Please try again.");
                                });
                            }
                        }).then((result) => {
                            if (result.isConfirmed && result.value) {
                                let rider = result.value.rider;
                                Swal.fire({
                                    title: "Rider Details",
                                    html: `
                                        <p><strong>Name:</strong> ${rider.name}</p>
                                        <p><strong>Contact Number:</strong> <a href="tel:${rider.contact_number}">${rider.contact_number}</a></p>
                                    `,
                                });
                            }
                        });
                    });
                });

            })
            .catch(() => {
                orderError.classList.remove("d-none");
                orderError.textContent = "An error occurred. Please try again.";
            });
        });
    });
    </script>

    {{-- Scripts --}}
    @include('include.js')
</body>
</html>
