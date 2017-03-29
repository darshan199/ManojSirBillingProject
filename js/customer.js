product_quantity_index = 1;
product_mrp_index = 1;
product_discount_index = 1;
// product_list = null;

function add_product() {
	name_temp = $("#demo1").val();
	mrp_temp = $("#mrp").val();
	qty_temp =  $("#qty").val();
	dsc_temp =  $("#dsc").val();
	product_quantity_index++;product_mrp_index++;product_discount_index++;
	$("#add_product").append(""+
		'<tr>'+
          '<td><input type="text" value="'+name_temp+'" class="form-control" id="usr" name="product_name[]" style="text-transform:uppercase" required></td>'+
          '<td><input type="number" value="'+qty_temp+'" class="form-control" id="qty'+product_quantity_index+'" value="0" name="product_quantity[]" onchange="total_amount_calculator()" min="1" ></td>'+
          '<td><input type="number" value="'+mrp_temp+'"  class="form-control" id="mrp'+product_mrp_index+'" value="0" name="product_mrp[]" onchange="total_amount_calculator()" min="1" readonly></td>'+
          '<td><input type="number" value="'+dsc_temp+'" class="form-control" id="dsc'+product_discount_index+'" value="0" name="product_discount[]" onchange="total_amount_calculator()" min="0"></td>'+
          '<td><button type="button" class="btn btn-danger btn-sm" onclick="$(this).parent().parent().remove();total_amount_calculator();">REMOVE</button></td>'+
        '</tr>'
	);
	total_amount_calculator()
}

function total_amount_calculator() {
	var rowCount = $('#billing_table tr').length;
	result = 0;
	for(i=1;i<rowCount;i++){			
		 	// result	+= parseFloat($('#qty'+i).val()) * parseFloat($('#mrp'+i).val()) - parseFloat($('#dsc'+i).val());
			result	+= parseFloat($("#add_product tr:nth-child("+i+") td:nth-child(2)").children().val()) * parseFloat($("#add_product tr:nth-child("+i+") td:nth-child(3)").children().val()) - parseFloat($("#add_product tr:nth-child("+i+") td:nth-child(4)").children().val());
	}
	 $("#total_amount").val(result);
}

// function dd(e){
// 	if(e.which == 13) {
//         $("#demo1").val('');

//     }
// }


 