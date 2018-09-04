<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="row">                                                   
                <div class="col-sm-4 col-md-7 col-lg-5 btnaddteacher">
                    <button type="button" 
                    class="btn btn-primary" 
                    data-toggle="modal" 
                    data-title="addclasssubject" 
                    data-target="#addClassSubject" 
                    id="button_Main_AddClassSubject">
                    Add Class Subject
                    </button>
                </div>
            </div>
            <!--row-->


            <div class="container teacher-table">
                <div class="row">       
                    <div class="col-md-12" style="float: left; width:100%">
                        
                        <div class="container">  

                            <div class="col-sm-2 col-md-5 col-lg-3">
                                <div class="form-group">
                                    <label>Term Number</label>
                                    <select class="form-control" id = "dropDown_Main_SYTerm">
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="panel-heading" id = "classSubjectChartName">
                            List of Registered Subjects for ClassName in SY 20XX
                        </div>

                        <div class="table-responsive" id = "mainTableContainer">              
                        </div>
                        
                    </div>
                </div>
            </div> 
            <!-- /Container teacher table -->



        </div>
    </div>
</div>
<!--/.row-->    