<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.8.2/css/bulma.min.css">
    <style>
        /* Make the table responsive by using media queries */
        @media only screen and (max-width: 600px) {
            table {
                width: 100%;
            }
        }

        table {
            border-collapse: collapse;
            width: 80%; /* Reduce the width of the table */
            margin: 0 auto; /* Center the table on the page */
        }

        /* Add some basic styles for the table cells */
        th, td {
            border: 3px solid #dddddd;
            text-align: left;
            padding: 8px;
            text-align: center;
        }

        /* Add a hover effect for the table rows */
        tr:hover {
            background-color: #f2f2f2;
        }

        /* Make the input fields take up less space */
        input[type=number] {
            width: 50px;
            height: 30px;
        }
        
        /* Add a class to highlight a row */
        .highlight {
            background-color: yellow!important;
        }

        /* Add some basic styles for the buttons */
        .buttons {
            display: flex;
            justify-content: center;
            margin: 16px 0;
        }

        button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin: 0 8px;
        }

        /* Add some basic styles for the result paragraphs */
        p {
            font-size: 1.2rem;
            margin: 8px 0;
        }

        h1{
            text-align:center;
        }
    </style>
  </head>
  <body>
    <br>
    <h1 class="title is-3">Measures of Central Tendency Calculator</h1>
    <br>
    <div style="overflow-x:auto;">
        <table id="myTable" class="table is-striped is-bordered">
        <thead>
        <tr>
            <th>Class</th>
            <th>Class Boundaries</th>
            <th>Frequency</th>
            <th>Class Midpoints (Xm)</th>
            <th>f*Xm</th>
            <th>Comulative Frequency</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input type="number" id="class" name="lower-class-limit"> - <input type="number" id="class" name="upper-class-limit"></td>
            <td></td>
            <td><input type="number" id="frequency" name="frequency"></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
        </table>
    </div>
    <div class="buttons">
        <button class="button is-primary" onclick="addRow()">Add Row</button>
        <button class="button is-danger" onclick="deleteRow()">Delete Row</button>
        <button class="button is-info" onclick="calculate()">Calculate</button>
    </div>
    <div class="container">
        <p id="fsum"></p>
        <p id="fXmsum"></p>
        <p id="mean"></p>
        <p id="median-class"></p>
        <p id="median"></p>
        <p id="mode"></p>
    </div>


    <script>
    function addRow() {
        var table = document.getElementById("myTable");
        var row = table.insertRow(-1);
        var score = row.insertCell(0);
        var boundaries = row.insertCell(1);
        var frequency = row.insertCell(2);
        var midpoint = row.insertCell(3);
        var fXm = row.insertCell(4);
        var cumulative = row.insertCell(5);
        score.innerHTML = '<input type="number" id="class" name="lower-class-limit"> - <input type="number" id="class" name="upper-class-limit">';
        frequency.innerHTML = '<input type="number" id="frequency" name="frequency">';
    }

    function deleteRow() {
        var table = document.getElementById("myTable");
        var rowCount = table.rows.length;
        if (rowCount > 2) {
        table.deleteRow(-1);
        } else {
        alert("Cannot delete all rows");
        }
    }

    function main(){
        var lower_class_limits = document.getElementsByName("lower-class-limit");
        var upper_class_limits = document.getElementsByName("upper-class-limit");
        frequency = document.getElementsByName("frequency");
        for (var i = 0; i<lower_class_limits.length; i++){
            class_boundaries = document.getElementById('myTable').rows[i+1].cells[1];
            class_boundaries.innerHTML = parseFloat(lower_class_limits[i].value) - parseFloat(0.5);
            class_boundaries.innerHTML += ' - ';
            class_boundaries.innerHTML += parseFloat(upper_class_limits[i].value) + parseFloat(0.5);

            // Class Midpoints (Xm)
            class_midpoints = document.getElementById('myTable').rows[i+1].cells[3];
            class_midpoints.innerHTML = (parseFloat(lower_class_limits[i].value) + parseFloat(upper_class_limits[i].value))/2;

            // Frequency (f) * Midpoint (Xm)
            fXm = document.getElementById('myTable').rows[i+1].cells[4];
            fXm.innerHTML = frequency[i].value * class_midpoints.innerText;
        }
        
        if(lower_class_limits[lower_class_limits.length-1].value < lower_class_limits[0].value){
            // Comulative Frequency
            flag = 0;
            for (var i = frequency.length - 1; i >= 0; i--) {
                cf_raw = document.getElementById('myTable');
                cf = document.getElementById('myTable').rows[i+1].cells[5];
                if(flag == 0){
                    cf.innerHTML = parseFloat(frequency[i].value);
                    flag++;
                    continue;
                }
                cf.innerHTML = parseFloat(frequency[i].value) + parseFloat(cf_raw.rows[i+2].cells[5].innerText);
            }
        } else{
            // Comulative Frequency
            flag = 0;
            for (var i = 0; i < frequency.length; i++) {
                cf_raw = document.getElementById('myTable');
                cf = document.getElementById('myTable').rows[i+1].cells[5];
                if(flag == 0){
                    cf.innerHTML = parseFloat(frequency[i].value);
                    flag++;
                    continue;
                }
                cf.innerHTML = parseFloat(frequency[i].value) + parseFloat(cf_raw.rows[i].cells[5].innerText);
            }
        }
    }

    function summations() {
        var frequency = document.getElementsByName("frequency");
        var frequency_sum = 0;
        for (var i = 0; i < frequency.length; i++) {
            frequency_sum += parseFloat(frequency[i].value);
        }

        var fXmCells = document.querySelectorAll("#myTable td:nth-child(5)");
        var fXm_sum = 0;
        fXmCells.forEach(function(cell) {
            fXm_sum += parseInt(cell.textContent);
        });

        document.getElementById("fsum").innerHTML = "Summation of Frequency: <strong>" + frequency_sum + "</strong>";
        document.getElementById("fXmsum").innerHTML = "Summation of f*Xm: <strong>" + fXm_sum + "</strong>";

        mean(fXm_sum, frequency_sum);
        median(frequency_sum);
    }

    function mean(fXm_sum, frequency_sum){
        var mean = fXm_sum/frequency_sum;
        document.getElementById("mean").innerHTML = "Mean = " + mean + " = <strong>" + mean.toFixed(2) + "</strong>";
    }

    function median(frequency_sum){
        // Median Class
        var lower_class_limits = document.getElementsByName("lower-class-limit");
        var upper_class_limits = document.getElementsByName("upper-class-limit");
        let table = document.getElementById("myTable");
        var median_class = frequency_sum/2;
        document.getElementById("median-class").innerHTML = "Median Class = " + median_class + " = <strong>" + median_class.toFixed(2) + "</strong>";
        var cfCells = document.querySelectorAll("#myTable td:nth-child(6)");
        var frequency = document.getElementsByName("frequency");
        if(lower_class_limits[lower_class_limits.length-1].value < lower_class_limits[0].value){
            for (var i = cfCells.length - 1; i >= 0; i--) {
                cf = cfCells[i].textContent;
                if (cf > median_class) {
                    var highlighted_row = table.rows[i+1];
                    try{
                        var lower_cf = table.rows[i+2].cells[5].innerHTML;
                    } catch{
                        var lower_cf = 0;
                    }
                    try{
                        var highlighted_frequency_up = frequency[i-1].value;
                    }catch{
                        var highlighted_frequency_up = 0;
                    }
                    try{
                        var highlighted_frequency_down = frequency[i+1].value;
                    }catch{
                        var highlighted_frequency_down = 0;
                    }
                    var highlighted_frequency = frequency[i].value;
                    lower_class_limit = document.getElementsByName("lower-class-limit")[i].value;
                    upper_class_limit = document.getElementsByName("upper-class-limit")[i].value;
                    var interval = parseFloat(upper_class_limit - lower_class_limit + 1);
                    break;
                }
            }
        } else{
            for (let i = 0; i < cfCells.length; i++) {
                cf = cfCells[i].textContent;
                if (cf > median_class) {
                    var highlighted_row = table.rows[i+1];
                    try{
                        var lower_cf = table.rows[i+2].cells[5].innerHTML;
                    } catch{
                        var lower_cf = 0;
                    }
                    var highlighted_frequency = frequency[i].value;
                    try{
                        var highlighted_frequency_up = frequency[i-1].value;
                    }catch{
                        var highlighted_frequency_up = 0;
                    }
                    try{
                        var highlighted_frequency_down = frequency[i+1].value;
                    }catch{
                        var highlighted_frequency_down = 0;
                    }
                    var lower_class_limit = document.getElementsByName("lower-class-limit")[i].value;
                    var upper_class_limit = document.getElementsByName("upper-class-limit")[i].value;
                    var interval = parseFloat(upper_class_limit - lower_class_limit + 1);
                    break;
                }
            }
        }
        highlighted_row.classList.add("highlight");

        // Median
        lower_class_boundaries = highlighted_row.cells[1].innerHTML.split(' - ')[0];
        median = parseFloat(lower_class_boundaries) + ((parseFloat(frequency_sum/2) - parseFloat(lower_cf))/parseFloat(highlighted_frequency)) * parseFloat(interval);
        document.getElementById("median").innerHTML = "Median = " + median + " = <strong>" + median.toFixed(2) + "</strong>";
        
        mode(lower_class_limit, highlighted_frequency, highlighted_frequency_up, highlighted_frequency_down, interval);
    }

    function mode(lower_class_limit, highlighted_frequency, highlighted_frequency_up, highlighted_frequency_down, interval){
        var mode = (parseFloat(lower_class_limit)) + (parseFloat(parseFloat(highlighted_frequency) - parseFloat(highlighted_frequency_down))) / (parseFloat(parseFloat(highlighted_frequency) - parseFloat(highlighted_frequency_down) + parseFloat(highlighted_frequency) - parseFloat(highlighted_frequency_up))) * (parseFloat(interval));
        document.getElementById("mode").innerHTML = "Mode = " + mode + " = <strong>" + mode.toFixed(2) + "</strong>";
        console.log(lower_class_limit);
        console.log(highlighted_frequency);
        console.log(highlighted_frequency_up);
        console.log(highlighted_frequency_down);
        console.log(interval);
        console.log(mode);
    }

    function calculate(){
        const highlightElements = document.querySelectorAll('.highlight');
        highlightElements.forEach(element => element.classList.remove('highlight'));
        main();
        summations();
    }
    </script>
  </body>
</html>
