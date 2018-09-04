
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="row">           
                <div class="col-sm-4 col-md-7 col-lg-5 btnaddteacher">
                    <button type="button" 
                    class="btn btn-primary" 
                    data-toggle="modal" 
                    data-title="addteacher" 
                    data-target="#addteacher" 
                    id="button_Main_Add">
                    Add teacher
                    </button>
                </div>
            </div>

            <div class="container teacher-table">
                <div class="row">       
                    <div class="col-md-12">
                        
                        <h4>List of Accounts</h4>
                        <div class="table-responsive">               
                            <table id="mytable" class="table table-bordred table-striped">
                                       
                                <thead>                                                                
                                    <th>Account ID</th>
                                    <th>Username</th> 
                                    <th>User Type</th>
                                    <th>Employee Name</th>
                                    <th>    </th>
                                    <th>    </th>
                                </thead>

                                <tbody>


                                    <?php  
                                    
                                        $teacherArray = loadTables(); 
                                        $counter = 1;

                                        //while($getRow = mysql_fetch_array($teacherArray))
                                        foreach ($teacherArray as $getRow)
                                        {
                                            //GET
                                            $accountID_get     = $getRow['accountID'];
                                            $userName_get      = $getRow['userName'];
                                            $userType_get      = $getRow['userType'];   
                                            $accountImage_get  = $getRow['accountImage']; 
                                            $employeeID_get    = $getRow['employeeID']; 
                                            $employeeName_get  = $getRow['employeeName']; 
                                            $employeeImage_get = $getRow['employeeImage']; 
 
                                            //SET TO TABLE
                                            echo "<tr>"; 
                                            echo "<td><center>".$accountID_get."</center></td>";
                                            echo "<td><center>".$userName_get."</center></td>";
                                            echo "<td><center>".$userType_get."</center></td>";
                                            echo "<td><center>".$employeeName_get."</center></td>";

                                            //EDIT
                                            $buttonEdit =  
                                            '<td>
                                            <p data-placement="top" data-toggle="tooltip" title="Edit">
                                            
                                            <button 
                                            class="btn btn-primary btn-xs button_Table_Edit" 
                                            data-title="Edit" 
                                            data-toggle="modal" 
                                            data-target="#edit"  
                                            name = "editTeacherButton"
                                            value ='.$accountID_get.' 
                                            >

                                            <span class="glyphicon glyphicon-pencil"></span>
                                            </button></p></td>';

                                            //onClick="alert(Hello_world!)"

                                            echo $buttonEdit;

                                            //DELETE
                                            echo 
                                            '<td>
                                            <p data-placement="top" data-toggle="tooltip" title="Delete">
                                            <button class="btn btn-danger btn-xs button_Table_Delete" 
                                            data-title="Delete" 
                                            data-toggle="modal" 
                                            data-target="#delete"
                                            value ='.$accountID_get.'
                                            >


                                            <span class="glyphicon glyphicon-trash"></span>
                                            </button></p></td>';

                                            echo "</tr>"; 

                                            $counter ++;                        
                                        }

                                    ?>


                                </tbody>                
                            </table>                
                        </div>                                  
                    </div>
                </div>
            </div>
            <!-- /Container teacher table --> 

        </div>
    </div>
</div>