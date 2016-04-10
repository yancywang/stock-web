<!DOCTYPE html>
<html>
  <head>
  <style type="text/css">
    #inin{
      border:0.5px solid grey;
      width:400px;
      height:160px;
      background-color:whitesmoke;
      border-style:solid;
      align:"center";
    }
    #bot1,#bot2{
      position:relative;
      bottom:10px;
      left:30px;
    }
    #tab1,#tab2,#tab3,#tab4{
      width:600px;
      position:relative;
      top: 20px;
      right:100px;
      border:solid 1px black;
      border-collapse:collapse;
    }

    #homepage{
      position: relative;
      bottom:10px;
    }


    td{
      border:solid 0.5px grey;
      background-color: snow;
    }

    th{
      text-align: left;
      border:solid 0.5px grey;
      background-color: whitesmoke;
    }

    pre{
      height:22px;
    }

    </style>
    <title>Homework6</title>

    <script language="JavaScript">
      function validateForm(){
        //header("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
        var x=document.forms["inputName"]["fName"].value;
        if(x==null||x==""){
          alert("Please enter Name or Symbol");
        }
      }
      function clearText(){
        var x=document.forms["inputName"]["fName"].value;
        var tab = document.getElementsByTagName("table").item(0);
        tab.parentNode.removeChild(tab);
        //alert(x);
      }
    </script>
  </head>
  <body>

    <div align='center' >
      <div id="inin" >
      <pre><h1><i>Stock Search</i></h1></pre>
      <hr style="height:0.5px; width:390px;border:none;border-top:1px solid grey;" />
      <form action="" name="inputName" method=get ><p align="left">
      Company Name or Symbol:<input type=text name="fName" value=<?php echo isset($_GET["fName"])?$_GET["fName"]:"";?>><br/></p>
      <input id="bot1" type=submit name="search" value="Search" onclick="validateForm()">
      <input id="bot2" type=button name="clear" value="Clear"   onclick="clearText()">
    </form>
    <a id="homepage" href="http://www.markit.com/product/markit-on-demand">
      Powered by Markit on Demand
    </a>
  </table>
    <?php
      if(isset($_GET['newitem'])): ?>

      <?php
        $json_url = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=".$_GET['newitem'];
        $json = file_get_contents($json_url)or die("<table border='1'><tr><th>There is no stock information available</th></tr></table>");
        $obj = json_decode($json);
        $date = date_create($obj->Timestamp);
        $cytd = round($obj->ChangeYTD,2);
        //date_timezone_set($date,'America/Los_Angeles');
        //echo<image href=http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png>
        if($obj->Status=="Failure|APP_SPECIFIC_ERROR"){
          echo "<table id='tab3'  align=center ><tr><th>There is no stock information available</th></tr></table>";
        }
        else{
          echo "<table id='tab4'  align='center'><tr><th>Name</th><td align='center'>".$obj->Name."</td></tr>";
          echo "<tr><th align='left'>Symbol</th><td align='center'>".$obj->Symbol."</td></tr>";
          echo "<tr><th align='left'>Last Price</th><td align='center'>".round($obj->LastPrice,2)."</td></tr>";
          echo "<tr><th align='left'>Change</th><td align='center'>".round($obj->Change,2);
          if(round($obj->Change,2)>0) echo"<image width=13px height=13px src='http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png'></image>";
          else if(round($obj->Change,2)<0) echo"<image width=13px height=13px src='http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png'></image>";
          echo"</td></tr>";
          echo "<tr><th align='left'>Change percent</th><td align='center'>".round($obj->ChangePercent,2)."%";
          if(round($obj->ChangePercent,2)>0) echo"<image width=13px height=13px src='http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png'></image>";
          else if(round($obj->ChangePercent,2)<0) echo"<image width=13px height=13px src='http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png'></image>";
          echo "</td></tr>";
          echo "<tr><th align='left'>Timestamp</th><td align='center'>".date_format($date,"Y-m-d h:m A")."(PST)</td></tr>";
          if($obj->MarketCap>1000000000){
            echo "<tr><th align='left'>Market Cap</th><td align='center'>".round($obj->MarketCap/1000000000,2)."B</td></tr>";
          }
          else{
            echo "<tr><th align='left'>Market Cap</th><td align='center'>".round($obj->MarketCap/1000000,2)."M</td></tr>";
          }
          echo "<tr><th align='left'>Volume</th><td align='center'>".number_format($obj->Volume)."</td></tr>";
          echo "<tr><th align='left'>Change YTD</th><td align='center'>";
          if($cytd<0) echo "(";
          echo $cytd;
          if($cytd<0) echo ")";
          if(round($obj->ChangeYTD,2)>0) echo"<image width=13px height=13px src='http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png'></image>";
          else if(round($obj->ChangeYTD,2)<0) echo"<image width=13px height=13px src='http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png'></image>";
          echo "</td></tr>";
          echo "<tr><th align='left'>Change Percent YTD</th><td align='center'>".round($obj->ChangePercentYTD)."%";
          if(round($obj->ChangePercentYTD,2)>0) echo"<image width=13px height=13px src='http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png'></image>";
          else if(round($obj->ChangePercentYTD,2)<0) echo"<image width=13px height=13px src='http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png'></image>";
          echo "</td></tr>";
          echo "<tr><th align='left'>High</th><td align='center'>".$obj->High."</td></tr>";
          echo "<tr><th align='left'>Low</th><td align='center'>".$obj->Low."</td></tr>";
          echo "<tr><th align='left'>Open</th><td align='center'>".$obj->Open."</td></tr>";
          echo "</table>";

      }
    //  echo $_GET["newitem"];
      //unset($_GET["newitem"]);
      //echo $_GET["newitem"];
        //echo $obj->LastPrice;
        //$_GET['newitem']=false;
      ?>

      <?php
      elseif(isset($_GET["search"])): ?>

      <?php
          $xml_url="http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=" .$_GET["fName"];
          //echo $xml_url;
          //$xml_file = simplexml_load_file("www.sdsdncjei");
          $xml_file = simplexml_load_file($xml_url) or die("<table id='tab2' ><tr><th>No Records has been found</th></tr></table>");
          //echo $xml_file->children()[0]->Symbol."<br>";
          echo "<table id='tab1' ><tr><th>Name</th><th>Symbol</th><th>Exchange</th><th>Detail</th></tr>";
          foreach($xml_file->children() as $child){
            $new_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?newitem=".$child->Symbol."&fName=". $_GET["fName"];
            //echo $new_url;
            echo "<tr><td>" . $child->Name."</td><td>".$child->Symbol."</td><td>".
            $child->Exchange."</td><td><a href='".$new_url."'>More info</a></td></tr>";
          }
          echo "</table>";
          //echo $xml_file->LookupResult[0]['Symbol']
          //print_r($xml_file);
          //$xml_file = file_get_contents($xml_url);
          //echo $xml_file;
        //  if($xml_file===false){
        //    echo "\n not read";
        //  }
        //  else{
        //    echo "\n read";
        //  }
        //unset($_GET["search"]);
    ?>


<?php endif ?>
    </div>
  </body>
</html>
