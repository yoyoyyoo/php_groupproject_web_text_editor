<?php //http://localhost/TeamCodingV3/groupMain.php

require_once("groupInclude.php");

function DrawMenu()
{
    echo"<div class=\"navbar\">";

        echo "<div class=\"dropdown\">";
            echo "<button class=\"dropbtn\">File </button>";
            echo"<div class=\"dropdown-content\">";
                drawFileDropDown();
            echo "</div>";
        echo "</div>";

        echo "<div class=\"dropdown\">";
            echo "<button class=\"dropbtn\">Edit </button>";
            echo"<div class=\"dropdown-content\">";
                drawEditDropDown();
            echo "</div>";
        echo "</div>";

        echo "<div class=\"dropdown\">";
            echo "<button class=\"dropbtn\">Font </button>";
            echo"<div class=\"dropdown-content\">";
                drawFontDropDown();
            echo "</div>";
        echo "</div>";

    echo "</div>";
}
function drawFileDropDown()
{
    DisplayButton("f_new", "New","./images/New.png","New Button");

    DisplayButton("f_open", "Open","./images/Open.png","Open Button");

    DisplayButton("f_save", "Save","./images/Save.png","Save Button");
}
function drawEditDropDown()
{
    DisplayLabel("Find");
    DisplayTextBox("text","f_searchBox","10", "","");

    echo "<br>";
    DisplayLabel("Case Sensitive");
    DisplayTextBox("checkbox", "f_caseCheckBox", "10", "Case Sensitive","" );

    DisplayButton("f_find", "Find","./images/Find.png","Find Button");
}
function saveFile($Text)
{
    $textFile = fopen("editor.dat","w+");
    $successSave=false;

    if($textFile)
    {

        $successSave=fwrite($textFile,$Text);
    }

    if($successSave)
    {
        echo "<p>File saved.</p>";
    }else{
        echo "<p>Error saving file.</p>";
    }
    fclose($textFile);
}
function openFile()
{
    $Text="";
    $textFile = fopen("editor.dat","r");
    if($textFile)
    {
        echo "<p>File opened.</p>";
        while(!feof($textFile)){
            $Text .= fgets($textFile);
        }
    }
    else{
        echo "<p>Error opening file.</p>";
        $exist=file_exists($textFile);
        if(!$exist)
        {
            echo "<p>Editor.dat does not exist. Please save file first</p>";
        }
    }
    fclose($textFile);
    return $Text;
}
function findTextInFile($string)
{
    $blankCheck = trim($string);
    $example = $_POST["f_textarea"];

    $found_it= false;
    if($blankCheck == "")
        echo "Please input into text box";
    else
    {
        if (isset($_POST['f_caseCheckBox']))
            $found_it = strpos($example, $string);
        else
            $found_it = stripos($example, $string);
        if($found_it !== false)
        {
            $found_it+=1;
            echo "$string was found at position $found_it";
        }
        else
            echo "$string was not found";
    }
}

function drawFontDropDown()
{
    $mysqlObj = CreateConnectionObject();
    $TableName = "fontNames";
    $mysqlObj = CreateConnectionObject();
    $query = "select * from $TableName ";
    $stmtObj = $mysqlObj->prepare($query);
    $stmtObj -> execute();
    $stmtObj->store_result();
    $BindResult = $stmtObj->bind_result($fontName);
    $RowNum = $stmtObj->num_rows();


    echo "<div>";
    DisplayLabel("Font");
    echo " <select id = \"f_font\" size = \"$RowNum\" onchange=\"
           changeFont(this.value)\">";
    while ($stmtObj->fetch())
    {
        echo "<option value = \"$fontName\"> $fontName </option>";
    }
    echo "</select>";

    $mysqlObj->close();
    $stmtObj->close();

    DisplayLabel("Size");
    echo "
        <select id = \"f_fontSize\" Size = \"3\" onchange=\"
        changeSize(this.value)\">
            <option value = \"small\"> Small </option>
            <option value = \"medium\"> Medium </option>
            <option value = \"large\"> Large </option>
        </select>
    ";
}

//main
WriteHeaders("TeamCoding Assignment","OurSite", "groupStyle.css");

echo "<form action = ? method = post>";
    $userInput="";
    if(isset($_POST["f_save"]))
    {
        saveFile($_POST["f_textarea"]);
        $userInput = $_POST["f_textarea"];
    }
    elseif(isset($_POST["f_open"]))
    {
        $userInput = openFile();
    }
    elseif(isset($_POST["f_new"]))
    {
      
        $_POST["f_textarea"] = "";
    }
    elseif(isset($_POST["f_find"]))
    {
        findTextInFile($_POST["f_searchBox"]);
        $userInput = $_POST["f_textarea"];
    }
     else
    {
         $_POST["f_textarea"]="";
    }

    DrawMenu();
    if($userInput=="")
    {
    echo "<textarea class= changeText name = \"f_textarea\" type = text
        rows = 10 wrap = hard spellcheck = true autofocus
         placeholder = \"enter text here\"></textarea>";
        }
    else{
        echo "<textarea class= changeText name = \"f_textarea\" type = text
        rows = 10 wrap = hard spellcheck = true autofocus
         placeholder = \"enter text here\">$userInput </textarea>";
    }
WriteFooters();
?>