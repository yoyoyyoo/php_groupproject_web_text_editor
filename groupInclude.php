<?php

function WriteHeaders($Heading = "Welcome", $TitleBar = "MySite",$FileName="")
{
	echo "
        <!doctype html>
        <html lang=\"en\">

        <head>
	        <meta charset=\"UTF-8\">
	        <title>$TitleBar</title>
            <script src = \"groupJavaScript.js\"></script>
        </head>
        <link rel =\"stylesheet\" type = \"text/css\" href=\"$FileName\"/>
        <body>
        <h1>$Heading - Manlin Mao, Phil Young, Jacob Vowles, Xuancheng Li, 
                        Michael Feisthauer, Yanan Liu</h1>\n";
}

function DisplayLabel($TextInput)
{
    echo "<label>$TextInput</label>";
}

function DisplayTextbox($InputV,$Name,$Size,$Value=0,$Checked="")
{
    echo "<input type=$InputV name=\"$Name\" Size=$Size 
    value=$Value $Checked>";
}

function DisplayImage($FileName,$Alt,$Height=50,$Width=100)
{
    echo "<img src = $FileName alt=$Alt height=$Height width= $Width>";
}

function DisplayButton($Name,$Text,$FileName="",$Alt="")
{
    if ($FileName=== "")
    {
        echo" <button name=\"$Name\" 
        >$Text";
        echo "</button>";
    }
    else 
    {
        echo " <button name=\"$Name\" 
        >";
        DisplayImage($FileName,$Alt,$Height=25,$Width=50);
        echo "</button>";
    }
}

function DisplayContactInfo(){
    echo "<footer>Questions? Comments? Email us! 
   <a href= \"mailto:manlin.mao@student.sl.on.ca\"> Manlin Mao,</a>
   <a href= \"mailto:jacobchristopheresan.vowles@student.sl.on.ca\">
             Jacob Vowles,</a>
   <a href= \"mailto:xuancheng.li@student.sl.on.ca\"> Xuancheng Li,</a>
   <a href= \"mailto:phil.young@student.sl.on.ca\"> Phil Young,</a>
   <a href= \"mailto:michael.feisthauer@student.sl.on.ca\"> Michael
             Feisthauer,</a>
   <a href= \"mailto:yanan.liu@student.sl.on.ca\"> Yanan Liu</a>
  
   </footer>
    ";
}

function WriteFooters()
{
    DisplayContactInfo();
	echo "</body>\n";
	echo "</html>\n";
}

function CreateConnectionObject()
{
    $fh = fopen("auth.txt","r");
    $Host =  trim(fgets($fh));
    $UserName = trim(fgets($fh));
    $Password = trim(fgets($fh));
    $Database = trim(fgets($fh));
    $Port = trim(fgets($fh)); 
    fclose($fh);

    $mysqlObj = new mysqli($Host, $UserName, $Password,$Database,$Port);

    if ($mysqlObj->connect_errno != 0) 
    {
     echo "<p>Connection failed. Unable to open database $Database. Error: "
              . $mysqlObj->connect_error . "</p>";
     exit;
    }
    return ($mysqlObj);
}
?>