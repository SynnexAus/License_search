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
	
	
	function ajaxoutputmul(outputdiv, pageurl, arglist)	// onchange="ajaxoutput('subcatdiv', 'test2.php', new Array('mid','cid'))"	: divname, ajaxphpname, required textfield
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



	/* -----------       FUNCTIONS FOR ADD / REMOVE DYNAMIC DIV CONTENT - START         ------------------ */
	function add_element(parentdiv,countbox,htmlcode)
	{
		var ni = document.getElementById(parentdiv);
		var numi = document.getElementById(countbox);
		var num = (document.getElementById(countbox).value - 1) + 2;
		numi.value = num;
		var divIdName = parentdiv+"_child_"+num;
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		
		for(aa=1; aa<50; aa++)
		{
			htmlcode=htmlcode.replace('[NUM]',num);
		}
		htmlcode=htmlcode.replace('[PARENT]',parentdiv);
		htmlcode=htmlcode.replace('[CHILD]',divIdName);
		newdiv.innerHTML = htmlcode;
		ni.appendChild(newdiv);		
		
	}
	
	function add_element_price(parentdiv,countbox,htmlcode)
	{
		var ni = document.getElementById(parentdiv);
		var numi = document.getElementById(countbox);
		var tot = document.getElementById(countbox).value;
		if(tot<5)
		{
		var num = (document.getElementById(countbox).value - 1) + 2;
		numi.value = num;		
		
		var divIdName = parentdiv+"_child_"+num;
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		
		for(aa=1; aa<=50; aa++)
		{
			htmlcode=htmlcode.replace('[NUM]',num);
		}
		
			
		//heading.innerHTML = "<td width='150'></td><td>lkjlk</td>";
		htmlcode=htmlcode.replace('[PARENT]',parentdiv);
		htmlcode=htmlcode.replace('[CHILD]',divIdName);
		
		document.getElementById("heading").innerHTML="<table width='450' border='0' cellpadding='0' cellspacing='0' class='formmaintable'><tr><td><b>Qty. From</b></td><td><b>Price ($)</b></td><td width='25' align='center'></td></tr><tr></tr></table>";
		
		newdiv.innerHTML = htmlcode;
		ni.appendChild(newdiv);		
		}else{
			alert("Sorry, you can add maximum five price");
		
		}
		
		
		
		
		
	}
	
	
	function add_element_price_opt(parentdiv,countbox,htmlcode)
	{
		var ni = document.getElementById(parentdiv);
		var numi = document.getElementById(countbox);
		var tot = document.getElementById(countbox).value;	
		//alert(tot);
		var num = (document.getElementById(countbox).value - 1) + 2;
		
		numi.value = num;		
		
		var divIdName = parentdiv+"_child_"+num;
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		
		for(aa=1; aa<=50; aa++)
		{
			htmlcode=htmlcode.replace('[NUM]',num);
		}
		
		//heading.innerHTML = "<td width='150'></td><td>lkjlk</td>";
		htmlcode=htmlcode.replace('[NUM_SUB]',num);
		htmlcode=htmlcode.replace('[PARENT]',parentdiv);
		htmlcode=htmlcode.replace('[CHILD]',divIdName);		
		newdiv.innerHTML = htmlcode;
		ni.appendChild(newdiv);	
	}
	
	function add_element_price_optsub(parentdiv,countbox,htmlcode,curnum)
	{
		//alert(countbox);
		var ni = document.getElementById(parentdiv);
		
		var numi = document.getElementById(countbox);
		var tot = document.getElementById(countbox).value;	
		if(tot<5)
		{
		var curparent = document.getElementById("curp"+curnum).value= curnum;		
		//htmlcode=htmlcode.replace('[NUM1]',curnum);
		var num = (document.getElementById(countbox).value - 1) + 2;
		numi.value = num;		
		//alert(num);
		var divIdName = parentdiv+"_child_"+num;
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		
		for(aa=1; aa<=50; aa++)
		{
			htmlcode=htmlcode.replace('[SUBNUM]',num);			
			htmlcode=htmlcode.replace('[NUM]',curparent);
			
		}
		
		//heading.innerHTML = "<td width='150'></td><td>lkjlk</td>";
		htmlcode=htmlcode.replace('[PARENT]',parentdiv);
		htmlcode=htmlcode.replace('[CHILD]',divIdName);	
		
		document.getElementById("subhead"+curnum).innerHTML="<table width='450' cellspacing='0' cellpadding='0' border='0' class='formmaintable'><tbody><tr><td width='130' align='center'><b>QTY.</b></td><td  width='130' align='center'><b>Branding Price ($)</b></td><td  width='130' align='center'><b>Setup Price ($)</b></td></tr></tbody></table>";
		newdiv.innerHTML = htmlcode;
		ni.appendChild(newdiv);	
		}else{
			
			alert("Sorry, you can add maximum five price");
		
		}
		
		
		
	}
	
	function add_loc_element(parentdiv,countbox,ccount,htmlcode)
	{
		var ni = document.getElementById(parentdiv);
		//
		var divIdName = parentdiv+"_child_"+(parseInt(ccount)+1);
		//alert(divIdName);
		if(typeof(document.getElementById(divIdName)) != 'undefined' && document.getElementById(divIdName)!=null)
		{
			ii = 0
			for(i=parseInt(ccount)+1;i<=document.getElementById(countbox).value;i++)
			{
				//alert(i);
				ii++;
				ni.removeChild(document.getElementById(parentdiv+"_child_"+i));
			}
			document.getElementById(countbox).value = document.getElementById(countbox).value - (ii-1);
			
			//alert(divIdName);
			var newdiv = document.createElement('div');
			newdiv.setAttribute("id",divIdName);
			for(aa=1; aa<50; aa++)
			{
				htmlcode=htmlcode.replace('[NUM]',parseInt(ccount)+1);
			}
			htmlcode=htmlcode.replace('[PARENT]',parentdiv);
			htmlcode=htmlcode.replace('[CHILD]',divIdName);
			newdiv.innerHTML = htmlcode;
			ni.appendChild(newdiv);
		}
		else
		{
			var numi = document.getElementById(countbox);
			var num = (document.getElementById(countbox).value - 1) + 2;
			numi.value = num;
			
			var newdiv = document.createElement('div');
			newdiv.setAttribute("id",divIdName);
			for(aa=1; aa<50; aa++)
			{
				htmlcode=htmlcode.replace('[NUM]',parseInt(ccount)+1);
			}
			htmlcode=htmlcode.replace('[PARENT]',parentdiv);
			htmlcode=htmlcode.replace('[CHILD]',divIdName);
			newdiv.innerHTML = htmlcode;
			ni.appendChild(newdiv);
		}
		
		
		
	}
	
	function add_element_pricelist(parentdiv,countbox,htmlcode)
	{
		var ni = document.getElementById(parentdiv);
		var numi = document.getElementById(countbox);
		var tot = document.getElementById(countbox).value;
		if(tot<5)
		{
		var num = (document.getElementById(countbox).value - 1) + 2;
		numi.value = num;		
		
		var divIdName = parentdiv+"_child_"+num;
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		
		for(aa=1; aa<=50; aa++)
		{
			htmlcode=htmlcode.replace('[NUM]',num);
		}
		
			
		//heading.innerHTML = "<td width='150'></td><td>lkjlk</td>";
		htmlcode=htmlcode.replace('[PARENT]',parentdiv);
		htmlcode=htmlcode.replace('[CHILD]',divIdName);
		
		document.getElementById("heading").innerHTML="<table width='450' border='0' cellpadding='0' cellspacing='0' class='formmaintable'><tr><td align='center'><b>QTY.</b></td><td align='right'><b>Branding Price ($)</b></td><td align='center'><b>Setup Price ($)</b></td></tr><tr></tr></table>";
		
		newdiv.innerHTML = htmlcode;
		ni.appendChild(newdiv);		
		}else{
			alert("Sorry, you can add maximum five price");
		
		}
		
		
		
		
		
	}
	
	function remove_elementpricelist(parentdiv,childname,countbox)
	{
		
		if(confirm("Sure to delete this price...?"))
		{
			var d = document.getElementById(parentdiv);
			var olddiv = document.getElementById(childname);
			var numi = document.getElementById(countbox);
			
			//alert(numi)
			var num = (document.getElementById(countbox).value - 1);
			if(num==0)
			{
				document.getElementById("heading").innerHTML="";
			}
			numi.value = num;
			
			d.removeChild(olddiv);
		}
	}
	function remove_element(parentdiv,childname)
	{
		if(confirm("Sure to delete this Image...?"))
		{
			var d = document.getElementById(parentdiv);
			var olddiv = document.getElementById(childname);
			d.removeChild(olddiv);
		}
	}
	
	function remove_elementprice(parentdiv,childname,countbox)
	{
		if(confirm("Sure to delete this price...?"))
		{
			var d = document.getElementById(parentdiv);
			var olddiv = document.getElementById(childname);
			var numi = document.getElementById(countbox);
			//alert(numi)
			var num = (document.getElementById(countbox).value - 1);
			if(num==0)
			{
				document.getElementById("heading").innerHTML="";
			}
			numi.value = num;
			
			d.removeChild(olddiv);
		}
	}
	
	
	function remove_elementprice_opt(parentdiv,childname,countbox)
	{
		if(confirm("Sure to delete this price...?"))
		{
			var d = document.getElementById(parentdiv);
			var olddiv = document.getElementById(childname);
			var numi = document.getElementById(countbox);
			//alert(numi)
			var num = (document.getElementById(countbox).value - 1);
			if(num==0)
			{
				document.getElementById("heading").innerHTML="";
			}
			numi.value = num;
			
			d.removeChild(olddiv);
		}
	}
	
	function remove_elementprice_optsub(parentdiv,childname,countbox,rehead)
	{
		if(confirm("Sure to delete this price...?"))
		{
			var d = document.getElementById(parentdiv);
			var olddiv = document.getElementById(childname);
			var numi = document.getElementById(countbox);
			
			var num = (document.getElementById(countbox).value - 1);
			
			if(num==0)
			{
				document.getElementById("subhead"+rehead).innerHTML="";
			}
			numi.value = num;
			
			d.removeChild(olddiv);
		}
	}
	
	
	/* -----------       FUNCTIONS FOR ADD / REMOVE DYNAMIC DIV CONTENT - END          ------------------ */
	
	
	/* -----------       FUNCTIONS FOR ADD / REMOVE DYNAMIC DIV CONTENT AT TOP - START         ------------------ */
	function add_element_top(parentdiv,countbox,htmlcode)
	{
		var ni = document.getElementById(parentdiv);
		var numi = document.getElementById(countbox);
		var num = (document.getElementById(countbox).value - 1) + 2;
		numi.value = num;
		var divIdName = parentdiv+"_child_"+num;
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		
		for(aa=1; aa<50; aa++)
		{
			htmlcode=htmlcode.replace('[NUM]',num);
		}
		htmlcode=htmlcode.replace('[PARENT]',parentdiv);
		htmlcode=htmlcode.replace('[CHILD]',divIdName);
		newdiv.innerHTML = htmlcode;
		//ni.appendChild(newdiv);
		if(ni.firstChild) ni.insertBefore(newdiv,ni.firstChild);
		else pa.appendChild(newdiv);
		
		var nn=0;
		for(aa=num; aa>=1; aa--)
		{
			adddiv="addressMsgDiv_"+aa;
			if(document.getElementById(adddiv))
			{
				nn++;
				document.getElementById(adddiv).innerHTML=addMsgArr[nn]+" Address";
			}
		}
	}
	function remove_element_top(parentdiv,childname,countbox)
	{
		if(confirm("Sure to delete this details...?"))
		{
			var d = document.getElementById(parentdiv);
			var olddiv = document.getElementById(childname);
			d.removeChild(olddiv);
		}
		var num = (document.getElementById(countbox).value - 1)+1;
		
		var nn=0;
		for(aa=num; aa>=1; aa--)
		{
			adddiv="addressMsgDiv_"+aa;
			if(document.getElementById(adddiv))
			{
				nn++;
				document.getElementById(adddiv).innerHTML=addMsgArr[nn]+" Address";
			}
		}
	}
	/* -----------       FUNCTIONS FOR ADD / REMOVE DYNAMIC DIV CONTENT - END          ------------------ */
	
	function addNewCompany(cmbid)
	{
		cname = prompt("Enter New Company Name","");
		if(cname != "" && cname!=null)
		{
			ajaxFunction();
			def = document.getElementById(cmbid).value;
			argurl = "add_company.php?cname=" + cname + "&def=" + def;

			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					document.getElementById(cmbid).innerHTML=xmlHttp.responseText;
				}
			}
			xmlHttp.open("GET",argurl,true);
			xmlHttp.send(null);
		}
	}

	function addNewInsComp(cmbid, cmbid2)
	{
		cname = prompt("Enter New Insurance Company Name","");
		if(cname != "" && cname!=null)
		{
			ajaxFunction();
			def = document.getElementById(cmbid).value;
			def2 = document.getElementById(cmbid2).value;
			argurl = "add_inscompany.php?cname=" + cname + "&def=" + def + "&def2=" + def2;

			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					cmbArr=xmlHttp.responseText.split('###SEP###');
					document.getElementById(cmbid).innerHTML=cmbArr[0];
					document.getElementById(cmbid2).innerHTML=cmbArr[1];
				}
			}
			xmlHttp.open("GET",argurl,true);
			xmlHttp.send(null);
		}
	}

	function deleteInsComp(cmbid, cmbid2)
	{
		def = document.getElementById(cmbid).value;
		def2 = document.getElementById(cmbid2).value;
		if(def=="")
		{
			alert("Please select Insurance Company to delete.");
			return false;
		}
		if(confirm("Sure to delete selected Insurance Company...?"))
		{
			ajaxFunction();
			argurl = "del_inscompany.php?def=" + def + "&def2=" + def2;

			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					cmbArr=xmlHttp.responseText.split('###SEP###');
					document.getElementById(cmbid).innerHTML=cmbArr[0];
					document.getElementById(cmbid2).innerHTML=cmbArr[1];
				}
			}
			xmlHttp.open("GET",argurl,true);
			xmlHttp.send(null);
		}
	}

	function addNewOrigin(cmbid)
	{
		cname = prompt("Enter New Origin Name","");
		if(cname != "" && cname!=null)
		{
			ajaxFunction();
			def = document.getElementById(cmbid).value;
			argurl = "add_origin.php?cname=" + cname + "&def=" + def;

			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					document.getElementById(cmbid).innerHTML=xmlHttp.responseText;
				}
			}
			xmlHttp.open("GET",argurl,true);
			xmlHttp.send(null);
		}
	}
	
	function setMyKey(ev,txname)
	{
		/*var ev  = (window.event) ? window.event : e;
		
		if (ev.keyCode == 13)
		{	
			if(window.event)
			{
				ev.keyCode = 9;
				return ev.keyCode;
			}
			else
			{
				ev.e=9;
				return ev.e;
			}
		}*/
	}
	
	function setSuspendUser(chkbx)
	{
		ajaxFunction();
		xmlHttp.onreadystatechange=function()
		{
			if(xmlHttp.readyState==4)
			{
				//document.getElementById('stateDIV').innerHTML=xmlHttp.responseText;
				alert(xmlHttp.responseText);
			}
		}
		stsuspend=0;
		if(chkbx.checked) { stsuspend=1; }
		recid=chkbx.value;
		xmlHttp.open("GET","setusersuspend.php?uid="+recid+"&ust="+stsuspend,true);
		xmlHttp.send(null);
	}
