<?php
// Fetch data from MongoDB
$cursor = $feedbackCollection->find();
?>

<table class="table table-striped table-hover">
    <h1>Feedback</h1><hr>
    <tr>
        <th>Sr No</th>
        <th>Name</th>
        <th>Feedback</th>
        <th>Rating</th>
        <th>Timestamp</th>
    </tr>

    <?php
    foreach ($cursor as $document) {
    ?>
        <tr>
            <td><?php echo $document['feedback_id']; ?></td>
            <td><?php echo $document['guest_name']; ?></td>
            <td><?php echo $document['feedback_text']; ?></td>
            <td><?php echo $document['rating']; ?></td>
            <td><?php echo $document['timestamp']; ?></td>
        </tr>
    <?php
    }
    ?>

</table>
