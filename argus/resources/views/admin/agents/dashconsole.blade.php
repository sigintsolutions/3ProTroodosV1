
<!--Blade file for agent console-->
<table style="width:100%;">
									<tr>
										<td>
											<span style="border-bottom: #fff dashed 1px;">UTC</span>
										</td>
										<td>
											<span style="border-bottom: #fff dashed 1px;">Hub</span>
										</td>
										<td >
											<span style="border-bottom: #fff dashed 1px;">Sensor Id</span>
										</td>
										<td>
											<span style="border-bottom: #fff dashed 1px;">Value</span>
                                        </td>
									</tr>
									<?php 



                                    foreach($sensorlists as $sensorlist) { ?>
                                    <tr>
                                        <td><?php echo $sensorlist->utc; ?></td>
                                        <td><?php echo $sensorlist->hub; ?></td>
                                        <td><?php echo $sensorlist->sensor_id; ?></td>
                                        <td><?php echo $sensorlist->value; ?></td>
                                    </tr>
                                    <?php } 

//});
                                    ?>
								</table>    