<div id="content">
  <form>
    <div class="container-fluid">
      <div class="hed"><h1>Purchase Order</h1></div>
      <hr>
      <div class="row">
        <div class="col-md-4">
          <p class="p1">Order no :</p>
          <input type="text" class="form-control" required autocomplete="off">
        </div>
        <div class="col-md-4">
          <p class="p1">Currency :</p>   
          <select class="form-control"></select> 
        </div>
        <div class="col-md-4">
          <p class="p1">Date :</p>   
          <input type="date" class="form-control" name="">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <p class="p1">Due Days :</p>   
          <input type="text" class="form-control" name="">
        </div>
        <div class="col-md-4">
          <p class="p1">Due Date :</p>   
          <input type="date" class="form-control" name="">  
        </div>
      </div>
      <div class="row" style="margin-top: 2%;">
        <input class="offset-md-2 col-md-3" type="button" value="Add Row" id="bton" onclick="addRow('dataTable')" name="">
        <input class="col-md-3" type="button" value="Delete Row" id="bton" onclick="deleteRow('dataTable')" name="">
      </div>
      <hr>
        <div class="row" style="overflow-x: scroll;">
          <TABLE id="dataTable" width="100%" border="1" class="table table-hover">
            <thead>
              <tr>
                <th></th>
                <th>SlNo</th>
                <th>Barcode</th>
                <th>Product Name</th>
                <th>Product Code</th>
                <th>Quantity</th>
                <th>Free</th>
                <th>Unit/Qty</th>
                <th>Rate</th>
                <th>Unit/Rate</th>
                <th>Amount</th>
              </tr>
            </thead>
            <TR>
              <TD><input type="checkbox" name="chk"></TD>
              <TD></TD>
              <TD></TD>
              <TD></TD>
              <TD></TD>
              <TD></TD>
              <TD></TD>
              <TD></TD>
              <TD></TD>
              <TD></TD>
              <TD></TD>
            </TR>
          </TABLE>
        </div>
        <hr>
        <fieldset style="font-size: 14px;background: #f0f0f0; font-style: bolder">Payment
          <div class="row"> 
            <div class="col-md-3">
              <p class="p1" style="color: black">Old Balance :</p>
              <input type="text" class="form-control" required autocomplete="off">
            </div>
            <div class="col-md-3">
              <p class="p1" style="color: black">Bank/Cash :</p>
              <input type="text" class="form-control" required autocomplete="off">
            </div>
            <div class="col-md-3">
              <p class="p1" style="color: black">Paid Amount :</p>
              <input type="text" class="form-control" required autocomplete="off">
            </div>
            <div class="col-md-3">
              <p class="p1" style="color: black">Balance :</p>
              <input type="text" class="form-control" required autocomplete="off">
            </div>
          </div>
        </fieldset>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <p class="p1">Narration :</p>   
              <textarea class="form-control"></textarea>
          </div>
          <div class="col-md-6">
            <p class="p1">Transportation Company :</p>   
              <textarea class="form-control"></textarea>
          </div>            
        </div>
        <hr>
        <fieldset>
          <div class="row">
            <div class="col-md-6">
              <p class="p1">Total Qty :</p>
              <input type="text" class="form-control" name="">
            </div>
            <div class="col-md-6">
              <p class="p1">Total Amount :</p>
              <input type="text" class="form-control" name="">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <p class="p1">Tax Amount :</p>
              <input type="text" class="form-control" name="">
            </div>
            <div class="col-md-6">
              <p class="p1">Additional Cost :</p>
              <input type="text" class="form-control" name="">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <p class="p1">Bill Discount :</p>
              <input type="text" class="form-control" name="">
            </div>
            <div class="col-md-6">
              <p class="p1">Grand Total :</p>
              <input type="text" class="form-control" name="">
            </div>
          </div>
        </fieldset>
        <hr>
        <div class="row col-md-12 form-group txn-bottom-form" style=" box-shadow: 0 0 11px rgba(33,33,33,.2);">
          <div class="offset-md-4">
          <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
            <input class="btn btnormal1"type="submit" name="" value="Save">
            <input class="btn btnormal2" type="submit" name="" value="Delete">
            <input class="btn btnormal2" type="submit" name="" value="Clear">
            <input class="btn btnormal1" type="submit" name="" value="Close">
          </div>
        </div>
  </form>    
</div>
               <!--   <div class="row">                 
                  <div class="table-responsive">
                 <table class="table">
                  <tr>
                                                         </tr>
                                       <tr>
    </tr>
                 </table>
                 </div>
                 </div> -->
<!-- <table class="table table-dark">
  <thead>
  <tr>
                   <th>SL.NO</th>
                   <th>PRODUCT NAME</th> 
                   <th>PRODUCT CODE</th>
                   <th>PRODUCT RATE</th>
                   <th>PRUCHSE RATE</th>
                   <th>QTY</th>
                   <th>FREE QTY</th>
                   <th>UNIT/QTY</th>
                   <th>Q.V</th>
                   <th>DISCOUNT%</th>
                   <th>DISCOUNT</th>
                   <th>NET AMOUNT</th>
                   <th>TAX%</th>
                   <th>TAX AMOUNT</th>
                   <th>AMOUNT</th>
  </tr>
  </thead>
  <tbody>
  <tr>
     <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
       <td>50</td>
      <td>50</td>
      <td>50</td>
  </tr>
  <tr>
     <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
      <td>50</td>
       <td>50</td>
      <td>50</td>
      <td>50</td>
  </tr>
  </tbody>
</table>
 -->
<!--  <div class="table-responsive" style="">
  <table class="table">
     <tr>
       <th>SL.NO</th>
                   <th>PRODUCTNAME</th> 
                   <th>PRODUCTCODE</th>
                   <th>PRODUCTRATE</th>
                   <th>PRUCHSERATE</th>
                   <th>QTY</th>
                   <th>FREEQTY</th>
                   <th>UNIT/QTY</th>
                   <th>Q.V</th>
                   <th>DISCOUNT%</th>
                   <th>DISCOUNT</th>
                   <th>NETAMOUNT</th>
                   <th>TAX%</th>
                   <th>TAX AMOUNT</th>
                   <th>AMOUNT</th>
                  </tr>
                </table>
</div> -->
 <!-- <div class="row"> -->
<SCRIPT language="javascript">
    function addRow(tableID) 
    {
      var table = document.getElementById(tableID);
      var rowCount = table.rows.length;
      var row = table.insertRow(rowCount);
      var colCount = table.rows[0].cells.length;
      for(var i=0; i<colCount; i++) 
      {
        var newcell = row.insertCell(i);
        newcell.innerHTML = table.rows[1].cells[i].innerHTML;
        //alert(newcell.childNodes);
        switch(newcell.childNodes[0].type)
        {
          case "text":
            newcell.childNodes[0].value = "";
          break;
          case "checkbox":
            newcell.childNodes[0].checked = false;
          break;
          case "select-one":
            newcell.childNodes[0].selectedIndex = 0;
          break;
        }
      }
    }
    function deleteRow(tableID) 
    {
      try 
      {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++) 
        {
          var row = table.rows[i];
          var chkbox = row.cells[0].childNodes[0];
          if(null != chkbox && true == chkbox.checked) 
          {
            if(rowCount <= 1) 
            {
            alert("Cannot delete all the rows.");
            break;
            }
            table.deleteRow(i);
            rowCount--;
            i--;
          }
        }
      }
      catch(e) 
      {
        alert(e);
      }
    }
  </SCRIPT>
</HEAD>
<!--<BODY>-->
  <!--<INPUT type="button" value="Add Row" onclick="addRow('dataTable')"/>-->
  <!--<INPUT type="button" value="Delete Row" onclick="deleteRow('dataTable')"/>-->
  <!--<div class="scrollit">-->
  <!-- <tbody class="" style="overflow-y: scroll;"> -->
<!--  <TABLE  id="dataTable"  width="autocomplete" border="1" >
    <th>SL.NO</th>
    <th>PRODUCT NAME</th>
    <th>PRODUCT CODE</th>
    <th>PURCHASE RATE</th>
    <th>QUANTITY</th>
    <th>FREE QUANTITY</th>
    <th>UNIT/QTY</th>
    <th>G.V</th>
    <th>DISCOUNT%</th>
    <th>DISCOUNT</th>
    <th>NET AMOUNT</th>
    <th>TAX%</th>
    <th>TAX AMOUNT</th>
    <th>AMOUNT</th>
    <TR>
      <TD><input class="form-control" type="text" name="text"></TD>
      <TD><INPUT class="form-control" type="checkbox" name="chk"/></TD>
      <TD><INPUT class="form-control" type="text" name="txt"/></TD>
      <TD><INPUT class="form-control" type="text" name="txt"/></TD>
       <TD><input class="form-control" type="text" name="txt"/></TD>
      <TD>
        <SELECT name="country">
          <OPTION value="in">India</OPTION>
          <OPTION value="de">Germany</OPTION>
          <OPTION value="fr">France</OPTION>
          <OPTION value="us">United States</OPTION>
          <OPTION value="ch">Switzerland</OPTION>
        </SELECT>
      </TD>
    </TR>
  </TABLE>-->
  <!--</tbody>-->
  <!--</div>-->
<!--<div class="container-fluid">
            <INPUT type="button"  value="Add Row" onclick="addRow('dataTable')" />
            <INPUT type="button" value="Delete Row" onclick="deleteRow('dataTable')" />
            <TABLE id="dataTable" width="100%" border="1" class="table table-hover">
              <thead>
                  <tr>
                    <th></th>
                    <th>Sl No</th>
                    <th>Cash/Bank</th>
                    <th>Amount</th>
                    <th>Cheque No</th>
                    <th>Cheque Date</th>
                    <th>Sl No</th>
                    <th>Cash/Bank</th>
                    <th>Amount</th>
                    <th>Cheque No</th>
                    <th>Cheque Date</th>
                  </tr>
              </thead>
              <TR>
                <TD><INPUT type="checkbox" name="chk"/></TD>
                <TD> 1 </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
                <TD> <INPUT type="text" /> </TD>
              </TR>
            </TABLE>
          </div> -->
        </div>
      </div>
    </div>
  </div>        
</div>
      <!--         <div class="col-md-4">
              <p class="p1">Payment mode :</p>
<div>
  <input type="radio" id="huey" name="drone" value="huey"
         checked>
  <label for="huey">Cash</label>
<div>
  <input type="radio" id="dewey" name="drone" value="dewey">
  <label for="dewey">Credit</label>
</div>
<div>             
</div>
</div>
</div> -->