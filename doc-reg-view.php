<?php
include 'master/head.php';
?>
<td id="content">
    <h1>About Us</h1>
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
                <th>Specialization</th>
                <th>Experience</th>                
                <th colspan="2">Action</th>
            </tr>
            <?php
            $count=1;
            $result = mysqli_query("select * from doctors");
            if (mysql_num_rows($result) > 0) {
                while ($row = mysql_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row["doc_name"] ?></td>
                        <td><?php echo $row["gender"] ?></td>
                        <td><?php echo $row["address"] ?></td>
                        <td><?php echo $row["ph_no"] ?></td>
                        <td><?php echo $row["designation"] ?></td>
                        <td><?php echo $row["dept"] ?></td>
                        <td><?php echo $row["specialisation"] ?></td>
                        <td><?php echo $row["expr"] ?></td>
                        <td><a href="">Edit</a></td>
                        <td><a href="">Delete</a></td>
                    </tr>
                    <?php
                    $count++;
                }
            } else {
                echo '<tr><td colspan="11" style="text-align:center;">No records found !</td></tr>';
            }
            ?>
        </table>
    </form>
</td>
<?php
include 'master/foot.php';
?>             