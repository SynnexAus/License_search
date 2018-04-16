// JavaScript Document
/* -----------       AJAX STANDARD FUNCTION - START         ------------------ */
	var xmlHttp;
	// var wintest=0;
	function ajaxFunction()
	{
		try
		{
			// Firefox, Opera 8.0+, Safari
			xmlHttp=new XMLHttpRequest();
		}
		catch (e)
		{
			// Internet Explorer
			try
			{
				xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch (e)
			{
				try
				{
					xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (e)
				{
					alert("Your browser does not support AJAX!");
					return false;
				}
			}
		}
	}
	/* -----------       AJAX STANDARD FUNCTION - END         ------------------ */
	
	/* -----------       CALL FUNCTION FOR AJAX OUTPUT - START         ------------------ */
	function ajaxoutput(outputdiv, pageurl, arglist)	// onchange="ajaxoutput('subcatdiv', 'test2.php', new Array('mid','cid'))"	: divname, ajaxphpname, required textfield
	{
		document.getElementById(outputdiv).innerHTML="";
		document.getElementById(outputdiv).innerHTML="<img src='images/loader.gif' />";

		argcnt=arglist.length;
		argurl=pageurl+"?";
		for(a=0; a<argcnt; a++)
		{
			argurl = argurl + "&" + arglist[a] + "=" + document.getElementById(arglist[a]).value;
		}
		
		ajaxFunction();
		xmlHttp.onreadystatechange=function()
		{
			if(xmlHttp.readyState==4)
			{
				document.getElementById(outputdiv).innerHTML=xmlHttp.responseText;
			}
		}
		xmlHttp.open("GET",argurl,true);
		xmlHttp.send(null);
	}
	/* -----------       CALL FUNCTION FOR AJAX OUTPUT - START         ------------------ */
	/* -----------       CALL FUNCTION FOR AJAX OUTPUT - START         ------------------ */
	function ajaxoutputcate(outputdiv, pageurl, arglist)	// onchange="ajaxoutput('subcatdiv', 'test2.php', new Array('mid','cid'))"	: divname, ajaxphpname, required textfield
	{
		if(document.getElementById("main_location").value!="")
		{
			//$('#field_div').text('');
			document.getElementById("field_div").innerHTML="";
			document.getElementById("field_div1").innerHTML="";
			document.getElementById("field_div2").innerHTML="";
			document.getElementById("field_div3").innerHTML="";
		}
		if(document.getElementById("main_location").value=="")
		{
			document.location.reload(true);
		}
		
		document.getElementById(outputdiv).innerHTML="";
		document.getElementById(outputdiv).innerHTML="<img src='images/loader.gif' />";

		argcnt=arglist.length;
		argurl=pageurl+"?";
		for(a=0; a<argcnt; a++)
		{
			argurl = argurl + "&" + arglist[a] + "=" + document.getElementById(arglist[a]).value;
		}
		
		ajaxFunction();
		xmlHttp.onreadystatechange=function()
		{
			if(xmlHttp.readyState==4)
			{
				document.getElementById(outputdiv).innerHTML=xmlHttp.responseText;
			}
		}
		xmlHttp.open("GET",argurl,true);
		xmlHttp.send(null);
		
		
	}
	/* -----------       CALL FUNCTION FOR AJAX OUTPUT - START         ------------------ */
	/* -----------       CALL FUNCTION FOR AJAX OUTPUT - START         ------------------ */
	function ajaxoutputcatemain(outputdiv, pageurl, arglist)	// onchange="ajaxoutput('subcatdiv', 'test2.php', new Array('mid','cid'))"	: divname, ajaxphpname, required textfield
	{
		document.getElementById(outputdiv).innerHTML="";
		document.getElementById(outputdiv).innerHTML="<img src='images/loader.gif' />";

		argcnt=arglist.length;
		argurl=pageurl+"?";
		for(a=0; a<argcnt; a++)
		{
			argurl = argurl + "&" + arglist[a] + "=" + document.getElementById(arglist[a]).value;
		}
		
		ajaxFunction();
		xmlHttp.onreadystatechange=function()
		{
			if(xmlHttp.readyState==4)
			{
				document.getElementById(outputdiv).innerHTML=xmlHttp.responseText;
			}
		}
		xmlHttp.open("GET",argurl,true);
		xmlHttp.send(null);
		
		
	}
	/* -----------       CALL FUNCTION FOR AJAX OUTPUT - START         ------------------ */

function chkEqu()
{
	if(document.getElementById('title').value.split(" ").join("") == "")
	{
		alert("Please enter equipment title.");
		document.getElementById('title').focus();
		return false;
	}
}

function chkEventVal()
{
	if(document.getElementById('title').value.split(" ").join("") == "")
	{
		alert("Please enter event title.");
		document.getElementById('title').focus();
		return false;
	}
	if(document.getElementById('event_date').value.split(" ").join("") == "")
	{
		alert("Please enter event date.");
		document.getElementById('event_date').focus();
		return false;
	}
	if(document.getElementById('image_path').value.split(" ").join("") == "" && document.getElementById('id').value.split(" ").join("") == "0")
	{
		alert("Please select event image.");
		document.getElementById('image_path').focus();
		return false;
	}
	if(document.getElementById('image_path').value.split(" ").join("") != "")
	{
		extns=getfileextension(document.getElementById('image_path').value);
		if(extns==".jpg" || extns==".gif" || extns==".png" || extns==".jpeg")
		{
			return true
		}
		else
		{
			alert("Please select only .jpg, .jpeg, .gif or .png file for upload image.");
			return false;
		}
	}
}

function slideimg(){
	if(document.getElementById('title').value.split(" ").join("") == "")
	{
		alert("Please enter title.");
		document.getElementById('title').focus();
		return false;
	}
	if(document.getElementById('image_path').value.split(" ").join("") == "" && document.getElementById('id').value.split(" ").join("") == "0")
	{
		alert("Please select image.");
		document.getElementById('image_path').focus();
		return false;
	}
}

function checkUnAllFun(cbox)
{
	chklist=document.getElementsByName('chkid[]').length;
	if(cbox.checked==true)
	{
		for(aa=0; aa<chklist; aa++)
		{
			document.getElementsByName('chkid[]')[aa].checked=true;
		}
	}
	else
	{
		for(aa=0; aa<chklist; aa++)
		{
			document.getElementsByName('chkid[]')[aa].checked=false;
		}
	}
	//alert(chklist);
}


/*$(document).ready(function() {
    $("select").change(function(){
   //     alert(this.id);
    });
});*/

function check_delete()
{
	return confirm("Sure to delete selected record...?");
}