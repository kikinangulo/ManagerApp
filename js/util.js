
var playercount = 0;

function selectedPlayer(){
	playercount++;
	if(playercount == 11) {
		$("#friends").attr("disabled", "disabled");
		$("#save").show();
	}
	if(playercount <= 11) {
		var selected = $("#friends option:selected");
		selected.remove();
		img_src = "https://graph.facebook.com/"+selected.val()+"/picture";

		$("#pic"+playercount).attr("src", img_src);
		$("#pic"+playercount).attr("pid", selected.val());
		$("#pic"+playercount).attr("name", selected.text());
		$("#tag"+playercount).html(selected.text());
	}
}

function saveTeam() {
	
	var team = [];
	$(".pic").each(
			function(index) {
				var name = $(this).attr("name");
				var id = $(this).attr("pid");
				team.push({
				"name": name,  
				"id" :id});
			}
		);
	var data  = {
		"manager_id" : manager_id,
		"team" : team
	};
	alert("Print:"+data.team);
	var data_string = JSON.stringify(data);
	$.post('php/saveteam.php', {data : data_string}, savedTeam, "text");
}

function savedTeam() {
	$("#pitch").hide();
	$("#save").hide();
	$("#friends").hide();
	$("#messagebox").text("Successful Addition of Team");
}
