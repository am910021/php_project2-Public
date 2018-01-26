function updateRow(){
	$('#table thead tr').addClass("info");
	$('#table tbody tr:odd').addClass("success");
	$('#table tbody tr:even').addClass("warning");
}

$(document).ready(function() {
	updateRow();
});