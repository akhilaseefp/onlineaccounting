<div id="content">
	<form>
		<div class="container-fluid">
			<div class="hed"><h1>Physical Stock</h1></div>
			<hr>
			<div class="row">
				<div class="col-md-4">
					<p class="p1">VoucherNo :</p>
					<input type="text" class="form-control" required autocomplete="off">
				</div>
				<div class="col-md-4">
					<p class="p1">Date :</p>
					<input type="date" class="form-control" name="">
				</div>
			</div>
			<hr>
			<div class="row" style="overflow-x: scroll;">
				<table id="dataTable" width="100%" border="1" class="table table-hover">
					<thead>
						<tr>
							<th></th>
							<th>SLNO</th>
							<th>Product Name</th>
							<th>Product Code</th>
							<th>Quantity</th>
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
					</TR>
				</table>
			</div>
			<hr>
			<div class="row">
				<div class="offset-md-8 col-md-4">
					<p class="p1">Net Amount :</p>
					<input type="text" class="form-control" name="">
				</div>
			</div>
			<hr>
			<div class="row col-md-12 txn-bottom-form">
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-control-placeholder" for="contact-person">Narration :</label>
						<textarea class="form-control" style="line-height: 2.5"></textarea>
					</div>
					<p>
						<input type="radio" name="" id="sizeSmall" value="small"/>
						<label for="sizeSmall">Print After Save</label>
					</p>
				</div>
			</div>
			<hr>
			<div class="row col-md-12 form-group txn-bottom-form" style="box-shadow: 0 0 11px rgba(33,33,33,.2);">
				<div class="offset-md-4">
					<input class="btn btnormal1" type="submit" name="" value="Save">
					<input class="btn btnormal2" type="submit" name="" value="Delete">
					<input class="btn btnormal2" type="submit" name="" value="Clear">
					<input class="btn btnormal1" type="submit" name="" value="Close">
				</div>
			</div>
		</div>
	</form>
</div>