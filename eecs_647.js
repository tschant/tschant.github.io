var enemyNumMax = maxEnemies;
var locIUse = myLoc;
var locIdUse = myLocid;
var myName = username;
var offside = offset;
var bigness = size;
var heartiness = myHealth;
var north = northern;
var south = southern;
var east = eastern;
var west = western;
var theitems = myitems;

var enemyLevel = yourLevel; //update in ajax call on screen change
var whatTheScouterSays = myLevel;
var baddiesArr = enemyArray;
var brand = myElem;

function drawEnemies(numEnemies){
	var divs = document.getElementsByClassName("box");
	var randoArray = {};
	for(var i = 0; i< numEnemies; i++){
		var rando = Math.floor((divs.length-1) * Math.random());
		while(divs[rando].getElementsByClassName("object").length > 0 || rando == locIUse - offside ){
			rando = (rando+1) % (bigness*bigness) ;
		}
		randoArray[i] = rando;
	}

	var newhtml = "<div class = \"enemy\" id = \"enemy";
	var encoded = JSON.stringify(randoArray);

	$.ajax({
	    	url: 'functions.php',
	   	type: 'post',
	   	async: false,
	   	data: { "enemyNum": encoded},
	  	success: function(response) {
	  		if (response){
	  		baddiesArr = response.slice(0);}
	  		while(numEnemies > 0){
	  		  	newhtml = newhtml + (numEnemies-1) + "\">" + response[numEnemies-1][1] +"</div>";	  	
				divs[randoArray[numEnemies-1]].innerHTML = newhtml;
				numEnemies--;
				newhtml = "<div class = \"enemy\" id = \"enemy";
			}
		},
		dataType: "json"
	});
}

function enterFight(html){
	html = parseInt(html.substr(5));
    	clearInterval(mytimer);
	checker = false;
	var mineHealth = heartiness;
	var yourType = [html][4];
	var yourHealth = baddiesArr[html][5];
	var yourStrength = baddiesArr[html][6];
	var yourDefense = baddiesArr[html][7];
	var yourMagic = baddiesArr[html][8];
	var yourResistance = baddiesArr[html][9];
	var yourAgility = baddiesArr[html][10];
	var mineTarget = "them";
	var multiplier = 1;
	var strongness = myStrength;
	var toughness = myDefense;
	var mysticality = myMagic;
	var warding = myResistance;
	var rapidity = myAgility;
	
	var fightOverlay = document.createElement("div");
	fightOverlay.id = "fightOverlay";
	
	var Fight = document.createElement("div");
	Fight.id = "Fight";
	
	var selector = document.createElement("div");
	selector.id = "selector";
		
	var runAway = document.createElement("div");
	runAway.id = "runAway";
	runAway.innerHTML = "<span>Run Away</span>";
	runAway.onclick = function(){exitFight()};
	
	var Item = document.createElement("div");
	Item.id = "Item";
	Item.innerHTML = "<span>Item</span>";
	Item.onclick = function(){openItem()};
	
	var magic = document.createElement("div");
	magic.id = "magic";
	magic.innerHTML = "<span>Magic</span>";
	magic.onclick = function(){openMagic()};
	
			
	var attack = document.createElement("div");
	attack.id = "attack";
	attack.innerHTML = "<span>Attack</span>";
	attack.onclick = function(){takeTurn("physical");};
	
	var them = document.createElement("div");
	them.id = "them";
	them.innerHTML =  baddiesArr[html][1]+"<br>Health: "+ yourHealth;
	
	var mine = document.createElement("div");
	mine.id = "mine";
	mine.style.float = "left";
	mine.innerHTML = "Me<br>Health: " + mineHealth;
	
	document.body.appendChild(fightOverlay);
	document.getElementById("fightOverlay").appendChild(Fight);
	document.getElementById("Fight").appendChild(them);
	document.getElementById("Fight").appendChild(mine);
	document.getElementById("Fight").appendChild(selector);
	document.getElementById("selector").appendChild(attack);
	document.getElementById("selector").appendChild(magic);
	document.getElementById("selector").appendChild(Item);
	document.getElementById("selector").appendChild(runAway);
	
	function openMagic(){
		var overlay = document.createElement("div");
		overlay.id = "overlay";
	
		var magicMenu = document.createElement("div");
		magicMenu.id = "magicMenu";
	
		var leaveMagic = document.createElement("div");
		leaveMagic.id = "leaveMagic";
		leaveMagic.innerHTML = "<span>Back</span>";
		leaveMagic.onclick = function(){closeMagic()};
	
		var Fire = document.createElement("div");
		Fire.innerHTML = "<span>Fire</span>";
		Fire.onclick = function(){targetSelector("fire");};
		
		var Water = document.createElement("div");
		Water.innerHTML = "<span>Water</span>";
		Water.onclick = function(){targetSelector("water");};
		
		var Earth = document.createElement("div");
		Earth.innerHTML = "<span>Earth</span>";
		Earth.onclick = function(){targetSelector("earth");};
		
		var Air = document.createElement("div");
		Air.innerHTML = "<span>Air</span>";
		Air.onclick = function(){targetSelector("air");};
		
		var Aether = document.createElement("div");
		Aether.innerHTML = "<span>Aether</span>";
		Aether.onclick = function(){targetSelector("aether");};
		
		var Void = document.createElement("div");
		Void.innerHTML = "<span>Void</span>";
		Void.onclick = function(){targetSelector("void");};
		
		document.body.appendChild(overlay);
		document.getElementById("overlay").appendChild(magicMenu);
		document.getElementById("magicMenu").appendChild(Fire);
		document.getElementById("magicMenu").appendChild(Water);
		document.getElementById("magicMenu").appendChild(Earth);
		document.getElementById("magicMenu").appendChild(Air);
		document.getElementById("magicMenu").appendChild(Aether);
		document.getElementById("magicMenu").appendChild(Void);
		document.getElementById("magicMenu").appendChild(leaveMagic);
	}function openItem(){
		var overlay = document.createElement("div");
		overlay.id = "overlay";
	
		var ItemMenu = document.createElement("div");
		ItemMenu.id = "ItemMenu";
	
		var leaveItem = document.createElement("div");
		leaveItem.id = "leaveItem";
		leaveItem.innerHTML = "<span>Back</span>";
		leaveItem.onclick = function(){closeMagic()};
		document.body.appendChild(overlay);
		document.getElementById("overlay").appendChild(ItemMenu);
		for(var i = 0; i<theitems.length;i++){
			var thisItem = document.createElement("div");
			thisItem.id = "Item"+i;
			thisItem.innerHTML = "<b>"+theitems[i][4]+"</b><br><i>"+theitems[i][6]+"</i><br>"+theitems[i][2];
			thisItem.onclick = function(){
						if(theitems[i][2]>0){
							theitems[i][2] -=1;
							closeMagic();
							eval(theitems[i][5]);
							getAttacked();
						}};
			document.getElementById("ItemMenu").appendChild(thisItem);
		}
		
		

		document.getElementById("ItemMenu").appendChild(leaveItem);
	}

	function closeMagic(){
		document.getElementById("overlay").remove();
	}
	
	function targetSelector(spell){
		closeMagic();
		var overlay = document.createElement("div");
		overlay.id = "overlay";
		
		var targeter = document.createElement("div");
		targeter.id = "targeter";
		
		var content = document.createElement("p");
		content.innerHTML = "Who would you like to target?";
		
		var targetMe = document.createElement("div");
		targetMe.id = "targetMe";
		targetMe.innerHTML = "<span>Me</span>";
		targetMe.onclick = function(){mineTarget = "Me"; takeTurn(spell)};
		
		var targetThem = document.createElement("div");
		targetThem.id = "targetThem";
		targetThem.innerHTML = "<span>Them</span>";
		targetThem.onclick = function(){mineTarget = "Them"; takeTurn(spell)};
		
		document.body.appendChild(overlay);
		document.getElementById("overlay").appendChild(targeter);
		document.getElementById("targeter").appendChild(content);
		document.getElementById("targeter").appendChild(targetMe);
		document.getElementById("targeter").appendChild(targetThem);
	}
	function takeTurn(typer){
		if(rapidity>=yourAgility){
			selectAttack(typer);
			getAttacked();
		}else{
			getAttacked();
			selectAttack(typer);
		}
	}
	
	function selectAttack(typer){
		if(typer == "physical"){
			punchHimInTheFace();
		}if(typer == "fire"){
			castFire();
		}if(typer == "water"){
			castWater();
		}if(typer == "earth"){
			castEarth();
		}if(typer == "air"){
			castAir();
		}if(typer == "aether"){
			castAether();
		}if(typer == "void"){
			castVoid();
		}
	}
	
	function punchHimInTheFace(){
		yourHealth -= Math.floor((strongness - yourDefense)*whatTheScouterSays/enemyLevel);
		//strongness*whatTheScouterSays = youDefense*enemyLevel
		checkEnd();
	}

	function castWater(){
		if(mineTarget =="Them"){
			if(yourType == "fire"){
				yourStrength--;
				multiplier = 2;
			}else if(yourType == "water"){
				multiplier = -1;
				yourResistance++;
			}else if(yourType == "earth"){
				multiplier = 1;
				yourDefense--;
			}else if(yourType == "air"){
				multiplier = 0;
				yourAgility--;
			}yourHealth -=  Math.floor(multiplier*((mysticality - yourResistance)*whatTheScouterSays/enemyLevel));
		}else{
			if(brand == "fire"){
				strongness--;
				multiplier = 2;
			}else if(brand == "water"){
				multiplier = -1;
				warding++;
			}else if(brand == "earth"){
				multiplier = 1;
				toughness--;
			}else if(brand == "air"){
				multiplier = 0;
				rapidity--;
			}mineHealth -=  Math.floor(multiplier*(mysticality - warding));
		}
		document.getElementById("overlay").remove();
		checkEnd();
	}

	function castFire(){
		if(mineTarget =="Them"){
			if(yourType == "fire"){
				yourStrength++;
				multiplier = -2;
			}else if(yourType == "water"){
				multiplier = 1;
				strongness--;
			}else if(yourType == "earth"){
				multiplier = 1;
				yourDefense++;
				yourResistance++;
			}else if(yourType == "air"){
				multiplier = 0;
				yourAgility++;
			}yourHealth -=  Math.floor(multiplier*((mysticality - yourResistance)*whatTheScouterSays/enemyLevel));
		}else{
			if(brand == "fire"){
				strongness++;
				multiplier = -2;
			}else if(brand == "water"){
				multiplier = 1;
				strongness--;
			}else if(brand == "earth"){
				multiplier = 1;
				toughness++;
				warding++;
			}else if(brand == "air"){
				multiplier = 0;
				rapidity++;
			}mineHealth -=  Math.floor(multiplier*(mysticality - warding));
		}
		document.getElementById("overlay").remove();
		checkEnd();
	}

	function castEarth(){
		if(mineTarget =="Them"){
			if(yourType == "fire"){
				yourAgility--;
				multiplier = 1;
			}else if(yourType == "water"){
				multiplier = 1;
				yourAgility++;
			}else if(yourType == "earth"){
				multiplier = 1;
				yourStrength++;
				strongness++;
			}else if(yourType == "air"){
				multiplier = 0;
			}yourHealth -=  Math.floor(multiplier*((mysticality - yourResistance)*whatTheScouterSays/enemyLevel));
		}
		else{
			if(brand == "fire"){
				rapidity--;
				multiplier = 1;
			}else if(brand == "water"){
				multiplier = 1;
				rapidity++;
			}else if(brand == "earth"){
				multiplier = 1;
				strongness++;
				strongness++;
			}else if(brand == "air"){
				multiplier = 0;
			}mineHealth -=  Math.floor(multiplier*(mysticality - warding));
		}
		document.getElementById("overlay").remove();
		checkEnd();
	}

	function castAir(){
		if(mineTarget =="Them"){
			if(yourType == "fire"){
				yourStrength++;
				yourDefense--;
				yourMagic++;
				yourResistance--;
			}else if(yourType == "water"){
				yourStrength++;
				yourResistance--;
			}else if(yourType == "earth"){
				yourStrength--;
				yourDefense--;
			}else if(yourType == "air"){
				yourMagic++;
				yourStrength++;
			}
		}
		else{
			if(brand == "fire"){
				strongness++;
				toughness--;
				mysticality++;
				warding--;
			}else if(brand == "water"){
				strongness++;
				warding--;
			}else if(brand == "earth"){
				strongness--;
				toughness--;
			}else if(brand == "air"){
				mysticality++;
				strongness++;
			}
		}
		document.getElementById("overlay").remove();
		checkEnd();
	}

	function castAether(){
		document.getElementById("overlay").remove();
	}

	function castVoid(){
		if(mineTarget =="Them"){
			yourHealth -=  Math.floor((mysticality - yourResistance)*whatTheScouterSays/enemyLevel);
		}else{
			mysticality += 2;
		}
		document.getElementById("overlay").remove();
		checkEnd();
	}
	
	function getAttacked(){	
		var randomer = ((parseInt(yourStrength) + parseInt(yourMagic)) * Math.random());
		if(randomer <= yourStrength){
			mineHealth -= Math.floor((yourStrength - toughness)*enemyLevel/whatTheScouterSays);
		}else{
			if(yourType == "fire"){
				if(brand == "fire"){
					strongness++;
					multiplier = -2;
				}else if(brand == "water"){
					multiplier = 1;
					yourStrength--;
				}else if(brand == "earth"){
					multiplier = 1;
					toughness++;
					warding++;
				}else if(brand == "air"){
					multiplier = 0;
					rapidity++;
				}
			}else if(yourType == "water"){
				if(brand == "fire"){
					strongness--;
					multiplier = 2;
				}else if(brand == "water"){
					multiplier = -1;
					warding++;
				}else if(brand == "earth"){
					multiplier = 1;
					toughness--;
				}else if(brand == "air"){
					multiplier = 0;
					rapidity--;
				}
			}else if(yourType == "earth"){
				if(brand == "fire"){
					rapidity--;
					multiplier = 1;
				}else if(brand == "water"){
					multiplier = 1;
					rapidity++;
				}else if(brand == "earth"){
					multiplier = 1;
					strongness++;
					yourStrength++;
				}else if(brand == "air"){
					multiplier = 0;
				}
			}else if(yourType == "air"){
				if(brand == "fire"){
					strongness++;
					toughness--;
					mysticality++;
					warding--;
					multiplier = 0;
				}else if(brand == "water"){
					strongness++;
					warding--;
					multiplier = 0;
				}else if(brand == "earth"){
					strongness--;
					toughness--;
					multiplier = 0;
				}else if(brand == "air"){
					mysticality++;
					strongness++;
					multiplier = 0;
				}
			}else  if(yourType == "void"){
				multiplier = 1;
			}
			mineHealth -=  Math.floor(multiplier*(yourMagic - warding)*enemyLevel/whatTheScouterSays);
		}checkEnd();
	}
	function checkEnd(){
		if(yourHealth<=0){
			exitFight();
			alert("You Win");
		}if(mineHealth <= 0){
			exitFight();
			alert("You Lose");
		}
		mine.innerHTML = "Picture of me<br>Health: " + mineHealth;
		them.innerHTML = baddiesArr[html][1]+"<br>Health: "+ yourHealth;
	}
	function exitFight(){
		document.getElementById("fightOverlay").remove();
		mytimer = setInterval(function(){moveEnemies()}, 1000);
		checker = true;
	}
}

function moveEnemies(){
checker = false;
	for (var i = 0; i<$(".enemy").length; i++){
		var parentid = $(".enemy").eq(i).parent().attr('id');
		var rando = Math.floor(3.99 * Math.random());
		if (rando < 2){
			var amount = 1;
		}else{
			var amount = bigness;
		}if (rando % 2 == 0){
			var neg = 1;
		}else{
			var neg = -1;
		}var parentnum = parseInt(parentid.substr(3));
		var newparentnum = parentnum + (amount * neg);
		if(!((rando == 0 && parentnum % bigness == offside-1) || (rando == 1 && parentnum % bigness == offside) || (rando == 2 && parentnum>bigness*bigness - offside)|| (rando >= 3 && parentnum<bigness+offside+1))){
			if((document.getElementById("box".concat(newparentnum.toString())).style.backgroundImage == "url(http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png)") || ((document.getElementById("box".concat(newparentnum.toString())).innerHTML.length != 0) && (document.getElementById("box".concat(newparentnum.toString())).innerHTML != "&nbsp;"))){}
			else{
				document.getElementById("box".concat(newparentnum.toString())).innerHTML = document.getElementById("box".concat(parentnum.toString())).innerHTML;
				document.getElementById("box".concat(parentnum.toString())).innerHTML= "&nbsp;";
			}
		}	
	}
checker = true;
}
window.onload = drawEnemies(enemyNumMax);
$(window).on('beforeunload', function () {

  $.ajax({
	    url: 'functions.php',
	    type: 'post',
	    async: false,
	    data: { "logout": myName}/*,
	    success: function(response) {debugger; }*/
	});
});

function moveLeft(){
    	if(document.getElementById("box".concat((locIUse-1).toString())).innerHTML.indexOf("enemy") > -1){
    		enterFight(document.getElementById("box".concat((locIUse-1).toString())).getElementsByClassName("enemy")[0].id);
    	}
    	document.getElementById("box".concat((locIUse-1).toString())).innerHTML = document.getElementById("box".concat(locIUse.toString())).innerHTML;
    	document.getElementById("box".concat(locIUse.toString())).innerHTML = "&nbsp;";
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderLeft = "5px solid red";
    	locIUse--;
}
function moveDown(){
    	if(document.getElementById("box".concat((locIUse+bigness).toString())).innerHTML.indexOf("enemy") > -1){
    		enterFight(document.getElementById("box".concat((locIUse+bigness).toString())).getElementsByClassName("enemy")[0].id);
    	}
    	document.getElementById("box".concat((locIUse+bigness).toString())).innerHTML = document.getElementById("box".concat(locIUse.toString())).innerHTML;
    	document.getElementById("box".concat(locIUse.toString())).innerHTML = "&nbsp;";
    	locIUse= locIUse+bigness;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderBottom = "5px solid red";
}
function moveUp(){
    	if(document.getElementById("box".concat((locIUse-bigness).toString())).innerHTML.indexOf("enemy") > -1){
    		enterFight(document.getElementById("box".concat((locIUse-bigness).toString())).getElementsByClassName("enemy")[0].id);
    	}
    	document.getElementById("box".concat((locIUse-bigness).toString())).innerHTML = document.getElementById("box".concat(locIUse.toString())).innerHTML;
    	document.getElementById("box".concat(locIUse.toString())).innerHTML = "&nbsp;";
    	locIUse= locIUse-bigness;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderTop = "5px solid red";
}
function moveRight(){
    	if(document.getElementById("box".concat((locIUse+1).toString())).innerHTML.indexOf("enemy") > -1){
    		enterFight(document.getElementById("box".concat((locIUse+1).toString())).getElementsByClassName("enemy")[0].id);
    	}
    	document.getElementById("box".concat((locIUse+1).toString())).innerHTML = document.getElementById("box".concat(locIUse.toString())).innerHTML;
    	document.getElementById("box".concat(locIUse.toString())).innerHTML = "&nbsp;";
    	locIUse++;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderRight = "5px solid red";
}
function exitRight(){
    	    checker = false;
    	    locIUse = locIUse - bigness + 1;
    	    locIdUse = east;
    	    $.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callleaveR": locIUse, "magicsauce": locIdUse},
	    success: function(response) { 
	    if (response){
	  		response = response.slice(0);}
    	    $("div").remove();
    	    document.getElementsByTagName("body")[0].innerHTML = response[0] + document.getElementsByTagName("body")[0].innerHTML;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderRight = "5px solid red";
    	east = response[3];
    	west = response[4];
    	north = response[1];
    	south = response[2];
    	enemyLevel = response[5];
    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "getEnemies": locIdUse},
	    success: function(response) { 
	    	drawEnemies(response);
	    	checker = true;
	    }
	});
	    },
		dataType: "json"
	    });
}
function exitLeft(){
    	    checker = false;
    	    locIUse = locIUse + bigness -1;
    	    locIdUse = west;
    	    $.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callleaveR": locIUse, "magicsauce": locIdUse},
	    success: function(response) { 
	    if (response){
	  		response = response.slice(0);}
    	    $("div").remove();
    	    document.getElementsByTagName("body")[0].innerHTML = response[0] + document.getElementsByTagName("body")[0].innerHTML;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderLeft = "5px solid red";
    	east = response[3];
    	west = response[4];
    	north = response[1];
    	south = response[2];
    	enemyLevel = response[5];
    	    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "getEnemies": locIdUse},
	    success: function(response) { 
	    	drawEnemies(response);
	    	checker = true;
	    }
	});
	    	
	    },
		dataType: "json"
	    });
}
function exitDown(){
    	    checker = false;
    	    locIUse = locIUse - bigness*(bigness-1);
    	    locIdUse = south;
    	    $.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callleaveR": locIUse, "magicsauce": locIdUse},
	    success: function(response) { 
	    if (response){
	  		response = response.slice(0);}
    	    $("div").remove();
    	    document.getElementsByTagName("body")[0].innerHTML = response[0] + document.getElementsByTagName("body")[0].innerHTML;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderBottom = "5px solid red";
    	east = response[3];
    	west = response[4];
    	north = response[1];
    	south = response[2];
    	enemyLevel = response[5];
    	    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "getEnemies": locIdUse},
	    success: function(response) { 
	    	drawEnemies(response);
	      	checker = true;
	    }
	});
	    },
		dataType: "json"
	    });
}
function exitUp(){
    	    checker = false;
    	    locIUse = locIUse + bigness*(bigness-1);
    	    locIdUse = north;
    	    $.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callleaveR": locIUse, "magicsauce": locIdUse},
	    success: function(response) { 
	    if (response){
	  		response = response.slice(0);}
    	    $("div").remove();
    	    document.getElementsByTagName("body")[0].innerHTML = response[0] + document.getElementsByTagName("body")[0].innerHTML;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderTop = "5px solid red";
    	east = response[3];
    	west = response[4];
    	north = response[1];
    	south = response[2];
    	enemyLevel = response[5];
    	    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "getEnemies": locIdUse},
	    success: function(response) { 
	    	drawEnemies(response); 
	    	checker = true;
	    }
	});
	    },
		dataType: "json"
	    });
}

var mytimer = setInterval(function(){moveEnemies();}, 1000);
var checker = true;
document.onkeypress = function(evt) {
if(checker){
    evt = evt || window.event;
    var charCode = evt.keyCode || evt.which;
    var charStr = String.fromCharCode(charCode);
    buttonPresser(charCode);
}
};

function buttonPresser(charCode){
    if (charCode == 97 && locIUse >offside && locIUse % bigness != offside && document.getElementById("box".concat((locIUse-1).toString())).getElementsByClassName("object").length == 0){
		moveLeft();
    }
	else if (charCode == 115 && locIUse <bigness*(bigness-1)+offside && document.getElementById("box".concat((locIUse+bigness).toString())).getElementsByClassName("object").length == 0){
		moveDown();
    }
	else if (charCode == 119 && locIUse >bigness+offside-1 && document.getElementById("box".concat((locIUse-bigness).toString())).getElementsByClassName("object").length == 0){
		moveUp();
    }
	else if (charCode == 100 && locIUse >offside-1 && locIUse % bigness != offside-1 && document.getElementById("box".concat((locIUse+1).toString())).getElementsByClassName("object").length == 0){
		moveRight();
    }
	else if (charCode == 100 && locIUse >offside-1 && locIUse % bigness == offside-1){
		exitRight();
    }
	else if (charCode == 97 && locIUse >offside-1 && locIUse % bigness == offside){
		exitLeft();
    }
	else if (charCode == 115  && locIUse >bigness*(bigness - 1) + offside -1){
	    exitDown();
    }
	else if (charCode == 119 && locIUse > offside-1 && locIUse < bigness+offside){
	    exitUp();
    }
}