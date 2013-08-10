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

<b>Tổng số smartphone đã cài app: <span id='total_devices' style="color:red;font-weight:bolder;font-size:18px;">0</span></b> &nbsp
<a href="https://play.google.com/store/apps/details?id=com.mc2ads.browser4x" target="_blank">Link Download App hoặc Search Play Store với từ khóa 'PhongCach'</a>
<br>
<b style='display:none'>Total notified devices: <span id='total_sent'>0</span></b> 

<button id='send_to_all' onclick="notifyAllDevices()">Gửi thông báo đến tất cả smartphone</button>&nbsp
<b>(Chỉ nên sử dụng chức năng vào những thời gian thích hợp vì tác dụng alert nó như tin SMS)</b>
<br>
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
	
	function getNumberDevices(){
		$.post('http://nguyentantrieu.info/i2tree/index.php/device/number_devices',{},function(rs){
			if(rs.status == 'ok'){
				$('#total_devices').text(rs.text);
			}
		});
	}
	
	function notifyAllDevices(){
		$.get('http://nguyentantrieu.info/i2tree/index.php/device/notify_all_devices',{},function(rs){
			alert(rs);
		});
	}
	getNumberDevices();
</script>
<style type="text/css">
.ceil {
	height:140px;
	width:100%;
	overflow: auto;
}
.action {
font-weight:bolder;font-size:16px;
}
.ads_counter {
	text-align:center;font-size:16px;color:red;font-weight:bold;
}
</style>
<?php echo $table_html; ?>