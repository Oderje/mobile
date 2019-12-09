<div class="container-fluid ">
	<div class="row mt-1">
		<div class="col-md-2 d-md-block d-none"></div>
		<div class="col-md-8  text-center border ">
			<div class="col-md-12"><label class="h4">WALK IN PAYMENT</label></div>
			<!-- <div class="col-md-12"><label class="h5">Merchant Detail</label></div> -->
			<div class="col-md-12 h5"><span id="merchant_name">Merchant Name</span></div>
			<div class="col-md-12 h6"><span id="merchant_regno"> Merchant REG. NO</span></div>
			<div class="col-md-12 h6"><span id="date_now">Date</span></label></div>
			<div class="col-md-12 h6"><span id="time_now">Time</span></label></div>
			<div class="row mt-3">
				<label class="col-md-3 col-3 text-outline text-warning h5 pr-0 mt-2">Price</label>
				<div class="col-md-9 col-9 input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" >RM</span>
					</div>
					<input id="input_price" type="text" class="form-control" placeholder="Total Price" value="5.00">
					<div class="input-group-append">
						<span class="input-group-text confirm_btn bg-info text-white" >Confirm</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2 d-md-block d-none"></div>
	</div>
	<div class="row mt-3" id="check">
		<div class="col-md-2 d-md-block d-none"></div>
		<div class="col-md-8 d-md-block text-center border">
			
			<label> Please Wait... Checking information</label>
		</div>
		<div class="col-md-2 d-md-block d-none"></div>
	</div>
	<div class="row mt-3 d-none mt-1 " id="div_payment" >
		<div class="col-md-2 d-md-block d-none"></div>
		<div class="col-md-8  text-left border  rounded p-3">
			<label class="h5 text-warning text-outline">Make Payment</label>
			<!-- <div class="row">
				<div class="col-md-12 text-warning text-outline" ><b>List of available voucher</b></div>
			</div> -->
			<div class="row">
				<div class="col-md-12 text-warning text-outline" ><b>List of available voucher</b></div>
			</div>
			<div class="row mx-auto p-1 mt-2 border border-info list_voucher" style="overflow-y: scroll;max-height: 150px">
				<!-- <div class="col-md-3 col-6 border border-dark bg-warning rounded voucher_card p-0 my-1">
					<input class="vh_id" type="hidden" value="-11" >
					<input class="amount" type="hidden" value="5.00" >
					<input class="balance" type="hidden" value="2.00" >
					<div class="v_name  text-white text-center text-outline-info">Voucher Name</div>
					<div class="v_amount text-center h5 card bg-info text-white">RM 5.00</div>
					<div class="v_bamount text-center">Balance: <span class="text-white text-outline-info">RM 2.00</span></div>
				</div>	 -->

				
			</div>
			<div class="row">
				<div class="col-md-12 mt-3 text-warning text-outline" ><b>Voucher Balance</b></div>
			</div>
			<div class="row">
				<div class="col-md-12 input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" >RM</span>
				  </div>
				  <input id="vbalance" type="text" class="form-control" placeholder="Voucher Balance" value="">
				  <div class="input-group-append">
				    <span class="input-group-text bg-warning text-white text-outline-info deduct_btn" >Guna je</span>
				  </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 mt-1 text-warning text-outline" ><b>Total Payment</b></div>
			</div>
			<div class="row">
				
				<div class="col-md-12 input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" >RM</span>
				  </div>
				  <input id="total_transfer" type="text" class="form-control" placeholder="Total Price" value="" disabled="">
				</div>
			</div>
			<div class="row text-center">
				<div class="col-md-12 mt-1"><button class="btn btn-outline-success" id="request_pin"><b>Request Pin</b></button></div>
			</div>
			<div class="row mt-2 d-none pin_div">
				 
				<div class="col-md-12 input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" >PIN</span>
				  </div>
				  <input id="key" type="text" class="form-control" placeholder="X X X X X X" value="">
				</div>
			</div>
			<div class="row text-center d-none pin_div">
				<div class="col-md-12 mt-1"><button class="btn btn-outline-success" id="proceed_payment"><b>Make Payment</b></button></div>
			</div>
		</div>
		<div class="col-md-2 d-md-block d-none"></div>
	</div>
</div>





<?php

	//$_SESSION['login_status'] = TRUE;

	if(isset($_SESSION['login_status']) && $_SESSION['login_status'] == TRUE)
	{
		//echo '<script>alert("dah sign in")</script>';
		// var_dump($_SESSION);
	}
	else
	{
		
		echo '<script>window.location="../login.php?d="+url_encode("merchant_uid="+$_GET["UID"]+"&merchant_id="+$_GET["MID"]+"&price="+$_GET["PRICE"]+"&bill_id="+$_GET["bill_id"])</script>';
	}
	
	

?>
<script src="../view/payment_page/payment_onload.js"></script>
<script>
	
	$(document).ready(function(){
		initializer();

		var cur_vh_id = 0;
		var login_status = $_USER['login_status'];
		var cid = $_USER['cid'];
		var key = $_USER['key'];
		var use_pin = true;
		//use for duduction logic
		var cur_voucher_balance = 0;
		var deduction_for_voucher = 0;
		var cur_voucher_use = 0;
		var cur_price_need_topay = 0;


		if(login_status  && cid !="")
		{
			$("#check").addClass("d-none");
			//$("#div_payment").removeClass("d-none");
		}



		$(".confirm_btn").on("click",function(){
			if(use_pin == "yes")
			{
				if($(this).text() == "Confirm")
				{
					cur_price_need_topay = parseFloat($("#input_price").val().trim());
					$("#input_price").attr("disabled",true);
					$(this).removeClass("bg-info").addClass("bg-success").text("Change");
					$("#div_payment").removeClass("d-none");
					$("#total_transfer").val($("#input_price").val());
				}
				else{
					$("#input_price").attr("disabled",false);
					$(this).removeClass("bg-success").addClass("bg-info").text("Confirm");
				}
			}
			else
			{
				if($(this).text() == "Confirm")
				{

					cur_price_need_topay = parseFloat($("#input_price").val().trim());
					$("#input_price").attr("disabled",true);
					$(this).removeClass("bg-info").addClass("bg-success").text("Change");
					$("#div_payment").removeClass("d-none");
					$("#total_transfer").val($("#input_price").val());

					$("#request_pin").find("b").text("Pay");
				}
				else{
					$("#input_price").attr("disabled",false);
					$(this).removeClass("bg-success").addClass("bg-info").text("Confirm");
				}
				

			}
			
		});
		$("#request_pin").on("click",function(e){
			let vt_id = "";
			let vt_idArr = new Array();
			let t_id = "";
			let t_idArr = new Array();

			let total_transfer = $("#total_transfer").val();

			if(isNaN(total_transfer))
			{
				console.log("N/A");
			}
			else
			{
				let mid = $_GET['MID'];
				let u_mid = $_GET['UID'];
				let c_uid = $_USER['uid'];
				//let key = $_USER['key'];

				$("#input_price").attr("disabled",true);
				$("#vbalance").attr("disabled",true);
				$("#total_transfer").attr("disabled",true);

				if(mid != "" && u_mid != "" && cid != "" && key != "")
				{
					console.log(deduction_for_voucher);
					var formData = new FormData();
					formData.append("function","customer_make_payment");
					formData.append("bill_id",$_GET['bill_id']);
					formData.append("sender",c_uid);
					formData.append("receiver",u_mid);
					formData.append("mid",mid);
					if(cur_vh_id > 0)
					{
						formData.append("vh_id",cur_vh_id);
						formData.append("voucher_deduction",(deduction_for_voucher*100));
					}
					
					$.ajax({
						url:"https://app.oderje.com/api/customer_payment",
						data:formData,
						processData: false,
  						contentType: false,
						type:"POST",
						success:function(data)
						{
							console.log(data);
							if(data.status=="Amount not enough")
							{
								alert("Please Top Up Balance Account");
							}
							if(data.status == "ok")
							{

								if(use_pin == 'yes')
								{
									$(".pin_div").removeClass("d-none");
									$("#request_pin").attr("disabled",true);

									if(Array.isArray(data.vt_id))
									{
										vt_idArr = data.vt_id;
										console.log(vt_idArr);
									}
									else
									{
										vt_id = data.vt_id;
										console.log(vt_id);
									}

									if(Array.isArray(data.t_id))
									{
										t_idArr = data.t_id;
										console.log(t_idArr);
									}
									else
									{
										t_id = data.t_id;
										//console.log(t_id);
									}


									$("#proceed_payment").on('click',function(){
										let pin = $("#key").val().trim();

										if(Array.isArray(data.vt_id))
										{
											$.post("https://app.oderje.com/api/transfer",
											{
												function:"confirm_payment",
												pin:pin,
												vt_id:vt_idArr,
												tid:t_idArr

											},function(data){

												if(data.status == "ok")
												{
													console.log(data);
													alert("Successfully paid");
													$.post("https://app.oderje.com/api/customer_order",
													{
														function:"customer_make_instant_order",
														c_id:$_USER['cid'],
														bill_id:$_GET['bill_id']
													},
													function(data){
														console.log(data);
														// window.location.href = "receipt/?";
													},"json");
													
												}
												else
												{
													alert("Failed transfer");
												}
											},"json");
										}
										else
										{
											$.post("https://app.oderje.com/api/transfer",
											{
												function:"confirm_payment",
												pin:pin,
												vt_id:vt_id,
												tid:t_id

											},function(data){

												if(data.status == "ok")
												{
													alert("Successfully paid");
													$.post("https://app.oderje.com/api/customer_order",
													{
														function:"customer_make_instant_order",
														c_id:$_USER['cid'],
														bill_id:$_GET['bill_id']
													},
													function(data){
														console.log(data);
														// window.location.href = "receipt/?";
													},"json");
													
												}
												else
												{
													alert("Failed transfer");
												}
											},"json");
										}
										
									});
								}
								else
								{
									alert("Succesfully paid2");
									$.post("https://app.oderje.com/api/customer_order",
									{
										function:"customer_make_instant_order",
										c_id:$_USER['cid'],
										bill_id:$_GET['bill_id']
									},
									function(data){
										console.log(data);
										// window.location.href = "receipt/?";
									},"json");
									
								}
							}
						}

					});


					// $.post("https://app.oderje.com/api/customer_payment",
					// {
					// 	function:"customer_make_payment",
					// 	bill_id:$_GET['bill_id'],
					// 	sender:c_uid,
					// 	receiver:u_mid,
					// 	mid:mid

					// }
					// // {formData}
					// ,function(data){

					// 	console.log(data);
					// 	if(data.status=="Amount not enough")
					// 	{
					// 		alert("Please Top Up Balance Account");
					// 	}
					// 	if(data.status == "ok")
					// 	{

					// 		if(use_pin == 'yes')
					// 		{
					// 			$(".pin_div").removeClass("d-none");
					// 			$("#request_pin").attr("disabled",true);

					// 			if(Array.isArray(data.vt_id))
					// 			{
					// 				vt_idArr = data.vt_id;
					// 				console.log(vt_idArr);
					// 			}
					// 			else
					// 			{
					// 				vt_id = data.vt_id;
					// 				console.log(vt_id);
					// 			}

					// 			if(Array.isArray(data.t_id))
					// 			{
					// 				t_idArr = data.t_id;
					// 				console.log(t_idArr);
					// 			}
					// 			else
					// 			{
					// 				t_id = data.t_id;
					// 				//console.log(t_id);
					// 			}


					// 			$("#proceed_payment").on('click',function(){
					// 				let pin = $("#key").val().trim();

					// 				if(Array.isArray(data.vt_id))
					// 				{
					// 					$.post("https://app.oderje.com/api/transfer",
					// 					{
					// 						function:"confirm_payment",
					// 						pin:pin,
					// 						vt_id:vt_idArr,
					// 						tid:t_idArr

					// 					},function(data){

					// 						if(data.status == "ok")
					// 						{
					// 							console.log(data);
					// 							alert("Successfully transfer");
					// 							window.location.href = "receipt/";
					// 						}
					// 						else
					// 						{
					// 							alert("Failed transfer");
					// 						}
					// 					},"json");
					// 				}
					// 				else
					// 				{
					// 					$.post("https://app.oderje.com/api/transfer",
					// 					{
					// 						function:"confirm_payment",
					// 						pin:pin,
					// 						vt_id:vt_id,
					// 						tid:t_id

					// 					},function(data){

					// 						if(data.status == "ok")
					// 						{
					// 							alert("Successfully transfer");
					// 							window.location.href = "receipt/";
					// 						}
					// 						else
					// 						{
					// 							alert("Failed transfer");
					// 						}
					// 					},"json");
					// 				}
									
					// 			});
					// 		}
					// 		else
					// 		{
					// 			alert("Payment succesfully");
					// 		}
					// 	}
						
					// },"json");

					// $.post("https://app.oderje.com/api/transfer", {
					// 	function:"payment",
					// 	sender:c_uid,
					// 	receiver:u_mid,
					// 	mid:mid,
					// 	vh_id:(cur_voucher_use != "0")? cur_voucher_use:0,
					// 	voucher_deduction:(deduction_for_voucher!="0")?(deduction_for_voucher*100):0,
					// 	voucher_balance:(cur_voucher_balance*100),
					// 	total_payment:(cur_price_need_topay*100),
					// 	user_payment:(total_transfer*100)
					// },
					// function(data){

					// 	// console.log(data);
					// 	if(data.status=="Amount not enough")
					// 	{
					// 		alert("Please Top Up Balance Account");
					// 	}
					// 	else if(data.status == "ok")
					// 	{
					// 		$(".pin_div").removeClass("d-none");
					// 		$("#request_pin").attr("disabled",true);

					// 		if(Array.isArray(data.vt_id))
					// 		{
					// 			vt_idArr = data.vt_id;
					// 			console.log(vt_idArr);
					// 		}
					// 		else
					// 		{
					// 			vt_id = data.vt_id;
					// 			console.log(vt_id);
					// 		}

					// 		if(Array.isArray(data.t_id))
					// 		{
					// 			t_idArr = data.t_id;
					// 			console.log(t_idArr);
					// 		}
					// 		else
					// 		{
					// 			t_id = data.t_id;
					// 			//console.log(t_id);
					// 		}


					// 		$("#proceed_payment").on('click',function(){
					// 			let pin = $("#key").val().trim();

					// 			if(Array.isArray(data.vt_id))
					// 			{
					// 				$.post("https://app.oderje.com/api/transfer",
					// 				{
					// 					function:"confirm_payment",
					// 					pin:pin,
					// 					vt_id:vt_idArr,
					// 					tid:t_idArr

					// 				},function(data){

					// 					if(data.status == "ok")
					// 					{
					// 						alert("Successfully transfer");
					// 						window.location.href = "receipt/";
					// 					}
					// 					else
					// 					{
					// 						alert("Failed transfer");
					// 					}
					// 				},"json");
					// 			}
					// 			else
					// 			{
					// 				$.post("https://app.oderje.com/api/transfer",
					// 				{
					// 					function:"confirm_payment",
					// 					pin:pin,
					// 					vt_id:vt_id,
					// 					tid:t_id

					// 				},function(data){

					// 					if(data.status == "ok")
					// 					{
					// 						alert("Successfully transfer");
					// 						window.location.href = "receipt/";
					// 					}
					// 					else
					// 					{
					// 						alert("Failed transfer");
					// 					}
					// 				},"json");
					// 			}
								
					// 		});
							
					// 	}
					// 	else
					// 	{
					// 		alert("Error");
					// 	}
					// },"json");

				}
			}
		});
		$(".deduct_btn").on("click",function(){
			var balance_to_deduct = $("#vbalance").val().trim();
			balance_to_deduct = parseFloat(balance_to_deduct);
			// console.log(balance_to_deduct);
			// console.log(cur_voucher_balance);
			// console.log(cur_voucher_use);
			//if true => voucher tak cukup balance nak deduct
			if(balance_to_deduct > cur_voucher_balance) 
			{
				alert("balance not enough");
			}
			else
			{
				var tp = $("#total_transfer");
				var input_price = parseFloat($("#input_price").val().trim());

				if(input_price>=balance_to_deduct)
				{
					// console.log("haha");
					deduction_for_voucher = balance_to_deduct;
					cur_voucher_balance = cur_voucher_balance-balance_to_deduct;
					tp.val((input_price-balance_to_deduct).toFixed(2));
				}
				else if (input_price<balance_to_deduct)
				{
					// console.log("huhu");
					deduction_for_voucher =  input_price;
					cur_voucher_balance = balance_to_deduct - input_price;
					tp.val((balance_to_deduct-input_price).toFixed(2));
				}

			}
		});

		function initializer()
		{
			$.post("https://app.oderje.com/api/customer",
			{
				function:"customer_to_merchant_voucher",
				cid:$_USER['cid'],
				mid:$_GET['MID']
			},
			function(data){
				set_merchant_detail(data.merchant);
				if(data.voucher)
				{
					create_voucher_card(data.voucher);

				}
			},"json");

			$.post("https://app.oderje.com/api/customer_bill",
			{
				function:"get_bill_amount",
				bill_id:$_GET['bill_id']

			},function(data){
				if(data.status == "ok")
				{
					$("#input_price").val(data.amount);

				}
				else
				{

					alert("invalid payment");
				}

			},"json");

			$.post("https://app.oderje.com/api/customer",
			{
				function:"customer_use_pin",
				c_id:$_USER['cid']

			},function(data){
				if(data.status == "ok")
				{

					use_pin = data.use_pin;
					console.log(use_pin);
				}
				else
				{

					alert("invalid user");
				}

			},"json");
			

		}

		function set_merchant_detail(data){
			$("#merchant_name").text(data.M_NAME);
			$("#merchant_regno").text(data.M_REG_NO);


			const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];

			var today = new Date();
			var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
			var hour = today.getHours();	
			var minute = today.getMinutes();
			var time = (today.getHours() >= 12)? today.getHours() - 12: today.getHours();
			time += ":" + minute;
			time += (today.getHours() >= 12)? " PM":" AM";

			$("#date_now").text(today.getDate()+' '+ monthNames[today.getMonth()] +' '+today.getFullYear());
			$("#time_now").text(time);
		}
		function create_voucher_card(list){

			if(list.length > 0)
			{
				var html = "";
				for(var i = 0 ; i < list.length; i++)
				{
					var bal = (list[i].V_BALANCE != null)?list[i].V_BALANCE:list[i].AMOUNT;
					html += '<div class="col-md-3 col-6 border border-dark bg-warning rounded voucher_card p-0 my-1">';
					html += '	<input class="vh_id" type="hidden" value="'+list[i].VH_ID+'" >';
					html += '	<input class="amount" type="hidden" value="'+list[i].AMOUNT+'" >';
					html += '	<input class="balance" type="hidden" value="'+bal+'" >';
					html += '	<div class="v_name  text-white text-center text-outline-info">'+list[i].V_NAME+'</div>';
					html += '	<div class="v_amount text-center h5 card bg-info text-white">RM '+list[i].AMOUNT+'</div>';
					html += '	<div class="v_bamount text-center">Balance: <span class="text-white text-outline-info">RM '+bal+'</span></div>';
					html += '</div>	';

				}
				$(".list_voucher").append(html);
				voucher_listener();
			}}
		function reset_voucher_selection(){
			$(".voucher_card").each(function(){
				($(this).hasClass("bg-info"))?$(this).removeClass("bg-info").addClass("bg-warning "):$(this).addClass("bg-info");
				($(this).find(".v_name").hasClass("text-outline-info"))?$(this).find(".v_name").addClass("text-outline-info"):$(this).find(".v_name").addClass("text-outline-info");
				($(this).find(".v_amount").hasClass("bg-warning"))?$(this).find(".v_amount").removeClass("bg-warning ").addClass("bg-info"):$(this).find(".v_amount").removeClass("bg-warning");

			});}
		function voucher_listener(){

			$(".voucher_card").on("click",function(){
				reset_voucher_selection();
				($(this).hasClass("bg-warning"))? $(this).removeClass("bg-warning").addClass("bg-info"):null;
				($(this).find(".v_name").hasClass("text-outline-info"))?$(this).find(".v_name").removeClass("text-outline-info"):null;
				($(this).find(".v_amount").hasClass("bg-info"))?$(this).find(".v_amount").removeClass("bg-info").addClass("bg-warning text-outline-info"):null;

				vh_id = $(this).find(".vh_id").val();
				amount = $(this).find(".amount").val();
				balance = $(this).find(".balance").val();

				cur_vh_id = vh_id;
				cur_voucher_use = vh_id;
				
				cur_voucher_balance = parseFloat(balance);
				$("#vbalance").val((balance > cur_price_need_topay)? cur_price_need_topay:balance);


			});}
	});


</script>

