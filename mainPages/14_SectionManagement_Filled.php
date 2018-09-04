<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            
            <div class="row">
                <div class="col-sm-2 col-md-5 col-lg-3">
                    <div class="form-group">
                        <label>Grade Level</label>
                        <select class="form-control" id = "dropDown_Main_GradeLevel">
                        </select>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-4 col-md-7 col-lg-5 btnaddteacher">
                    <button type="button" 
                    class="btn btn-primary" 
                    data-toggle="modal" 
                    data-title="addsection" 
                    data-target="#addsection" 
                    id="button_Main_AddSection">
                    Add Section
                    </button>
                </div>
            </div>


            <div class="container teacher-table">


                <div class="panel-heading" id = "sectionChartName">
                    List of Registered sections for Grade X
                </div>

                <div class="table-responsive" id = "mainTableContainer">               
                </div>
                        

            </div> 
            <!-- /Container teacher table -->

        </div>
    </div>
</div>
<!--/.row-->    