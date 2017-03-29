<?php 
include 'database_connection.php';
include 'distributor_bill.php';
include 'products.php';
include 'customer_bill.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="js/type-ahead.js"></script>
  
   <script src="js/distributor.js"></script>

<style type="text/css">
  .bs-example {
    font-family: sans-serif;
    position: relative;
    margin: 100px;
  }
  .typeahead, .tt-query, .tt-hint {
    border: 2px solid #CCCCCC;
    border-radius: 8px;
    font-size: 22px; /* Set input font size */
    height: 30px;
    line-height: 30px;
    outline: medium none;
    padding: 8px 12px;
    width: 250px;
  }
  .typeahead {
    background-color: #FFFFFF;
  }
  .typeahead:focus {
    border: 2px solid #0097CF;
  }
  .tt-query {
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
  }
  .tt-hint {
    color: #999999;
  }
  .tt-menu {
    background-color: #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    margin-top: 12px;
    padding: 8px 0;
    width: 422px;
  }
  .tt-suggestion {
    font-size: 22px;  /* Set suggestion dropdown font size */
    padding: 3px 20px;
  }
  .tt-suggestion:hover {
    cursor: pointer;
    background-color: #0097CF;
    color: #FFFFFF;
  }
  .tt-suggestion p {
    margin: 0;
  }
</style>

<script type="text/javascript">
  // var states = [ {"name": "AMUL", "mrp": "35"},
  //                 {"name": "VADILAL", "mrp": "30"},
  //                 {"name": "top", "mrp": "100"},
  // ];
var states;
  $.ajax({
      type: 'get',
      url: 'get_All_products.php',
      async:false,
      success: function (data) {
          states = JSON.parse(data);
      }
  });
</script>

</head>
<body>

<div class="container">
  <h2 onclick="set_mrp()">Distributor Bill</h2> 

  <table  class="table table-bordered" > 
            <thead>
              <tr>
                <th>PRODUCT NAME</th>
                <th>QUANTITY</th>
                <th>MRP</th>
                <th>RATE</th>
                <th>DISCOUNT</th>
                <th>ADD/REMOVE</th>
              </tr>
            </thead>
            <tbody >
            
                <tr>
                  <td><input type="text" class="form-control typeahead" onchange="set_mrp()"   id="demo1" name="product_name" style="text-transform:uppercase" data-provide="typeahead" required></td>
                  <td><input type="number" class="form-control" id="qty"  value="1" name="product_quantity[]" onchange="total_amount_calculator()" min="1" ></td>
                  <td><input type="number" class="form-control" id="mrp" onchange="total_amount_calculator()" value="1" name="product_mrp[]" min="1" ></td>
                  <td><input type="number" class="form-control" id="rate" onchange="total_amount_calculator()" value="1" name="product_discount[]" min="0"></td>
                  <td><input type="number" class="form-control" id="dsc" onchange="total_amount_calculator()" value="0" name="product_discount[]" min="0"></td>
                  <td><button type="button" onclick="add_product()" class="btn btn-success btn-sm" style="width: 96px;" >ADD</button></td>
                </tr>

            </tbody>
    </table>



  <br>   
    <form action="insert_distributor_bill.php" method="post">        
          <table id="billing_table" class="table table-bordered" > 
            <thead>
              <tr>
                <th>PRODUCT NAME</th>
                <th>QUANTITY</th>
                <th>MRP</th>
                <th>RATE</th>
                <th>DISCOUNT</th>
                <th>ADD/REMOVE</th>
              </tr>
            </thead>
            <tbody id="add_product">
            
                <!-- <tr>
                  <td><input type="text" class="form-control" id="product_name" name="product_name[]" style="text-transform:uppercase" data-provide="typeahead" required></td>
                  <td><input type="number" class="form-control" id="qty1"  value="1" name="product_quantity[]" onchange="total_amount_calculator()" min="1"></td>
                  <td><input type="number" class="form-control" id="mrp1" onchange="total_amount_calculator()" value="1" name="product_mrp[]" min="1" readonly></td>
                  <td><input type="number" class="form-control" id="dsc1" onchange="total_amount_calculator()" value="0" name="product_discount[]" min="0"></td>
                  <td><button type="button" class="btn btn-danger btn-sm" >REMOVE</button></td>
                </tr> -->

            </tbody>
          </table>
          
          <table class="table table-bordered">
            <tbody>
              <tr>
                 <td><b>TOTAL AMOUNT</b></td>
                <td style="font-weight: bold;" > <input type="number"   name="total_amount" class="form-control" id="total_amount" style="width: 178px;float: right;" required> </td> 
              </tr>
            </tbody>
          </table>
                
                <!-- <input type="text" name="bill_id" hidden="" value="<?= $bill_id ?>"> -->

                <div class="form-group">
                  <label for="email">Bill Id :</label>
                  <input type="text" class="form-control" name="bill_id" id="email"  required>
                </div>

                <div class="form-group">
                  <label for="email">Bill Date :</label>
                  <input type="date" name="date" class="form-control" name="date" id="email" style="text-transform:uppercase" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">GENERATE BILL</button>
    </form>
</div>


<br><br><br>


<script type="text/javascript">

var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;

    // an array that will be populated with substring matches
    matches = [];

    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');

    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str.name)) {
        matches.push(str.name);
      }
    });

    

    cb(matches);
  };
};



$('#demo1').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'states',
  source: substringMatcher(states)
});

////////////////////////
  

function set_mrp() {
        console.log("ddssssss");
        item_name_json = $("#demo1").val();
        // alert(item_name_json);
        for (var i = 0; i < states.length; i++){
          // look for the entry with a matching `code` value
          if (states[i].name == item_name_json){
             $("#mrp").val(states[i].mrp);
              return;
          }
          else{
            
          }
        }
        
    }

$("#demo1").change(function() {
            // alert("s");
    });


</script>  


  

</body>
</html>
