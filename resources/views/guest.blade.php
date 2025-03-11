<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Container */
        .tracking-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Search Input */
        .input-group input {
            border-radius: 6px 0 0 6px;
            border-right: none;
        }
        .input-group .btn {
            border-radius: 0 6px 6px 0;
        }

        /* Adjust tracking entries */
        .tracking-entry {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
        }

        /* Date Column */
        .tracking-date {
            width: 160px;
            text-align: left;
            font-size: 14px;
            font-weight: 500;
            color: #555;
        }

        /* Center Icon */
        .tracking-line {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
        }

        .tracking-line i {
            font-size: 22px; 
            color: #4CAF50; 
        }

        /* Status and Remarks Column */
        .tracking-details {
            flex-grow: 1;
            min-width: 250px;
            padding-left: 20px;
        }

        .tracking-status {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .tracking-remark {
            font-size: 14px;
            color: #666;
            font-style: italic;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .tracking-date {
                width: 120px;
                font-size: 12px;
            }
            .tracking-status {
                font-size: 14px;
            }
            .tracking-remark {
                font-size: 12px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="tracking-container">
            <h4 class="text-center mb-3">Track your Salveo Barley Grass Order</h4>
    
            <form id="trackOrderForm">
                <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
                <div class="input-group mb-3">
                    <input type="text" name="order_no" id="order_no" class="form-control" placeholder="Enter Order No" required>
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </form>
    
            <div id="trackingResult" class="d-none">
                <h5 class="text-center text-muted" id="trackingAddress"></h5>
                <div id="trackingEntries"></div>
            </div>
    
            <div id="orderError" class="alert alert-danger d-none mt-3"></div>
        </div>
    </div>    

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("trackOrderForm").addEventListener("submit", function (e) {
                e.preventDefault();

                let orderNo = document.getElementById("order_no").value;
                document.getElementById("trackingResult").classList.add("d-none");
                document.getElementById("orderError").classList.add("d-none");

                fetch("{{ route('track.order.search') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ order_no: orderNo })
                })
                .then(response => response.json())
                .then(data => {
                    let trackingEntries = document.getElementById("trackingEntries");
                    trackingEntries.innerHTML = "";

                    if (data.error) {
                        document.getElementById("orderError").classList.remove("d-none");
                        document.getElementById("orderError").textContent = data.error;
                        return;
                    }

                    data.history.forEach(step => {
                    // Convert date format to "March 1, 2025 - 12:25 PM"
                    let dateObj = new Date(step.updated_at);
                    let formattedDate = dateObj.toLocaleDateString("en-US", {
                        month: "long", day: "numeric", year: "numeric"
                    });
                    let formattedTime = dateObj.toLocaleTimeString("en-US", {
                        hour: "numeric", minute: "2-digit", hour12: true
                    });

                    let remarkHtml = step.delivery_remarks ? `<div class="tracking-remark">"${step.delivery_remarks}"</div>` : '';

                    // Determine the correct icon based on order status
                    let iconClass = "";
                    if (step.order_status === "For Delivery") iconClass = "fa-truck-fast";
                    else if (step.order_status === "Re-Schedule Delivery") iconClass = "fa-clock";
                    else if (step.order_status === "Delivered") iconClass = "fa-check";
                    else if (step.order_status === "Cancelled") iconClass = "fa-x";

                    let html = `
                        <div class="tracking-entry">
                            <div class="tracking-date">${formattedDate}<br>${formattedTime}</div>
                            <div class="tracking-line">
                                <i class="fa ${iconClass}"></i>
                            </div>
                            <div class="tracking-details">
                                <div class="tracking-status">${step.order_status}</div>
                                ${remarkHtml}
                            </div>
                        </div>
                    `;
                    trackingEntries.innerHTML += html;
                });

                    document.getElementById("trackingResult").classList.remove("d-none");
                })
                .catch(error => {
                    document.getElementById("orderError").classList.remove("d-none");
                    document.getElementById("orderError").textContent = "An error occurred. Please try again.";
                });
            });
        });
    </script>
</body>
</html>
