<div class="col-sm-9 col-md-10 main">


	<form action="managepanels.php" method="get">

		<div class="row">
			<div class="form-group required">
				<label class="col-md-2 control-label" for="panelname">Panel Name</label>
				<div class="col-md-4">
					<input type="text" class="form-control required" name="panelname" placeholder="" required>
				</div>
				<div class="col-md-6"></div>
			</div>
		</div>



		<div class="row">
			<div class="form-group">
				<label class="col-md-2 control-label" for="catagory">Category</label>
				<div class="col-md-4">
					<input type="text" class="form-control" name="category" placeholder="">
				</div>
				<div class="col-md-6"></div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<label class="col-md-2 control-label" for="presenter">Presenter</label>
				<div class="col-md-4">
					<input type="text" class="form-control" name="presenter" placeholder="">
				</div>
				<div class="col-md-6"></div>
			</div>
		</div>


		<div class="row">
			<div class="form-group">
				<label class="col-md-2 control-label" for="presenterphone">Presenter Phone</label>
				<div class="col-md-4">
					<input type="tel" class="form-control" name="presenterphone" placeholder="">
				</div>
				<div class="col-md-6"></div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<label class="col-md-2 control-label" for="room">Room Number</label>
				<div class="col-md-4">
					<input type="text" class="form-control" name="room" placeholder="">
				</div>
				<div class="col-md-6"></div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<label class="col-md-2 control-label" for="age">Age Rating</label>
				<div class="col-md-4">
					<input type="text" class="form-control" name="age" placeholder="">
				</div>
				<div class="col-md-6"></div>
			</div>
		</div>


		<div class="row">
			<div class="form-group required">
				<label class="col-md-2 control-label" for="starttd">Start Time and Date</label>
				<div class="col-md-4">
					<input type="datetime-local" class="form-control required" name="starttd" placeholder="" required>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group required">
				<label class="col-md-2 control-label" for="endtd">End Time and Date</label>
				<div class="col-md-4">
					<input type="datetime-local" class="form-control required" name="endtd" placeholder="" required>
				</div>
			</div>
		</div>
		





		<input type="hidden" name="convoyear" value="<?php echo $convoyear; ?>">

		<input type="submit" value="Create Panel!"/>
	</form>


</div>
