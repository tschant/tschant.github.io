$(document).ready(function(){
	$("body").prepend(
		'<div id="navbar" class="toolbar container u-full-width">'+
		    '<div class="row">'+
		        '<div class="four columns button input" onClick="redirect(\'index.html\')"> Home</div>'+
		        '<div class="four columns button input" onClick="redirect(\'about.html\')"> About</div>'+
		        '<div class="four columns button input" onClick="redirect(\'projects.html\')"> Projects</div>'+
		    '</div>'+
		'</div>'
	);
	$("head").append(
		'<meta charset="utf-8">'+
		'<meta name="author" content="T Schant">'+

	    '<link rel="stylesheet" href="css/styles.css">'+
	    '<link rel="stylesheet" href="css/normalize.css">'+
	    '<link rel="stylesheet" href="css/skeleton.css">'
	);
});

function redirect(url) {
	$(location).attr('href',url);
}

function projectLoad(proj){
	var area = $("#project_report").children();
	$("#project_code").replaceWith("<div id='project_code'/>");
	switch(proj){
		case "haskell":
			var url =  "http://cdn.rawgit.com/tschant/Haskell_Fractals/master/Practical_Fractal.hs",
				textStuff = "I created this program as a way to learn more about Haskell and Fractals at the same time.";
			$("#projects_header").text("Project: Haskell Fractals");
 			area.replaceWith("<p class='u-full-width' style=''>"+textStuff+"</p>");
			getCodeFromGithub(url);
			break;
		case "eecs647":
			var textStuff = "I worked on this website with a two friends. We created this project to learn SQL, JavaScript, and PHP."+
							"We decided to create a basic RPG game that uses a database as to track the players progress.",
				words = "<p class='u-full-width' style='display:inline-block'>"+textStuff+"</p>";
			$("#projects_header").text("Project: EECS 647 Project");
 			area.replaceWith("<div class='container' style='text-align:center'><a href='http://blakehefley.com' target='_blank' class='six columns button button-primary'>Link to Game</a>"+words+"</div>");
			break;
		case "astar":
			$("#projects_header").text("Project: A* Search Algorithm");
			var cls = "button button-primary six columns",
				url1 = "http://cdn.rawgit.com/tschant/A-StarSearch/master/8Puzzle-racket.rkt",
				url2 = "http://cdn.rawgit.com/tschant/A-StarSearch/master/8Puzzle-python.py",
				btn1 = "<div class='"+cls+"' onClick=getCodeFromGithub('"+url1+"')>Racket/Scheme</div>",
				btn2 = "<div class='"+cls+"' onClick=getCodeFromGithub('"+url2+"')>Python</div>";
			var textStuff = "This was the first project that I did to learn how AI works in a basic manner. "+
						"This project implements the A* search algorthim (in Racket and Python) to solve a <a href='http://mypuzzle.org/sliding' target='_blank'>sliding 8 puzzle</a>.",
				words = "<p class='u-full-width' style=''>"+textStuff+"</p>"
 			area.replaceWith("<div class='container' style=''>"+btn1+btn2+words+"</div>");
			break;
		case "vigenere":
			var url =  "http://cdn.rawgit.com/tschant/Vigenere-Cipher/master/Vigenere-python.py",
				textStuff = "This was a project to learn about security and what can make a secure password. I also used this as a means to learn Python.";
			$("#projects_header").text("Project: Vigenere Cipher");
			area.replaceWith("<p class='u-full-width' style=''>"+textStuff+"</p>");
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
		    $("#project_code").replaceWith(
				"<pre id='project_code' style='display:inline-block;width:100%;text-align:left;'><code>"+data+"</code></pre>"
			);
	    }
	});
}