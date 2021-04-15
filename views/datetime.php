<div class="timestamp-wrap">
	<label>
		<span class="screen-reader-text">Tag</span>
		<input type="text" id="ccal-jj" name="ccal-jj" value="<?php echo date("d", $event_timestamp); ?>" size="2" maxlength="2" style="width: 35px;" autocomplete="off" class="form-required">
	</label>
	<label>
		<span class="screen-reader-text">Monat</span>
		<select class="form-required" id="ccal-mm"  style="width: 90px;" name="ccal-mm">
			<option value="01" data-text="Jan" <?php if (date("n", $event_timestamp) == "1") echo "selected=\"selected\"";?>>01-Jan</option>
			<option value="02" data-text="Feb" <?php if (date("n", $event_timestamp) == "2") echo "selected=\"selected\"";?>>02-Feb</option>
			<option value="03" data-text="Mrz" <?php if (date("n", $event_timestamp) == "3") echo "selected=\"selected\"";?>>03-Mrz</option>
			<option value="04" data-text="Apr" <?php if (date("n", $event_timestamp) == "4") echo "selected=\"selected\"";?>>04-Apr</option>
			<option value="05" data-text="Mai" <?php if (date("n", $event_timestamp) == "5") echo "selected=\"selected\"";?>>05-Mai</option>
			<option value="06" data-text="Jun" <?php if (date("n", $event_timestamp) == "6") echo "selected=\"selected\"";?>>06-Jun</option>
			<option value="07" data-text="Jul" <?php if (date("n", $event_timestamp) == "7") echo "selected=\"selected\"";?>>07-Jul</option>
			<option value="08" data-text="Aug" <?php if (date("n", $event_timestamp) == "8") echo "selected=\"selected\"";?>>08-Aug</option>
			<option value="09" data-text="Sep" <?php if (date("n", $event_timestamp) == "9") echo "selected=\"selected\"";?>>09-Sep</option>
			<option value="10" data-text="Okt" <?php if (date("n", $event_timestamp) == "10") echo "selected=\"selected\"";?>>10-Okt</option>
			<option value="11" data-text="Nov" <?php if (date("n", $event_timestamp) == "11") echo "selected=\"selected\"";?>>11-Nov</option>
			<option value="12" data-text="Dez" <?php if (date("n", $event_timestamp) == "12") echo "selected=\"selected\"";?>>12-Dez</option>
		</select>
	</label>
	<label>
		<span class="screen-reader-text">Jahr</span>
		<input type="text" id="ccal-aa" name="ccal-aa" value="<?php echo date("Y", $event_timestamp); ?>" size="4" maxlength="4" style="width: 50px;" autocomplete="off" class="form-required">
	</label><br>
	<label>
		<span class="screen-reader-text">Stunde</span>
		<input type="text" id="ccal-hh" name="ccal-hh" value="<?php echo date("H", $event_timestamp); ?>" size="2" maxlength="2" style="width: 35px;" autocomplete="off" class="form-required">
	</label>
	:
	<label>
		<span class="screen-reader-text">Minute</span>
		<input type="text" id="ccal-mn" name="ccal-mn" value="<?php echo date("i", $event_timestamp); ?>" size="2" maxlength="2" style="width: 35px;" autocomplete="off" class="form-required">
	</label>
</div>
