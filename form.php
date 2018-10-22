<?php

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
		"key: 8e1002008be8c6652e5fc397d8043ce3"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	/* if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	} */
	$response = json_decode($response)->rajaongkir->results;
	// print_r($response);
?>
<html>
	<body>
		<form>
			<div>
				provinsi
				<select name="provinsi" id="select_provinsi">
					<option value="">-pilih provinsi-</option>
				<?php
					foreach($response as $data){
						echo "<option value='{$data->province_id}'>{$data->province}</option>";
					}
				?>
				</select>
			</div>
			
			<br/>
			
			<div id="kabupaten">
				kabupaten
				<select name="kabupaten" id="select_kabupaten">
				</select>
			</div>
			<div id="courier">
				Courier
				<select name="courier" id="select_courier">
					<option value="jne">JNE</option>
					<option value="pos">POS</option>
					<option value="tiki">TIKI</option>
				</select>

				<br>
				berat
				<input type="number" name="berat" id="berat">
			</div>

			
				
			

					
						<input type="submit" value="submit" name="submit" id="submit">
					
		</form>
		<script src="jquery-3.3.1.js"></script>
		<script>
			$('#kabupaten').hide();
			$('#select_provinsi').on('change', function() {
				var id = this.value;
				if(id != ''){
					$('#kabupaten').show();
					$('#select_kabupaten').find('option').remove().end();
					$.ajax({
						type: 'GET', 
						url: 'http://localhost/rajaongkir/city.php', 
						data: { id: id }, 
						dataType: 'json',
						success: function (data) { 
							$.each(data, function(key, value) {   
								 $('#select_kabupaten').append($("<option></option>")
									.attr("value",value.city_id)
									.text(value.type+' '+value.city_name)); 
							});
							console.log(data);
							$('#select_kabupaten').change();
						}
					});
				}else{
					$('#kabupaten').hide();
					$('#courier').hide();
				}
			});

			$('select_kabupaten').on('change',function(){
				var id = this.value;
				$('#courier').show();
			});

			$('form').on('submit', function(){
				var city = $('#select_kabupaten').find(':selected').val();
				var courier = $('#select_courier').find(':selected').val();
				var weight = $('#berat').val();
				$.ajax({
					type: 'GET',
					url: 'http://localhost/rajaongkir/cost.php',
					data: {destination:city,  weight:weight,courier:courier},
					dataType: 'json',
					success: function(data){

						console.log(data);
						
					}
				});
				return false;
			});
		</script>
	</body>
</html>