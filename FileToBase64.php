<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <input type="file" id="selectFile" >
        <br>
        <div>
            Mirar el resultado en la consola
        </div>
        <script>

            document.getElementById('selectFile').onchange = (e) => {
                let file = e.target.files[0];
                getBase64(file);
            }

            function getBase64(file) {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    console.log(reader.result);
                }
                reader.onerror = function (error) {
                    console.log('Error: ', error);
                }
            }
        </script>
    </body>
</html>
