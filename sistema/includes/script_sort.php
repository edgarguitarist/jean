<!-- datatables -->
<script src="vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/DT_bootstrap.js"></script>
<script>
	/* Table initialisation */


	var position_sort_table = position_sort_table ?? 3
	var order_sort_table = order_sort_table ?? "desc"

	$(document).ready(function() {
		$('#example').dataTable({
			"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
			"sPaginationType": "bootstrap", //Cambiar a Bulma
			"oLanguage": {
				"sLengthMenu": "_MENU_ &nbsp; &nbsp; Registros por pagina"
			},
			"order": [
				[position_sort_table, order_sort_table]
			]
		});
	});
</script>