

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <?php 
                                    $activeTerm = getActiveTerm();
                                    $activeTermToBeDisplayed = "SY " .$activeTerm['schoolYear'] ." Term ". $activeTerm['termNumber'];
                                ?>
                                <h3>The Active Grading Period is <?php echo $activeTermToBeDisplayed; ?></h3>  
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-4 col-md-7 col-lg-5 btnaddteacher">
                                <button type="button" 
                                    class="btn btn-primary" 
                                    data-toggle="modal" 
                                    data-title="changeactivesyterm" 
                                    data-target="#changeActiveSYTerm" 
                                    id="button_ChangeActiveSYTermEntry">
                                    Change Active Grading Period
                                </button>
                            </div>    
                        </div>              


                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">


                        <div class="row">
                            <div class="col-sm-4 col-md-7 col-lg-5 btnaddteacher">
                                <button type="button" 
                                    class="btn btn-primary" 
                                    data-toggle="modal" 
                                    data-title="addsyterm" 
                                    data-target="#addSYTerm" 
                                    id="addSYTermEntry">
                                    Add School Year
                                </button>
                            </div>
                        </div>

                        <div class="container teacher-table">
                            <div class="row">       
                                <div class="col-md-12">
                                    
                                    <h4>List of School Terms</h4>

                                    <div class="table-responsive">               
                                        <table id="mytable" class="table table-bordred table-striped" width=100% >
                                                   
                                            <thead>                                
                                                <th>School Year</th>
                                                <th></th>
                                            </thead>

                                            <tbody>
                                                

                                                <?php

                                                    $yearArray = loadYears();  

                                                    foreach ($yearArray as $getRow)
                                                    {
                                                        $schoolYear_get  = $getRow['schoolYear']; 

                                                        echo "<tr>";

                                                            echo "<td class='clickable'> + ".$schoolYear_get. " - ".(+$schoolYear_get + 1)."</td>";
                                                            
                                                            echo '
                                                                <td>
                                                                    <p data-placement="top" data-toggle="tooltip" title="Delete">
                                                                        <button class="btn btn-danger btn-xs deleteSYTermEntry" 
                                                                        data-title="Delete" 
                                                                        data-toggle="modal" 
                                                                        data-target="#delete"
                                                                        value ='.$schoolYear_get.'> 

                                                                            <span class="glyphicon glyphicon-trash"></span>
                                                                        
                                                                        </button>
                                                                    </p>
                                                                </td>';

                                                        echo "</tr>";

                                                        echo "<tr><td colspan = '2'>";

                                                            echo "
                                                            <table id='mytable' class='table table-bordred table-striped'>
                                                            <thead>               
                                                                <th>Term</th> 
                                                                <th>Active</th> 
                                                                <th>    </th>
                                                            </thead>

                                                            <tbody>"; 

                                                            $syTermArray = loadTerms($schoolYear_get);  
                                                            foreach ($syTermArray as $getRow)
                                                            {
                                                                //GET
                                                                $syTermID_get    = $getRow['syTermID'];
                                                                $schoolYear_get  = $getRow['schoolYear'];   
                                                                $termNumber_get  = $getRow['termNumber'];
                                                                $isActive_get  = $getRow['isActive'];

                                                                echo "<tr></tr>"; 
                                                                //SET TO TABLE
                                                                echo "<tr>"; 
                                                                echo "<td><center value = '".$syTermID_get."'>".$termNumber_get."</center></td>";
                                                                echo "<td><center value ='".$isActive_get."'>"; 

                                                                if($isActive_get==1)
                                                                {
                                                                    echo "Yes";
                                                                }
                                                                else
                                                                {
                                                                    echo "No";
                                                                }

                                                                echo "</center></td>";

                                                                //EDIT
                                                                $buttonEdit =  
                                                                '<td>
                                                                <p data-placement="top" data-toggle="tooltip" title="Edit">
                                                                    
                                                                <button 
                                                                class="btn btn-primary btn-xs editSYTermEntry" 
                                                                data-title="Edit" 
                                                                data-toggle="modal" 
                                                                data-target="#edit"  
                                                                name = "editSYTermButton"
                                                                value ='.$syTermID_get.' 
                                                                >

                                                                <span class="glyphicon glyphicon-pencil"></span>
                                                                </button></p></td>';
                                                                echo $buttonEdit;

                                                                echo "</tr>";               
                                                            }

                                                            echo "</tbody></table>"; 
                                                        echo "</td></tr>";
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
            <!--/.row-->    

        </div>
    </div>
</div>
