<?php 
$total = count($registered_devices);
$mapOSVersion = array();
$mapDeviceModel = array();
$deviceIds = array();

for ($i=0; $i < $total; $i++) { 
	$obj = $registered_devices[$i];
	$deviceIds[] = $obj->device_token;
	if( ! isset( $mapOSVersion[$obj->os_version] )){
		$mapOSVersion[$obj->os_version] = 0;
	}
	$mapOSVersion[$obj->os_version] = $mapOSVersion[$obj->os_version] + 1;

	if( ! isset( $mapDeviceModel[$obj->device_model] )){
		$mapDeviceModel[$obj->device_model] = 0;
	}
	$mapDeviceModel[$obj->device_model] = $mapDeviceModel[$obj->device_model] + 1;
}

?>

<?php //var_dump($mapOSVersion); ?>
<br>
<?php //var_dump ($mapDeviceModel); ?>
<b>Total registered devices: <?php echo $total; ?></b> <br>
<b>Total notified devices: <span id='total_sent'>0</span></b> <br>
<button id='send_to_all' onclick="sendToAllDevices()">Notify to <?php echo $total; ?> devices</button>

<script type="text/javascript">
	var deviceIds = <?php echo json_encode($deviceIds); ?>;

	function sendToAllDevices(){
		var c = 0, sentc = 0;
		var device_tokens = [];
		var h = function(rs){
		   // console.log(rs);
		};
		for(var i in deviceIds){
		    //console.log(deviceIds[i]);
		    c++;
		    device_tokens.push(deviceIds[i]);
		    if(c % 10 === 0){        
		        $.post('http://nguyentantrieu.info/i2tree/index.php/device/notify_to_device',{'device_tokens':device_tokens.join('&&&')},h);
		        device_tokens = [];
		        sentc += 10;
		        $('#total_sent').html(sentc);
		    }
		    
		}
		//console.log(c);
		//console.log(sentc);

		var i = sentc;
		device_tokens = [];
		while(i < c){
		    //console.log(deviceIds[i]);
		    device_tokens.push(deviceIds[i]);
		    i++;
		    sentc = i;
		}
		$.post('http://nguyentantrieu.info/i2tree/index.php/device/notify_to_device',{'device_tokens':device_tokens.join('&&&')},h);
		$('#total_sent').html(sentc);
		   
	}
</script>

<?php echo $table_html; ?>