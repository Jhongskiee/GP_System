<?php
include 'connection.php';

$query = "SELECT DISTINCT equipdate FROM equipsched ORDER BY equipdate DESC";
$result = $conn->query($query);
?>

<tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= date("F d, Y", strtotime($row['equipdate'])) ?></td>
            <td>
                <button class="btn btn-primary btn-sm view-details" data-date="<?= $row['equipdate'] ?>">
                    View
                </button>
            </td>
        </tr>
    <?php } ?>
</tbody>
