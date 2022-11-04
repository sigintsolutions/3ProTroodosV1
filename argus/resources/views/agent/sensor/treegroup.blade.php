
<!--sensor tree group-->
<div class="row">
	<div class="col-md-12">
		<div class="card euz_carb rounded-0 text-white">
			<div class="card-body">
				<h4 class="card-title m-0"><i class="fas fa-portrait text-info"></i> <?php echo $user[0]->fname.' '.$user[0]->lname; ?> / @foreach($groups as $item2) @if($group[0]->sensor_group_id==$item2->id) {{ $item2->name }} @endif @endforeach<a href="javascript:void(0)" class="closebtn float-right" onclick="profileclosetree()">×</a></h4>
			</div>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#treecom">Visual Hierarchy</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="treecom">
				<div class="row">
					<div class="col-md-12">
						<ul class="tree">
							<li>
								<ul>
									<?php foreach($grouplists as $group) { ?>
									<li>
										<span>
											<div class="group_tree text-white"><?php echo $group->name; ?></div>
										</span>
										<ul>
											<?php
												$hubs = DB::table('sensor_hubs')
												//->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
												->where('sensor_hubs.agent', $user[0]->id)
												->where('sensor_hubs.group_id', $group->id)
												->select('sensor_hubs.*', 'sensor_hubs.sensor_hub_id')
												//->orderBy('added_on', 'DESC')
												->get();
												//print_r($hubs);
												foreach($hubs as $hub) { 
												//if(!empty($hub->name)) {
											?>
											<li>
												<span>
													<div class="sensorhub_tree text-white"><?php echo $hub->hub_id; ?></div>
												</span>
												<ul>
													<?php
														$sensors = DB::table('sensors')->where('hub_id', $hub->id)->get();
														foreach($sensors as $sensor) {
													?>
													<li>
														<span>
															<div class="sensor_tree"><?php echo $sensor->sensor_id; ?></div>
														</span>
													</li>
													<?php } ?>
												</ul>
											</li>
											<?php }//} ?>
										</ul>
									</li>
									<?php } ?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>