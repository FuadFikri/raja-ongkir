<?php

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "http://pro.rajaongkir.com/api/province",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
		"key: api-key"
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
	//print_r($response);
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
		</form>
		<script src="jquery-3.3.1.min.js"></script>
		<script>
			$('#kabupaten').hide();
			$('#select_provinsi').on('change', function() {
				var id = this.value;
				if(id != ''){
					$('#kabupaten').show();
					$('#select_kabupaten').find('option').remove().end();
					$.ajax({
						type: 'GET', 
						url: 'http://localhost/city.php', 
						data: { id: id }, 
						dataType: 'json',
						success: function (data) { 
							$.each(data, function(key, value) {   
								 $('#select_kabupaten').append($("<option></option>")
									.attr("value",value.city_id)
									.text(value.type+' '+value.city_name)); 
							});
							console.log(data);
						}
					});
				}else{
					$('#kabupaten').hide();
				}
			});
		</script>
	</body>
</html>