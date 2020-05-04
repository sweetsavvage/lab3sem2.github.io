<!DOCTYPE html>
<html lang="en">
    <head>
  <meta charset="UTF-8">
  <title>Lb3 Nazarenko</title>
  <style>
            input, select {
                display: block;
                margin-bottom: 15px;
            }
            div {
               border: 1px solid black;
               padding: 5px;
            }
           p{
               font-size:18px;
           }
        </style>

  <script>
        const ajax = new XMLHttpRequest();

        function get1(){
            let name = document.getElementById("author").value;
            ajax.onreadystatechange = update1;
            ajax.open("GET", "./php/getBooksByAuthor.php?name="+ name);
            
            ajax.send(null);
        }

          function update1(){
            if(ajax.readyState === 4){
              if(ajax.status === 200){
                var text = document.getElementById('authorTable');
                var res = "";
                let books = ajax.responseXML.firstChild.children;
                for(var i = 0; i < books.length; i++){
                  res += "<tr>";
                  res += "<td>" + books[i].children[0].firstChild.nodeValue + "</td>";
                  res += "<tr>";
                }
                text.innerHTML = res;
              }
            }
          }


        function get2(){

        let yearStart = document.getElementById("yearStart").value;
        let yearEnd = document.getElementById("yearEnd").value;
          ajax.onreadystatechange = update2;
          ajax.open("GET", "./php/getBooksByYears.php?yearStart="+ yearStart +"&yearEnd=" + yearEnd);
          
          ajax.send(null);
        }

        function update2(){
          if(ajax.readyState === 4){
            if(ajax.status === 200){
              var text = document.getElementById('rangetable');
              text.innerHTML = ajax.responseText;
            }
          }
        }


        function get3(){
            let publisher = document.getElementById("publisher").value;
            ajax.onreadystatechange = update3;
            ajax.open("GET", "./php/getBooksByPublisher.php?publisher="+ publisher);
            
            ajax.send(null);
        }

          function update3(){
            if(ajax.readyState === 4){
              if(ajax.status === 200){
                var text = document.getElementById('publishertable');
                var res = ajax.responseText;
                var resHtml ="";
                res = JSON.parse(res);

                res.forEach(el =>{
                resHtml += "<tr><td style = 'border: 1px solid'>" + el +"</td></tr>"
                });
                
              text.innerHTML = resHtml;
              }
            }
          }
        </script>
        </head>

        <body>

        <div class="Tasks">
        <div class="Task1">
            <p>Найти книги по автору</p>
        <?php
        include("./php/dbConnect.php");

        $authorSql = 'SELECT `name` FROM `authors`';

        echo '<form method="get">';

        echo "<select id='author'><option> Выбрать автора </option>";

        foreach($db->query($authorSql) as $row) {
            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
        }

        echo "</select>";
        echo '<input type="button" onclick= "get1()" value="ОК"><br>';
        echo "</form>";
        ?>

        <table style="border: 1px solid"><tr><th>Название книги</th></tr>
        <tbody id = "authorTable"></tbody></table>

        </div>

        <div class="Task2">
        <p>Найти литературу по дате издания</p>

        <?php
        // устанавливаем первый и последний год диапазона
        $yearArray = range(1900, 2021);
        echo '<form method="get">';

        echo "<select id = 'yearStart'><option> От</option>";

          foreach ($yearArray as $year) {
            echo '<option '.$year.' value="'.$year.'">'.$year.'</option>';
          }
            echo "</select>";

        echo "<select id ='yearEnd'><option> До</option>";

            foreach ($yearArray as $year) {
                echo '<option '.$year.' value="'.$year.'">'.$year.'</option>';
            }
            echo "</select>";
        echo '<input type="button" onclick = "get2()" value="ОК"><br>';
        echo '</form>';
        ?>
        <table style="border: 1px solid"><tr><th>Название книги</th></tr>
        <tbody id = "rangetable"></tbody></table>

          </div>

          <div class="Task3">
        
          <p>Найти книги по издательству</p>

        <?php
        include("./php/dbConnect.php");

        $publisherSql = 'SELECT DISTINCT `publisher` FROM `literature`';

        echo '<form method="get" action= "./php/getBooksByPublisher.php">';

        echo "<select id ='publisher'><option> Выбрать издательство </option>";

        foreach($db->query($publisherSql) as $row) {
            echo "<option value='" . $row['publisher'] . "'>" . $row['publisher'] . "</option>";
        }

        echo "</select>";
        echo '<input type="button" onclick = "get3()" value="ОК"><br>';
        echo "</form>";
        ?>
        <table style="border: 1px solid"><tr><th>Название книги</th></tr>
        <tbody id = "publishertable"></tbody></table>
        </div>

    </div>

</body>
</html>



