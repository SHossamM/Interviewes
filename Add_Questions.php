<?php session_start();
$_POST['inserted']=true;
?>

<html>
   
   <head>
      <title>Add Questions</title>
      
      
   </head>
   
   <body  style="padding-top: 3%;  ">

     
<?php
if(isset($_POST['A'])& isset($_POST['B'])& isset($_POST['C']) & isset($_POST['QUES']))
{
   $con= mysqli_connect("localhost", "root", "0000","interviewes");
       if(!$con)
       {  echo' could not connect';
           die('could not connect: '. mysqli_errno($link));}
      $AID=$_SESSION["id"];
          $BID=$_POST["branch"];
          $A=$_POST['A'];
          $B=$_POST['B'];
          $C=$_POST['C'];
          $ans=$_POST['ANS'];
          $ques=$_POST['QUES'];
          $diff=$_POST['DIFF'];

mysqli_select_db($con, "interviewes");
 $call=  mysqli_prepare($con, 'CALL AddQuestion(?,?,?,?,?,?,@ID)');
 mysqli_stmt_bind_param($call, 'sssssi',$A,$B,$C,$ans,$ques,$diff);
 mysqli_stmt_execute($call);
 $select=  mysqli_query($con,'select @ID');
$result=  mysqli_fetch_assoc($select);
$QID=$result['@ID'];
$call1=  mysqli_prepare($con, 'CALL AddQ_A(?,?,?)');
 mysqli_stmt_bind_param($call1, 'iii',$QID,$AID,$BID);
 mysqli_stmt_execute($call1);
 
}
     
       
?>
       <div align="center">
  <form action = "" method = "post">
      <label syle="color:orange;"> Please Insert all of your question required details</label></br>
      <label>Enter the question:</label><br/>
      <textarea  name="QUES" id="QUES" required></textarea><br/>
      <label>Answer A:</label><br/>
      <textarea id="A"  name="A" required></textarea><br/>
      <label>Answer B:</label><br/>
      <textarea id="B"  name="B" required></textarea><br/>
      <label>Answer C:</label><br/>
      <textarea id="C"  name="C" required></textarea><br/><br/>
      <label>Correct Answer:</label>
      <select name="ANS" id="ANS">
                       <option value="A" default>A</option>
                        <option value="B">B</option>
                         <option value="C">C</option>                     
       </select><br /><br/>
       
       <label>Choose Difficulty:</label>
      <select name="DIFF" id="DIFF">
                       <option value="1" default>1</option>
                        <option value="2">2</option>
                         <option value="3">3</option>     
                          <option value="4">4</option>
                         <option value="5">5</option>     
       </select><br /><br/>
       <label>Choose branch  :</label>
        <select name='branch' id="branch">
                    <?php
                    $con= mysqli_connect("localhost", "root", "0000","interviewes");
                     mysqli_select_db($con, "interviewes");
                     if($_SESSION["Priv"]==1)
                     {
                        $result=mysqli_query($con,"select * from branch");
                    while($row=mysqli_fetch_array($result))
                    {  
                        echo "<option value=".$row['ID'].">".$row['BranchName']."</option>";   
                    }
                  
                   
                     }
                         
                      else
                      {
                        $result=mysqli_query($con,"select * from branch where ID=".$_SESSION["bid"]);
                    while($row=mysqli_fetch_array($result))
                    {  
                        echo "<option value=".$row['ID'].">".$row['BranchName']."</option>";   
                    }                   
                      }
                      mysqli_close($con);  
                   
                 ?> 
            </select> <br/> <br/>
       <input type="submit"  value="Add">
           
               </form>	
       </div>
               
      

   </body>
</html>