<!DOCTYPE html>
<html>
<head>
	<title>Notificación</title>
</head>
<body>

<table width="100%" height="100%" align="center" border="0" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td>
				<table 
					align="center" 
					valign="top" 
					cellpadding="2" 
					cellspacing="0" 
					style="width:92.7%;max-width:510px;margin:25px auto; background: #FFF; border: 1px solid #454545; padding: 10px;" width="100%"
				> 
					<tbody>
						<tr>
							<td><p>Se te ha asignado la siguiente actividad, favor darle seguimiento.</p></td>
						</tr>
						<tr>
							<td style="font-family:'Open Sans',-apple-system,Helvetica,Arial,sans-serif!important;"><strong><?php echo $act->actividad->descripcion ?></strong></td>
						</tr>
						<tr>
							<td style="font-size: 0.8em; color: #454545">Entregar el <?php echo $act->actividad->compromiso ?></td>
						</tr>
						<tr>
							<td><hr></td>
						</tr>
						<tr>
							<td><?php echo $act->producto->titulo ?></td>
						</tr>
						<tr>
							<td><?php echo $act->especifico->descripcion ?></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table> 

</body>
</html>
