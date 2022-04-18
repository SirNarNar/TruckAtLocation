<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <style>
            table,td,th {border-style: hidden;}
        </style>
    </head>
    <body>
        <fieldset class="fieldset">
            <legend><h1>What Trucks Were Near Here?</h1></legend>
                <form action="TrucksInYard.php" method="get">
                    <table >
                        <tr>
                            <td>Date:</td>
                            <td><input type="date" name="date"></td>
                        </tr>
                        <tr>
                            <td>Start Time(24H):</td>
                            <td><input type="text" name="start" value="HH:MM:SS"></td>
                        </tr>
                        <tr>
                            <td>End Time(24H):</td>
                            <td><input type="text" name="end" value="HH:MM:SS"></td>
                        </tr>
                        <tr>
                            <td>Locatation:</td>
                            <td><select name="loc" id="loc" onchange="getOption()">
                                <option value="tide">Tidemore</option>
                                <option value="mcph">McPherson</option>
                                <option value="emer">Emerald</option>
                                <option value="other">Other</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td id="add3" hidden>Latitude:</td>
                            <td id="add" hidden><input type='text' name="lat" value="43.71257"></td>
                        </tr>
                        <tr>
                            <td id="add4" hidden>Longitude:</td>
                            <td id="add2" hidden><input type='text' name="lon" value="-79.58380"></td>
                        </tr>
                        <tr>
                        <td><input type="submit"></td>
                        </tr>
                    </table>
                </form>
            <code>Code is located at C:\Users\Staff\Downloads\Xampp\htdocs\scripts\WorkingCode\ on UPAK-TD1</code>
        </fieldset>
        <script>
            function getOption() 
            {
                if (document.getElementById('loc').value === 'other') 
                {
                    document.getElementById("add").hidden = false;
                    document.getElementById("add2").hidden = false;
                    document.getElementById("add3").hidden = false;
                    document.getElementById("add4").hidden = false;
                }
                else
                {
                    document.getElementById("add").hidden = true;
                    document.getElementById("add2").hidden = true;
                    document.getElementById("add3").hidden = true;
                    document.getElementById("add4").hidden = true;
                }
            }
        </script>
    </body>
</html>

        