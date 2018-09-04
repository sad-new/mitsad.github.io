<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="row">                                                   
                <div class="col-sm-4 col-md-7 col-lg-5 btnaddteacher">
                    <button type="button" 
                    class="btn btn-primary" 
                    data-toggle="modal" 
                    data-title="addclass" 
                    data-target="#addClass" 
                    id="button_Main_AddClass">
                    Add Class
                    </button>
                </div>
            </div>
            <!--row-->


            <div class="container teacher-table">
                <div class="row">       
                    <div class="col-md-12" style="float: left; width:100%">
                        
                        <h4>Select Class</h4>

                        <div class="container">  

                            <div class="col-sm-2 col-md-5 col-lg-3">
                                <div class="form-group">
                                    <label>School Year</label>
                                    <select class="form-control" id = "dropDown_Main_SYTerm">
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-2 col-md-5 col-lg-3">
                                <div class="form-group">
                                    <label>Grade Level</label>
                                    <select class="form-control" id = "dropDown_Main_GradeLevel">
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="panel-heading" id = "classChartName">
                            List of Registered Classes for School Year X
                        </div>


                        <div class="table-responsive" id = "mainTableContainer"
                        style="overflow-x:auto;"
                        >               
 
                        </div>
                        
                    </div>
                </div>
            </div> 
            <!-- /Container teacher table -->



        </div>
    </div>
</div>
<!--/.row-->    