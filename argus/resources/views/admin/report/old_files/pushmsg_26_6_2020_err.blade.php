

<div class="col-md-12">
    <div class="table-responsive-sm mt-3">
        <table class="table table-bordered table-striped">
            <thead class="euz_agent_table">
                <tr>
                    <th class="euz_agent_222">Sl.No</th>
                    <th class="euz_agent_222">Agent Name</th>
                    <th class="euz_agent_222">Gateway group</th>
                    <th class="euz_agent_222">Sensor Hub</th>
                    <th class="euz_agent_222">Sensor Id</th>
                    <th class="euz_agent_222">Notification Time</th>
                    <th class="euz_agent_222">Message</th>
                </tr>
            </thead>
            <tbody>


                  <?php $i = 1; foreach($messages as $index =>$message) { ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>{{ $message->fname }} {{ $message->lname }}</td>
                    <td>{{ $message->name }}</td>
                    <td><?php echo $message->hub_id; ?></td>
                    <td><?php echo $message->sensor_id; ?></td>
                    <td><?php echo $message->created_at; ?></td>
                    <td><a href="#" class="euz_inblue" data-toggle="modal" data-target="#pushinfo{{ $message->pid }}"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                <div class="modal fade" id="pushinfo{{ $message->pid }}">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header euz_bar_agent">
                                <p class="modal-title euz_b mb-0">Push Notification Content</p>
                                <button type="button" class="close" data-dismiss="modal">
                                <span>×</span>
                                </button>
                            </div>
                            <div class="modal-body euz_border_agent">
                                <p class="text-justify">
                                {{ $message->push_message }}
                                <p>
                            </div>
                        </div>
                    </div>
                </div></td>
                </tr>
                <?php $i++; } ?>
                </tbody>
        </table>
        </div>
    
</div>