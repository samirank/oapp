<?php
include 'master/head.php';
include 'master/db.php';
?>
<td id="content">
    <form action="process.php" method="post">
        <table id="view-form" cellspacing="0">
            <tr>
                <th>Slno</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Phone No</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Experience</th>                
                <th colspan="2">Action</th>
            </tr>
            <?php
            $count=1;
            $result = mysqli_query($con,"select * from doctors");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row["doc_name"]; ?></td>
                        <td><?php echo $row["gender"]; ?></td>
                        <td><?php echo $row["address"]; ?></td>
                        <td><?php echo $row["ph_no"]; ?></td>
                        <td><?php echo $row["designation"]; ?></td>
                        <td><?php echo $row["dept"]; ?></td>
                        <td><?php echo $row["exp"]; ?> years</td>
                        <form action="process.php" method="POST"></form>
                        <td>
                            <input type="text" hidden value="<?php echo $row['doc_id']; ?>" name="doc_id">
                            <select name="action">
                            <option value="schedule">Manage Schedule</option>
                            <option value="Edit">Edit</option>
                            <option value="delete">Delete</option>
                        </select></td>
                        <td><button type="submit" name="doc_view_action">Go</button></td>
                    </tr>
                    <?php
                    $count++;
                }
            } else {
                echo '<tr><td colspan="10" style="text-align:center;">No records found !</td></tr>';
            }
            ?>
        </table>
    </form>
</td>
<?php
include 'master/foot.php';
?>             