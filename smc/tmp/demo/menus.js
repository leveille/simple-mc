<!--

// LAYERED MENUS

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function show() { //v6.0
  var i,p,v,obj,args=show.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'block':(v=='hide')?'none':v; }
    obj.display=v; }
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

// Hide all select boxes    
function hideSelect()
{
    if (document.all) // Only do this for IE
    {
        for (formIdx=0; formIdx<document.forms.length; formIdx++)
        {
            var theForm = document.forms[formIdx];
            for(elementIdx=0; elementIdx<theForm.elements.length; elementIdx++)
            {
                window.status += theForm[elementIdx].type;
                if(theForm[elementIdx].type == "select-one")
                {    theForm[elementIdx].style.visibility = "hidden";    }
            }
        }
    }
}

// Unhide all select boxes
function unhideSelect()
{
    if (document.all) // Only do this for IE
    {
        for (formIdx=0; formIdx<document.forms.length; formIdx++)
        {
            var theForm = document.forms[formIdx];
            for(elementIdx=0; elementIdx<theForm.elements.length; elementIdx++)
            {
                if(theForm[elementIdx].type == "select-one")
                {    theForm[elementIdx].style.visibility = "visible";    }
            }
        }
    }
}

//-->

