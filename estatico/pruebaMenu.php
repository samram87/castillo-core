<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" href="/core/estilos/redmond/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
        <title>Prueba Menu</title>
        <style type="text/css" >
#menuHorizontalUsuario {
text-align: center;
font-size: 10.5px !important;
margin: 0px auto;
}
#menuHorizontalUsuario ul { list-style-type: none;}
#menuHorizontalUsuario ul li.horNivel1 { float: left;
width: 162px;
margin-right: 2px;
}
#menuHorizontalUsuario ul li a {
    display: block;
text-decoration: none;
color: #fff;
background-color: #399;

padding: 8px;
position: relative;
/*padding: 0.4em;
position: relative;

padding-left: 2em;
padding-right: 2em;*/
}
#menuHorizontalUsuario ul li:hover {
position: relative;

}
#menuHorizontalUsuario ul li a:hover, #menuHorizontalUsuario ul li:hover a.horNivel1 {
position: relative;

}
#menuHorizontalUsuario ul li a.horNivel1 {
display: block!important;display: none;
position: relative;
}
#menuHorizontalUsuario ul li ul {
display: none;
}
#menuHorizontalUsuario ul li a:hover ul, #menuHorizontalUsuario ul li:hover ul {
display: block;
position: absolute;
left: 0px;
/*
margin: 0px;
margin-top: -0.1em;
padding: 0px;
border: 1px solid #C5DBEC;
background-color: white;
*/
}
#menuHorizontalUsuario ul li ul li a {
width:100px !important;
padding: 0px;
padding-top: 3px;
padding-bottom: 3px;
/*
font-size: 10.5px;
color: #2E6E9E;
font-weight: bold;
*/
}
#menuHorizontalUsuario ul li ul li a:hover {
position: relative;

}
table.falsa {border-collapse:collapse;
border:0px;
float: left;
position: relative;
}
</style>
    </head>
    <body>

<div id="menuHorizontalUsuario">

<ul>
  <li class="horNivel1" ><a href="#" class="ui-corner-bl ui-corner-tl ui-button ui-widget ui-state-default ui-button-text-only">Opción 1</a>
<!--[if lte IE 6]><a href="#" class="horNivel1ie">Opción 1<table class="falsa"><tr><td><![endif]-->
	<ul class="ui-corner-bl ui-corner-br">
		<li><a href="#">Opción 1.1</a></li>
		<li><a href="#">Opción 1.2</a></li>
	</ul>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
  </li>

  <li class="horNivel1"><a href="#" class="ui-button ui-widget ui-state-default ui-button-text-only">Opción 2</a>
<!--[if lte IE 6]><a href="#" class="horNivel1ie">Opción 2<table class="falsa"><tr><td><![endif]-->
	<ul class="ui-corner-bl ui-corner-br">
		<li><a href="#">Opción 2.1</a></li>
		<li><a href="#">Opción 2.2</a></li>
		<li><a href="#">Opción 2.3</a></li>
		<li><a href="#">Opción 2.4</a></li>

		<li><a href="#">Opción 2.5</a></li>
	</ul>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
  <li class="horNivel1"><a href="#" class="ui-button ui-widget ui-state-default ui-button-text-only">Opción 3</a>
<!--[if lte IE 6]><a href="#" class="horNivel1ie">Opción 3<table class="falsa"><tr><td><![endif]-->
	<ul class="ui-corner-bl ui-corner-br">
		<li><a href="#">Opción 3.1</a></li>
		<li><a href="#">Opción 3.2</a></li>

		<li><a href="#">Opción 3.3</a></li>
	</ul>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
  <li class="horNivel1"><a href="#" class="ui-corner-br ui-corner-tr ui-button ui-widget ui-state-default ui-button-text-only">Opción 4</a>
<!--[if lte IE 6]><a href="#" class="horNivel1ie">Opción 4<table class="falsa"><tr><td><![endif]-->
	<ul class="ui-corner-bl ui-corner-br">
		<li><a href="#">Opción 4.1</a></li>
		<li><a href="#">Opción 4.2</a></li>

		<li><a href="#">Opción 4.3</a></li>
		<li><a href="#">Opción 4.4</a></li>
	</ul>
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
</ul>
</div>
    </body>
</html>
