<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .timeline {
            position: relative;
            list-style: none;
            padding-left: 0;
            margin: 20px auto;
            max-width: 600px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 4px;
            background: #ddd;
            transform: translateX(-50%);
        }
        .timeline-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            position: relative;
        }
        .timeline-item::before {
            content: '\f00c'; /* FontAwesome check */
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 18px;
            color: #ccc;
            background: white;
            padding: 5px;
            border-radius: 50%;
            z-index: 1;
        }
        .timeline-item.latest::before {
            color: #007bff; /* Highlight latest step */
            font-size: 20px;
            font-weight: bold;
        }
        .timeline-date {
            width: 40%;
            text-align: right;
            font-size: 14px;
            color: #666;
        }
        .timeline-status {
            width: 40%;
            text-align: left;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-processing { background: orange; color: white; }
        .status-for-delivery { background: blue; color: white; }
        .status-delivered { background: green; color: white; }
        .status-cancelled { background: red; color: white; }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
            <h3 class="text-center mb-3">Salveowell Order Tracker</h3>
    
            <form id="trackOrderForm">
                <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
                <div class="input-group mb-3">
                    <input type="text" name="order_no" id="order_no" class="form-control" placeholder="Enter Order No" required>
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </form>
    
            <div id="trackingResult" class="d-none">
                <h5 class="address text-center" id="trackingAddress"></h5>
                <ul class="timeline list-unstyled" id="trackingTimeline"></ul>
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
                let timeline = document.getElementById("trackingTimeline");
                timeline.innerHTML = "";

                if (data.error) {
                    document.getElementById("orderError").classList.remove("d-none");
                    document.getElementById("orderError").textContent = data.error;
                    return;
                }

                data.history.forEach((step, index) => {
                    let statusClass = "";
                    if (step.order_status === "Processing") statusClass = "status-processing";
                    else if (step.order_status === "For Delivery") statusClass = "status-for-delivery";
                    else if (step.order_status === "Delivered") statusClass = "status-delivered";
                    else if (step.order_status === "Cancelled") statusClass = "status-cancelled";

                    let latestClass = index === data.history.length - 1 ? "latest" : "";

                    // Convert date format to "March 1, 2025 - 12:25 PM"
                    let dateObj = new Date(step.updated_at);
                    let formattedDate = dateObj.toLocaleDateString("en-US", {
                        month: "long", day: "numeric", year: "numeric"
                    });
                    let formattedTime = dateObj.toLocaleTimeString("en-US", {
                        hour: "numeric", minute: "2-digit", hour12: true
                    });

                    let html = `
                        <li class="timeline-item ${latestClass}">
                            <span class="timeline-date">${formattedDate}<br>${formattedTime}</span>
                            <span class="timeline-status ${statusClass}">${step.order_status}</span>
                        </li>
                    `;
                    timeline.innerHTML += html;
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
