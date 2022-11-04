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
//DB::table('users')->orderBy('id')->chunk(100, function ($users) {
    //foreach ($users as $user) {
        //
    //}
                                    $sensorlists = DB::table('dbo_payloader')->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')->take(100)->where('sensor_hubs.agent',$agentid)->orderby('dbo_payloader.id', 'desc')->select('time','dbo_payloader.hub','sensor_id','value')->get();


                                    foreach($sensorlists as $sensorlist) { ?>
                                    <tr>
                                        <td><?php echo $sensorlist->time; ?></td>
                                        <td><?php echo $sensorlist->hub; ?></td>
                                        <td><?php echo $sensorlist->sensor_id; ?></td>
                                        <td><?php echo $sensorlist->value; ?></td>
                                    </tr>
                                    <?php } 

//});
                                    ?>
								</table>    