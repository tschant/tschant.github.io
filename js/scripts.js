$(document).ready(function(){
	$("body").prepend(
		'<div id="toolbar" class="container u-full-width">'+
		    '<div class="row">'+
		        '<div class="four columns button input" onClick="redirect(\'index.html\')"> Home</div>'+
		        '<div class="four columns button input" onClick="redirect(\'about.html\')"> About</div>'+
		        '<div class="four columns button input" onClick="redirect(\'projects.html\')"> Projects</div>'+
		    '</div>'+
		'</div>'
	);
	$("head").append(
		'<meta charset="utf-8">'+
		'<meta name="author" content="T Schant">'
	);
});

function redirect(url) {
	$(location).attr('href',url);
}

function projectLoad(proj){
	switch(proj){
		case "haskell":
			$("#projects_header").text("Project: Haskell Fractals");
			var url =  "http://cdn.rawgit.com/tschant/Haskell_Fractals/master/Practical_Fractal.hs";
 			//$("#project_text").replaceWith("");
			getCodeFromGithub(url);
			break;
		case "eecs647":
			$("#projects_header").text("Project: EECS 647 Project");
 			$("#project_report").children().replaceWith("<div class='container' style='text-align:center'><a href='blakehefley.com' class='six columns button button-primary'>Link to Game</a></div>");

			break;
		case "astar":
			$("#projects_header").text("Project: A* Search Algorithm");
 			$("#project_report").children().replaceWith("");
			break;
		case "ardrone":
			$("#projects_header").text("Project: AR Drone");
 			$("#project_report").children().replaceWith("");
			break;
		case "vigenere":
			$("#projects_header").text("Project: Vigenere Cipher");
			var url =  "http://cdn.rawgit.com/tschant/Vigenere-Cipher/master/Vigenere-python.py";
			getCodeFromGithub(url);
			break;
	}
}

function getCodeFromGithub(url) {
	$.ajax({
	    type:     "GET",
	    url:     url, // <-- Here
	    dataType: "html",
    	crossDomain: true,
    	contentType: "text/plain",
	    success: function(data){
		    $("#project_report").children().replaceWith(
				"<pre><code>"+data+"</code></pre>"
			);
	    }
	});
}