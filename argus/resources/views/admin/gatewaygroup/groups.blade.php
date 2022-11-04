@extends('layouts.admin')
@section('content')

<!--Adding groups-->
    <div class="p-3">
        <div class="row">
            <div class="col-md-12 euz_bar euz_b">
                <i class="fas fa-user euz_text_blue"></i> <?php echo $user[0]->fname; ?> / <span class="euz_ac_bl">Gateway Group</span>
            </div>
            @if(Session::has('flash_message'))
            <div class="alert alert-success w-100"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('flash_message') }}</div>
            @endif
            <div class="col-md-12 euz_border p-3 bg-white">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <a class="btn btn-primary float-right rounded-0 ml-2" href="<?php echo url('/admin/agents'); ?>"><i class="far fa-arrow-alt-circle-left"></i> Back To Agent</a>
                        <a class="btn btn-success float-right rounded-0 ml-2" href="#" href="" data-toggle="modal" data-target="#groupimport"><i class="fas fa-file-upload"></i> Import</a>
                    </div>
                    <?php foreach($groups as $group) { ?>
                    <div class="col-md-3 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="custom-checkbox">
                                    <label class="euz_check_box euz_b"><?php echo $group->name; ?>
                                        <input type="checkbox" class="euz_check_agent">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="card-body pb-0 euz_b">
                                <p class="mb-2">SIM Carde Number : <?php echo $group->sim_no; ?></p>
                                <p class="mb-2">Longitude : <?php echo $group->longitude; ?> &nbsp;&nbsp;|&nbsp;&nbsp; Latitude : <?php echo $group->latitude; ?></p>
                            </div> 
                            <div class="card-footer text-right bg-white euz_card_fo">
                                <span class="ml-2 float-left euz_gren"><i>Sensor Hub : 2</i></span>
                                <a href="#" class="ml-2" data-toggle="tooltip" data-placement="top" title="Profile" onclick="profileopen()"><i class="fas fa-eye euz_a_icon"></i></a>
                                <a href="hub.html" class="ml-2" data-toggle="tooltip" data-placement="top" title="Add Sensor Hub"><i class="fab fa-hubspot euz_a_icon"></i></a>
                                <a href="#" class="ml-2" data-toggle="modal" data-target="#groupedit"><i class="fas fa-edit euz_a_icon"></i></a>
                                <a href="#" class="ml-2"><i class="fas fa-trash-alt euz_a_icon"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>			
        </div>
    </div>
    <!---Add import group---->
    <div class="modal fade" id="groupimport">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable euz_w_90">
            <div class="modal-content" style="width: 40%;">
                <div class="modal-header euz_carb p-0">
                    <h5 class="modal-title p-2 text-white">Import Groups</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data" action="{{ url('/admin/import_excel/importgroup') }}">
                    {{ csrf_field() }}
                    <input type="text" name="agent" value="<?php echo $user[0]->id; ?>" /> 
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12">
                                <label class="euz_b" for="">Upload File (Excel file only)</label>
                                <input type="file" class="form-control disname" id="" required name="select_file" accept=".xlsx, .xls" />
                            </div>					
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded-0" name="upload">Upload</button>
                        <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End import group--->
@endsection
@section('scripts')
@parent
@endsection
