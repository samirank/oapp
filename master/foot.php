</tr>
<tr>
	<td colspan="2" id="footer"></td>
</tr>
</table>
</div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/datatables.min.js"></script>
<script src="js/jquery.form-validator.min.js"></script>
<script>
	$(function() {
    // setup validate
    $.validate({
    	modules : 'sanitize, security',
    });
   // $.validate(); call function here or in the page where it is used

});
</script>

<script>
	$(document).ready( function () {
		$('#view-form').DataTable();
	});
</script>
</html>