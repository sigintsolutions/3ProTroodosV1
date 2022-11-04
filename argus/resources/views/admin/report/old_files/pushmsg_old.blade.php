
<style type="text/css">
    .grcolor{
        color:#1f3db3; !important;
    }
/*td{
    color:green;
}*/

</style>


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
                <tr id="tr<?php echo $message->pid;?>" >
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?> ><?php echo $i; //echo $message->readflag;?></td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>>{{ $message->fname }} {{ $message->lname }}</td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>>{{ $message->name }}</td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>><?php echo $message->hub_id; ?></td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>><?php echo $message->sensor_id; ?></td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>><?php echo $message->created_at; ?></td>
                    <td <?php if ($message->readflag==0){?> class="grcolor" <?php } ?>><?php /* {{ Str::limit($message->push_message, $limit = 10, $end = '...') }}*/ ?><a href="#" onclick="updateread(<?php echo $message->pid;?>);"class="euz_inblue" data-toggle="modal" data-target="#pushinfo{{ $message->pid }}"><i class="fas fa-eye"></i> View</a></td>
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
                </div>
                <?php $i++; } ?>
            </tbody>
        </table>
    </div>
    <?php /* {{ $messages->links() }} */ ?>
</div>

<script type="text/javascript">



    function updateread(msgid){
       // alert(msgid);

$.ajax(
        {
            url: "{{ url('/admin/uppushmsgreadflag') }}",
            type: "get",
            data:{msgid:msgid},
            success: function(data)
            {
                //alert("Read");
                //$("#msglists").html(data);
//$("#tr"+msgid).removeClass('grcolor');
$("#tr"+msgid).find('td').removeClass("grcolor");
$.ajax(
        {
            url: "{{ url('/admin/uppushmsgreadflagcount') }}",
            type: "get",
            data:{msgid:msgid},
            success: function(data)
            {
               // $(".cmsg").html(data);

                //$(".agentmsgc").hide();

if (data==0){
                    $(".cmsg").hide();
                    $(".adminmsgc").hide();
                }
                else{
                    //alert("kkk"+data);
                    // $(".cmsgagent").show();
                    //$(".cmsg").html(data);
                    $(".cmsg").html("New "+data);
                    $(".cmsg").css("display","block");
                    $(".adminmsgc").css("display","block");
                }







            }});



            }
        });
    }


</script>