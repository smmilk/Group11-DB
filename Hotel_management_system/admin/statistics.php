<?php
$feedbackCursor = $feedbackCollection->find();

// Initialize arrays to store room types and their average ratings
$roomTypes = [];
$averageRatings = [];

// Process feedback data and calculate average ratings per room type
foreach ($feedbackCursor as $feedback) {
    $bookingId = $feedback['feedback_id'];
    $rating = $feedback['rating'];

    // Query MySQL to get room type
    $bookingQuery = "SELECT rooms.type FROM booking
                     INNER JOIN rooms ON booking.room_id = rooms.room_id
                     WHERE booking.booking_id = '$bookingId'";
    $bookingResult = mysqli_query($con, $bookingQuery);

    if ($bookingResult->num_rows > 0) {
        $row = $bookingResult->fetch_assoc();
        $roomType = $row['type'];

        // Initialize arrays for room types if not already done
        if (!isset($roomTypes[$roomType])) {
            $roomTypes[$roomType] = [];
            $averageRatings[$roomType] = 0;
        }

        // Add rating to the array for the corresponding room type
        $roomTypes[$roomType][] = $rating;
    }
}

// Calculate average ratings for each room type
foreach ($roomTypes as $roomType => $ratings) {
    $averageRatings[$roomType] = array_sum($ratings) / count($ratings);
}

// Convert data to JSON for use in JavaScript
$roomTypesJson = json_encode(array_keys($roomTypes));
$averageRatingsJson = json_encode(array_values($averageRatings));

?>

<!-- Create a canvas for the bar chart -->
<canvas id="roomRatingsChart" width="400" height="200"></canvas>

<script>
    // Retrieve data from PHP and create a bar chart using Chart.js
    var roomTypes = <?php echo $roomTypesJson; ?>;
    var averageRatings = <?php echo $averageRatingsJson; ?>;

    var ctx = document.getElementById('roomRatingsChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: roomTypes,
            datasets: [{
                label: 'Average Rating',
                data: averageRatings,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Average Ratings by Room Type',
                    font: {
                        size: 16
                    }
                }
            }
        }
    });
</script>
