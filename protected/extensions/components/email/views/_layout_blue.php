<center>
	<!--  style="width:100%;max-height:129px" -->
	<table cellpadding="8" cellspacing="0" style="width:100%!important;background:#ffffff;margin:0;padding:0" border="0">
		<tbody>
			<tr>
				<td valign="top">
			<table cellpadding="0" cellspacing="0" align="center" border="0">
				<tbody>
					<tr>
						<td bgcolor="#279ed5" align="center" style="background-color: <?php echo $templateColor?>;color: #fff;">
							<br>
							<h1 style="font-family:'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif';">
								<?php #echo isset($head)?$head:"Starbox";?>
								<?php echo $templateTitle?>
							</h1>
						</td>
					</tr>
				<tr><td>

					<table cellpadding="0" cellspacing="0" style="border-left:1px <?php echo $templateColor?> solid;border-right:1px <?php echo $templateColor?> solid;border-bottom:1px <?php echo $templateColor?> solid;border-radius:0px 0px 4px 4px" border="0" align="center">
						<tbody><tr><td colspan="3" height="36"></td></tr>
							<tr><td width="36"></td>
								<td width="454"
									style="
										font-size:14px;
										color:#444444;
										font-family:'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif';
										border-collapse:collapse" align="left" valign="top">

											<?php echo $content;?>
											<br><br>
								</td>
								<td width="36"></td>
							</tr>
							<tr><td colspan="3" height="36"></td></tr>
						</tbody>
					</table>
				</td></tr>
				</tbody>
			</table>

				<table cellpadding="0" cellspacing="0" align="center" border="0">
				<tbody>
					<tr><td height="10"></td></tr>
					<tr><td style="padding:0;border-collapse:collapse">

				<table cellpadding="0" cellspacing="0" align="center" border="0">
					<tbody>
						<tr style="font-size:11px;color:#a8b9c6;font-family:'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'" valign="top">

						<td width="400" align="left"></td>
						<td width="128" align="right">© <?php echo date("Y")?> <a style="color: <?php echo $templateColor?>" href="<?php echo $templateLink?>"><?php echo $templateLink?></a></td>

						</tr>
					</tbody>
				</table>

					</td>
					</tr>
				</tbody>
				</table>
			</td></tr>
		</tbody>
	</table>
</center>