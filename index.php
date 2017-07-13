<?php

include 'header.php';
include 'getcontent.php';

$agencyTag="ttc"; //could be changed later to use a different transit system

?>

<?php

    $url='http://webservices.nextbus.com/service/publicXMLFeed?command=routeList&a=ttc&r=5';
    $arr = get_content($url);

    $p = xml_parser_create();
    $vals = NULL;
    $index = NULL;
    xml_parse_into_struct($p, $arr, $vals, $index);
    xml_parser_free($p);

?>


<div class='row'>
<div class='col l3' style='margin-left:5%;margin-right:-30%;'>

    <h2>Choose your route</h2>

    <form name="findRouteTag" class="form-horizontal" method="post" action="index.php">
    
    <div class="input-field col l12">

    <select id='userRouteTag' name='userRouteTag' material-select>

    <?php

    foreach ($vals as $val)
    {
        if (isset($val['attributes']))
        {
            if (isset($val['attributes']['TAG']))
            {
            echo "<option value='{$val['attributes']['TAG']}'>{$val['attributes']['TITLE']}</option>";
            }
        }
    }

    ?>

    </select>
    </div> <!--end input-field class-->

    <button class="btn waves-effect waves-light" type="submit" name="getRouteTag" id="getRouteTag">Choose Route</button>


      </form>



       <?php
        //once route is submitted
        if(isset($_POST['getRouteTag']))
        {
          $routeTag = $_POST['userRouteTag'];
        }

    ?>


    <?php

        $url2='http://webservices.nextbus.com/service/publicXMLFeed?command=routeConfig&a=ttc&r=' . $routeTag;
        $arr2 = get_content($url2);

        $p2 = xml_parser_create();
        $vals2 = NULL;
        $index2 = NULL;
        xml_parse_into_struct($p2, $arr2, $vals2, $index2);
        xml_parser_free($p2);


    ?>


<br/>
<br/>

    <h2>Then enter your stop</h2>

    <form name="findStopId" class="form-horizontal" method="post" action="displayInfo.php" >


    <div class="input-field col l12">

    <select id='userStopId' name='userStopId' material-select>

    <?php

    foreach ($vals2 as $val)
    {
        //once stop is submitted
        if (isset($val['attributes']))
        {
            if (isset($val['attributes']['STOPID']))
            {
            echo "<option value='{$val['attributes']['STOPID']}|" . $routeTag . "|{$val['attributes']['LAT']}|{$val['attributes']['LON']}'>{$val['attributes']['TITLE']}</option>";
            }
        }
    }

    ?>

    </select>
    </div><!--end input-field div-->
    

    <button class="btn waves-effect waves-light" type="submit" name="getStopId" id='getStopId'>Choose Stop ID</button>


    </form>



</div> <!--end col wrap-->

<div class='col l9'>

<div class='indexPicsCar' style='width:100%;margin-left:0px;'>
    
    <script>
    materialbox();
    </script>
    
    <div style='width:23%;display:inline-block;vertical-align:top;margin-bottom:10px;'>
        <img class="materialboxed" src="images/1.jpg" style='width:80%;margin-left:10%;'>
    </div>

    <div style='width:23%;display:inline-block;vertical-align:top;margin-bottom:10px;'>
        <img class="materialboxed" src="images/2.jpg" style='width:80%;margin-left:10%;'>
    </div>

    <div style='width:23%;display:inline-block;vertical-align:top;margin-bottom:10px;'>
        <img class="materialboxed" src="images/3.jpg" style='width:80%;margin-left:10%;'>
    </div>

    <div style='width:23%;display:inline-block;vertical-align:top;margin-bottom:10px;'>
            <img class="materialboxed" src="images/4.jpg" style='width:80%;margin-left:10%;'>
    </div>

        <div style='width:23%;display:inline-block;vertical-align:top;margin-bottom:10px;'>
        <img class="materialboxed" src="images/5.jpg" style='width:80%;margin-left:10%;'>
    </div>

    <div style='width:23%;display:inline-block;vertical-align:top;margin-bottom:10px;'>
        <img class="materialboxed" src="images/6.jpg" style='width:80%;margin-left:10%;'>
    </div>

    <div style='width:23%;display:inline-block;vertical-align:top;margin-bottom:10px;'>
        <img class="materialboxed" src="images/7.jpg" style='width:80%;margin-left:10%;'>
    </div>

    <div style='width:23%;display:inline-block;vertical-align:top;margin-bottom:10px;'>
        <img class="materialboxed" src="images/8.jpg" style='width:80%;margin-left:10%;'>
    </div>

</div><!--end indexPicsCar-->




</div><!--end col and index wrap-->


</div><!--end row-->



<?php

include 'footer.php';

?>
